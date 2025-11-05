<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Member;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

            // Update member points and rating if member was used
            if ($request->member_id) {
                $member = Member::find($request->member_id);
                if ($member) {
                    $member->addPurchase($total);
                    // Reload to get updated values
                    $member->refresh();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'transaction' => $transaction->load('items', 'member'),
                'member_used' => $request->member_id ? true : false,
                'member_info' => $request->member_id && isset($member) ? [
                    'name' => $member->name,
                    'code' => $member->member_code,
                    'points' => $member->points,
                    'rating' => $member->rating,
                    'rating_stars' => $member->rating_stars,
                    'total_spent' => $member->total_spent
                ] : null
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
        $page = $request->get('page', 1);
        $perPage = 10; // 10 items per page

        try {
            // Build date range
            $startDate = \Carbon\Carbon::parse($dateFrom)->startOfDay();
            $endDate = \Carbon\Carbon::parse($dateTo)->endOfDay();

            // For daily period ONLY: limit the visible data to the last 3 days (UI-only retention)
            // This avoids deleting any data and keeps monthly/yearly reports intact.
            if ($period === 'daily') {
                $minDailyDate = now()->copy()->subDays(2)->startOfDay(); // today and previous 2 days = 3 days window
                if ($startDate->lt($minDailyDate)) {
                    $startDate = $minDailyDate;
                }
                $maxDailyDate = now()->endOfDay();
                if ($endDate->gt($maxDailyDate)) {
                    $endDate = $maxDailyDate;
                }
            }

            // Get transactions for the period with pagination
            // Apply date filter AFTER deletion to show remaining data
            $transactionsQuery = Transaction::whereBetween('created_at', [$startDate, $endDate])
                ->where('user_id', Auth::id())
                ->with(['items', 'user', 'member'])
                ->orderBy('created_at', 'desc');

            // Get all for statistics and chart
            $allTransactions = $transactionsQuery->get();

            // Paginate for table
            $paginatedTransactions = (clone $transactionsQuery)->paginate($perPage);

            // Calculate statistics
            $statistics = [
                'totalTransactions' => $allTransactions->count(),
                'totalSales' => $allTransactions->sum('total'),
                'totalItems' => $allTransactions->sum(function($transaction) {
                    return $transaction->items->sum('quantity');
                }),
                'avgTransaction' => $allTransactions->count() > 0 ? $allTransactions->avg('total') : 0,
            ];

            // Prepare chart data based on period
            $chartData = $this->prepareChartData($allTransactions, $period, $startDate->toDateString(), $endDate->toDateString());

            // Format transaction data
            $data = $paginatedTransactions->map(function($transaction) {
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
                'pagination' => [
                    'current_page' => $paginatedTransactions->currentPage(),
                    'last_page' => $paginatedTransactions->lastPage(),
                    'per_page' => $paginatedTransactions->perPage(),
                    'total' => $paginatedTransactions->total(),
                    'from' => $paginatedTransactions->firstItem(),
                    'to' => $paginatedTransactions->lastItem(),
                ],
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

        $statistics = [
            'totalTransactions' => $transactions->count(),
            'totalSales' => $transactions->sum('total'),
            'totalItems' => $transactions->sum(function($transaction) {
                return $transaction->items->sum('quantity');
            }),
            'avgTransaction' => $transactions->count() > 0 ? $transactions->avg('total') : 0,
        ];

        // Generate CSV
        $filename = 'laporan-penjualan-' . $dateFrom . '-' . $dateTo . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($transactions, $statistics, $dateFrom, $dateTo) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, ['LAPORAN PENJUALAN KASIR']);
            fputcsv($file, ['Periode: ' . $dateFrom . ' s/d ' . $dateTo]);
            fputcsv($file, ['']);
            
            // Statistics
            fputcsv($file, ['Total Transaksi', $statistics['totalTransactions']]);
            fputcsv($file, ['Total Penjualan', 'Rp ' . number_format($statistics['totalSales'], 0, ',', '.')]);
            fputcsv($file, ['Total Item', $statistics['totalItems']]);
            fputcsv($file, ['Rata-rata', 'Rp ' . number_format($statistics['avgTransaction'], 0, ',', '.')]);
            fputcsv($file, ['']);
            
            // Table header
            fputcsv($file, [
                'No',
                'Kode Transaksi',
                'Tanggal',
                'Kasir',
                'Pelanggan',
                'Items',
                'Total',
                'Metode Bayar'
            ]);
            
            // Data
            foreach ($transactions as $index => $transaction) {
                fputcsv($file, [
                    $index + 1,
                    $transaction->transaction_code,
                    $transaction->created_at->format('d/m/Y H:i'),
                    $transaction->user->name,
                    $transaction->member ? $transaction->member->name : 'Umum',
                    $transaction->items->sum('quantity'),
                    'Rp ' . number_format($transaction->total, 0, ',', '.'),
                    ucfirst($transaction->payment_method)
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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

    public function dailyReport()
    {
        return view('kasir.report');
    }

    public function getDailyReportData(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        $userId = Auth::id();

        try {
            // Get user profile
            $user = Auth::user();
            $profile = [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'member_since' => $user->created_at->format('d M Y'),
            ];

            // Get today's transactions
            $todayStart = \Carbon\Carbon::parse($date)->startOfDay();
            $todayEnd = \Carbon\Carbon::parse($date)->endOfDay();

            $transactions = Transaction::whereBetween('created_at', [$todayStart, $todayEnd])
                ->where('user_id', $userId)
                ->with(['items'])
                ->orderBy('created_at', 'asc')
                ->get();

            // Calculate daily statistics
            $statistics = [
                'totalTransactions' => $transactions->count(),
                'totalSales' => $transactions->sum('total'),
                'totalItems' => $transactions->sum(function($transaction) {
                    return $transaction->items->sum('quantity');
                }),
                'avgTransaction' => $transactions->count() > 0 ? $transactions->avg('total') : 0,
                'cashTransactions' => $transactions->where('payment_method', 'cash')->count(),
                'cardTransactions' => $transactions->where('payment_method', 'card')->count(),
                'qrisTransactions' => $transactions->where('payment_method', 'qris')->count(),
                'transferTransactions' => $transactions->where('payment_method', 'transfer')->count(),
            ];

            // Hourly activity chart (group by hour)
            $hourlyData = [];
            for ($hour = 0; $hour < 24; $hour++) {
                $hourlyData[$hour] = [
                    'hour' => str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00',
                    'transactions' => 0,
                    'sales' => 0,
                ];
            }

            foreach ($transactions as $transaction) {
                $hour = (int) $transaction->created_at->format('H');
                $hourlyData[$hour]['transactions']++;
                $hourlyData[$hour]['sales'] += $transaction->total;
            }

            // Recent transactions
            $recentTransactions = $transactions->take(10)->map(function($transaction) {
                return [
                    'id' => $transaction->id,
                    'transaction_code' => $transaction->transaction_code,
                    'time' => $transaction->created_at->format('H:i:s'),
                    'items_count' => $transaction->items->sum('quantity'),
                    'total' => $transaction->total,
                    'payment_method' => $transaction->payment_method,
                ];
            });

            return response()->json([
                'success' => true,
                'profile' => $profile,
                'statistics' => $statistics,
                'hourlyData' => array_values($hourlyData),
                'recentTransactions' => $recentTransactions,
                'date' => $date,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data: ' . $e->getMessage()
            ], 500);
        }
    }
}
