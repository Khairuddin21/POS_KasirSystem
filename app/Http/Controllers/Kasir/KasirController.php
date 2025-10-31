<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Exports\KasirTransactionExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class KasirController extends Controller
{
    public function dashboard()
    {
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $products = Product::where('is_active', true)->with('category')->get();
        
        return view('kasir.dashboard', compact('categories', 'products'));
    }

    public function getProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)
            ->where('is_active', true)
            ->get();
        
        return response()->json($products);
    }

    public function processTransaction(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,card,qris,transfer',
            'paid' => 'required|numeric|min:0',
            'member_id' => 'nullable|exists:members,id',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $items = [];

            // Calculate subtotal and prepare items
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Check stock
                if ($product->stock < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stock {$product->name} tidak mencukupi!"
                    ], 400);
                }

                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $itemSubtotal
                ];
            }

            $tax = $subtotal * 0.1; // 10% tax
            $total = $subtotal + $tax;
            $change = $request->paid - $total;

            if ($change < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran tidak mencukupi!'
                ], 400);
            }

            // Create transaction
            $transaction = Transaction::create([
                'transaction_code' => 'TRX-' . date('Ymd') . '-' . str_pad(Transaction::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => Auth::id(),
                'member_id' => $request->member_id,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'paid' => $request->paid,
                'change' => $change,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'notes' => $request->notes ?? null,
            ]);

            // Create transaction items and update stock
            foreach ($items as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'price' => $item['product']->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Update stock
                $item['product']->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'transaction' => $transaction->load('items'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function history()
    {
        return view('kasir.history');
    }

    public function getReportData(Request $request)
    {
        $period = $request->get('period', 'daily');
        $dateFrom = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('to', now()->format('Y-m-d'));

        try {
            // Get transactions for the period
            $transactions = Transaction::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
                ->where('user_id', Auth::id())
                ->with(['items', 'user', 'member'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Calculate statistics
            $statistics = [
                'totalTransactions' => $transactions->count(),
                'totalSales' => $transactions->sum('total'),
                'totalItems' => $transactions->sum(function($transaction) {
                    return $transaction->items->sum('quantity');
                }),
                'avgTransaction' => $transactions->count() > 0 ? $transactions->avg('total') : 0,
            ];

            // Prepare chart data based on period
            $chartData = $this->prepareChartData($transactions, $period, $dateFrom, $dateTo);

            // Format transaction data
            $data = $transactions->map(function($transaction) {
                return [
                    'id' => $transaction->id,
                    'transaction_code' => $transaction->transaction_code,
                    'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
                    'cashier_name' => $transaction->user->name,
                    'customer_name' => $transaction->member ? $transaction->member->name : null,
                    'total_items' => $transaction->items->sum('quantity'),
                    'total' => $transaction->total,
                    'payment_method' => $transaction->payment_method,
                ];
            });

            return response()->json([
                'success' => true,
                'statistics' => $statistics,
                'chartData' => $chartData,
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data: ' . $e->getMessage()
            ], 500);
        }
    }

    private function prepareChartData($transactions, $period, $dateFrom, $dateTo)
    {
        $labels = [];
        $values = [];

        if ($period === 'daily') {
            // Group by date
            $start = \Carbon\Carbon::parse($dateFrom);
            $end = \Carbon\Carbon::parse($dateTo);

            while ($start->lte($end)) {
                $date = $start->format('Y-m-d');
                $labels[] = $start->format('d M');
                
                $dailyTotal = $transactions->filter(function($transaction) use ($date) {
                    return $transaction->created_at->format('Y-m-d') === $date;
                })->sum('total');
                
                $values[] = $dailyTotal;
                $start->addDay();
            }
        } elseif ($period === 'monthly') {
            // Group by month
            $start = \Carbon\Carbon::parse($dateFrom)->startOfMonth();
            $end = \Carbon\Carbon::parse($dateTo)->endOfMonth();

            while ($start->lte($end)) {
                $labels[] = $start->format('M Y');
                
                $monthlyTotal = $transactions->filter(function($transaction) use ($start) {
                    return $transaction->created_at->format('Y-m') === $start->format('Y-m');
                })->sum('total');
                
                $values[] = $monthlyTotal;
                $start->addMonth();
            }
        } elseif ($period === 'yearly') {
            // Group by year
            $start = \Carbon\Carbon::parse($dateFrom)->startOfYear();
            $end = \Carbon\Carbon::parse($dateTo)->endOfYear();

            while ($start->lte($end)) {
                $labels[] = $start->format('Y');
                
                $yearlyTotal = $transactions->filter(function($transaction) use ($start) {
                    return $transaction->created_at->format('Y') === $start->format('Y');
                })->sum('total');
                
                $values[] = $yearlyTotal;
                $start->addYear();
            }
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    public function getTransactionDetail($id)
    {
        try {
            $transaction = Transaction::with(['items', 'user', 'member'])
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'transaction' => [
                    'id' => $transaction->id,
                    'transaction_code' => $transaction->transaction_code,
                    'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
                    'cashier_name' => $transaction->user->name,
                    'customer_name' => $transaction->member ? $transaction->member->name : null,
                    'subtotal' => $transaction->subtotal,
                    'tax' => $transaction->tax,
                    'total' => $transaction->total,
                    'paid' => $transaction->paid,
                    'change' => $transaction->change,
                    'payment_method' => $transaction->payment_method,
                    'items' => $transaction->items->map(function($item) {
                        return [
                            'product_name' => $item->product_name,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'subtotal' => $item->subtotal,
                        ];
                    }),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }
    }

    public function exportExcel(Request $request)
    {
        $period = $request->get('period', 'daily');
        $dateFrom = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('to', now()->format('Y-m-d'));

        $transactions = Transaction::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->where('user_id', Auth::id())
            ->with(['items', 'user', 'member'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Excel::download(
            new KasirTransactionExport($transactions, $dateFrom, $dateTo),
            'laporan-penjualan-' . $dateFrom . '-' . $dateTo . '.xlsx'
        );
    }

    public function exportPDF(Request $request)
    {
        $period = $request->get('period', 'daily');
        $dateFrom = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('to', now()->format('Y-m-d'));

        $transactions = Transaction::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->where('user_id', Auth::id())
            ->with(['items', 'user', 'member'])
            ->orderBy('created_at', 'desc')
            ->get();

        $statistics = [
            'totalTransactions' => $transactions->count(),
            'totalSales' => $transactions->sum('total'),
            'totalItems' => $transactions->sum(function($transaction) {
                return $transaction->items->sum('quantity');
            }),
            'avgTransaction' => $transactions->count() > 0 ? $transactions->avg('total') : 0,
        ];

        $pdf = Pdf::loadView('kasir.reports.pdf', [
            'transactions' => $transactions,
            'statistics' => $statistics,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'cashier' => Auth::user()->name,
        ]);

        return $pdf->download('laporan-penjualan-' . $dateFrom . '-' . $dateTo . '.pdf');
    }
}
