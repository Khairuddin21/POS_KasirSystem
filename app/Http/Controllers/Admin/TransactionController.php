<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Member;
use App\Models\Product;
use App\Exports\AdminTransactionExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $memberId = $request->input('member_id');
        $productId = $request->input('product_id');
        $paymentMethod = $request->input('payment_method');
        $userId = $request->input('user_id');

        // Base query
        $query = Transaction::with(['user', 'member', 'items.product'])
            ->whereBetween('created_at', [
                Carbon::parse($dateFrom)->startOfDay(),
                Carbon::parse($dateTo)->endOfDay()
            ]);

        // Apply filters
        if ($memberId) {
            $query->where('member_id', $memberId);
        }

        if ($paymentMethod) {
            $query->where('payment_method', $paymentMethod);
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($productId) {
            $query->whereHas('items', function($q) use ($productId) {
                $q->where('product_id', $productId);
            });
        }

        // Get transactions
        $transactions = $query->orderBy('created_at', 'desc')->get();

        // Calculate statistics
        $statistics = [
            'totalTransactions' => $transactions->count(),
            'totalRevenue' => $transactions->sum('total'),
            'totalItems' => $transactions->sum(function($transaction) {
                return $transaction->items->sum('quantity');
            }),
            'avgTransaction' => $transactions->count() > 0 ? $transactions->avg('total') : 0,
            'cashTransactions' => $transactions->where('payment_method', 'cash')->count(),
            'qrisTransactions' => $transactions->where('payment_method', 'qris')->count(),
            'cashRevenue' => $transactions->where('payment_method', 'cash')->sum('total'),
            'qrisRevenue' => $transactions->where('payment_method', 'qris')->sum('total'),
        ];

        // Get chart data - Daily revenue for date range
        $dailyRevenue = $this->getDailyRevenue($dateFrom, $dateTo);
        
        // Get top products
        $topProducts = $this->getTopProducts($dateFrom, $dateTo, $memberId, $productId);
        
        // Get payment method distribution
        $paymentDistribution = $transactions->groupBy('payment_method')->map(function($items, $method) {
            return [
                'method' => $method,
                'count' => $items->count(),
                'total' => $items->sum('total')
            ];
        })->values();

        // Get hourly distribution
        $hourlyDistribution = $this->getHourlyDistribution($dateFrom, $dateTo);

        // Get data for dropdowns
        $members = Member::orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        $cashiers = DB::table('users')
            ->where('role', 'kasir')
            ->orderBy('name')
            ->get();

        return view('admin.transactions.index', compact(
            'transactions',
            'statistics',
            'dailyRevenue',
            'topProducts',
            'paymentDistribution',
            'hourlyDistribution',
            'members',
            'products',
            'cashiers',
            'dateFrom',
            'dateTo',
            'memberId',
            'productId',
            'paymentMethod',
            'userId'
        ));
    }

    private function getDailyRevenue($dateFrom, $dateTo)
    {
        $startDate = Carbon::parse($dateFrom);
        $endDate = Carbon::parse($dateTo);
        $days = $startDate->diffInDays($endDate) + 1;

        // Limit to 31 days for chart readability
        if ($days > 31) {
            $days = 31;
            $startDate = $endDate->copy()->subDays(30);
        }

        $dailyData = collect();
        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $revenue = Transaction::whereDate('created_at', $date)->sum('total');
            $orders = Transaction::whereDate('created_at', $date)->count();

            $dailyData->push([
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('d M'),
                'revenue' => $revenue,
                'orders' => $orders
            ]);
        }

        return $dailyData;
    }

    private function getTopProducts($dateFrom, $dateTo, $memberId = null, $productId = null)
    {
        $query = DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->whereBetween('transactions.created_at', [
                Carbon::parse($dateFrom)->startOfDay(),
                Carbon::parse($dateTo)->endOfDay()
            ]);

        if ($memberId) {
            $query->where('transactions.member_id', $memberId);
        }

        if ($productId) {
            $query->where('transaction_items.product_id', $productId);
        }

        return $query->select(
                'products.name',
                'products.image',
                DB::raw('SUM(transaction_items.quantity) as total_sold'),
                DB::raw('SUM(transaction_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
    }

    private function getHourlyDistribution($dateFrom, $dateTo)
    {
        $transactions = Transaction::whereBetween('created_at', [
            Carbon::parse($dateFrom)->startOfDay(),
            Carbon::parse($dateTo)->endOfDay()
        ])->get();

        $hourlyData = collect();
        for ($hour = 0; $hour < 24; $hour++) {
            $count = $transactions->filter(function($transaction) use ($hour) {
                return Carbon::parse($transaction->created_at)->hour == $hour;
            })->count();

            $hourlyData->push([
                'hour' => sprintf('%02d:00', $hour),
                'count' => $count
            ]);
        }

        return $hourlyData;
    }

    public function exportPDF(Request $request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $memberId = $request->input('member_id');
        $productId = $request->input('product_id');
        $paymentMethod = $request->input('payment_method');
        $userId = $request->input('user_id');

        // Build query with same filters
        $query = Transaction::with(['user', 'member', 'items.product'])
            ->whereBetween('created_at', [
                Carbon::parse($dateFrom)->startOfDay(),
                Carbon::parse($dateTo)->endOfDay()
            ]);

        if ($memberId) {
            $query->where('member_id', $memberId);
        }
        if ($paymentMethod) {
            $query->where('payment_method', $paymentMethod);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }
        if ($productId) {
            $query->whereHas('items', function($q) use ($productId) {
                $q->where('product_id', $productId);
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        $statistics = [
            'totalTransactions' => $transactions->count(),
            'totalRevenue' => $transactions->sum('total'),
            'totalItems' => $transactions->sum(function($transaction) {
                return $transaction->items->sum('quantity');
            }),
            'avgTransaction' => $transactions->count() > 0 ? $transactions->avg('total') : 0,
            'cashRevenue' => $transactions->where('payment_method', 'cash')->sum('total'),
            'qrisRevenue' => $transactions->where('payment_method', 'qris')->sum('total'),
        ];

        $pdf = PDF::loadView('admin.transactions.pdf', compact(
            'transactions',
            'statistics',
            'dateFrom',
            'dateTo'
        ));

        $pdf->setPaper('a4', 'portrait');
        
        $filename = 'laporan-transaksi-' . date('YmdHis') . '.pdf';
        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $memberId = $request->input('member_id');
        $productId = $request->input('product_id');
        $paymentMethod = $request->input('payment_method');
        $userId = $request->input('user_id');

        // Build query with same filters
        $query = Transaction::with(['user', 'member', 'items.product'])
            ->whereBetween('created_at', [
                Carbon::parse($dateFrom)->startOfDay(),
                Carbon::parse($dateTo)->endOfDay()
            ]);

        if ($memberId) {
            $query->where('member_id', $memberId);
        }
        if ($paymentMethod) {
            $query->where('payment_method', $paymentMethod);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }
        if ($productId) {
            $query->whereHas('items', function($q) use ($productId) {
                $q->where('product_id', $productId);
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'laporan-transaksi-' . date('YmdHis') . '.xlsx';
        
        $export = new AdminTransactionExport($transactions, $dateFrom, $dateTo);
        return $export->download($filename);
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'member', 'items.product'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
    }
}
