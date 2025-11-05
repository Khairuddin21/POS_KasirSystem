<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Member;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get date ranges
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $lastMonth = Carbon::now()->subMonth();
        
        // ========== TOTAL REVENUE ==========
        $totalRevenue = Transaction::sum('total');
        $lastMonthRevenue = Transaction::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('total');
        $currentMonthRevenue = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');
        
        $revenueGrowth = 0;
        if ($lastMonthRevenue > 0) {
            $revenueGrowth = (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        } elseif ($currentMonthRevenue > 0) {
            $revenueGrowth = 100;
        }
        
        // ========== TOTAL ORDERS ==========
        $totalOrders = Transaction::count();
        $lastMonthOrders = Transaction::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();
        $currentMonthOrders = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        $ordersGrowth = 0;
        if ($lastMonthOrders > 0) {
            $ordersGrowth = (($currentMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100;
        } elseif ($currentMonthOrders > 0) {
            $ordersGrowth = 100;
        }
        
        // ========== TOTAL MEMBERS ==========
        $totalMembers = Member::count();
        $newMembersThisMonth = Member::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // ========== ACTIVE CASHIERS ==========
        $totalCashiers = User::where('role', 'kasir')->count();
        
        // Cashiers who made transactions today
        $activeCashiersToday = Transaction::whereDate('created_at', $today)
            ->distinct('user_id')
            ->count('user_id');
        
        // ========== REVENUE CHART DATA (Last 7 Days) ==========
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $revenue = Transaction::whereDate('created_at', $date)
                ->sum('total');
            
            $last7Days->push([
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('D'),
                'revenue' => $revenue
            ]);
        }
        
        // ========== ORDERS CHART DATA (Last 7 Days) ==========
        $ordersLast7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $orders = Transaction::whereDate('created_at', $date)
                ->count();
            
            $ordersLast7Days->push([
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('D'),
                'orders' => $orders
            ]);
        }
        
        // ========== TOP SELLING PRODUCTS ==========
        $topProducts = DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->select(
                'products.name',
                DB::raw('SUM(transaction_items.quantity) as total_sold'),
                DB::raw('SUM(transaction_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();
        
        // ========== PAYMENT METHODS DISTRIBUTION ==========
        $paymentMethods = Transaction::select('payment_method', DB::raw('count(*) as total'))
            ->groupBy('payment_method')
            ->get();
        
        // ========== RECENT TRANSACTIONS ==========
        $recentTransactions = Transaction::with(['user', 'member'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // ========== MONTHLY REVENUE CHART (Last 6 Months) ==========
        $monthlyRevenue = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Transaction::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total');
            
            $monthlyRevenue->push([
                'month' => $date->format('M Y'),
                'revenue' => $revenue
            ]);
        }
        
        // ========== LOW STOCK PRODUCTS ==========
        $lowStockProducts = Product::where('stock', '<', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();
        
        // ========== TODAY'S SUMMARY ==========
        $todayRevenue = Transaction::whereDate('created_at', $today)->sum('total');
        $todayOrders = Transaction::whereDate('created_at', $today)->count();
        $todayCustomers = Transaction::whereDate('created_at', $today)
            ->distinct('member_id')
            ->count('member_id');
        
        return view('admin.dashboard', compact(
            'totalRevenue',
            'revenueGrowth',
            'totalOrders',
            'ordersGrowth',
            'totalMembers',
            'newMembersThisMonth',
            'totalCashiers',
            'activeCashiersToday',
            'last7Days',
            'ordersLast7Days',
            'topProducts',
            'paymentMethods',
            'recentTransactions',
            'monthlyRevenue',
            'lowStockProducts',
            'todayRevenue',
            'todayOrders',
            'todayCustomers'
        ));
    }
    
    public function getDashboardData()
    {
        // API endpoint for dynamic updates if needed
        return response()->json([
            'success' => true,
            'data' => [
                'revenue' => Transaction::sum('total'),
                'orders' => Transaction::count(),
                'members' => Member::count(),
                'cashiers' => User::where('role', 'kasir')->count()
            ]
        ]);
    }
}
