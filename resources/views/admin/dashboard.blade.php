@extends('layouts.admin')

@section('title', 'Admin Dashboard - POS Kasir')

@section('page-title', 'Dashboard')
@section('page-description', 'Welcome back, Admin! Here\'s what\'s happening today.')

@section('content')
<div class="space-y-6 overflow-hidden">
    <!-- Stats Cards -->
    <div class="grid md:grid-cols-4 gap-6">
        <!-- Total Revenue -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-cyan-500 transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Total Revenue</p>
                    <h3 class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-{{ $revenueGrowth >= 0 ? 'green' : 'red' }}-600 text-sm mt-1">
                        {{ $revenueGrowth >= 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}% from last month
                    </p>
                </div>
                <div class="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Orders -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-500 transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Total Orders</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ number_format($totalOrders) }}</h3>
                    <p class="text-{{ $ordersGrowth >= 0 ? 'green' : 'red' }}-600 text-sm mt-1">
                        {{ $ordersGrowth >= 0 ? '+' : '' }}{{ number_format($ordersGrowth, 1) }}% from last month
                    </p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Members -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-purple-500 transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Total Members</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ number_format($totalMembers) }}</h3>
                    <p class="text-green-600 text-sm mt-1">+{{ $newMembersThisMonth }} new this month</p>
                </div>
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Active Cashiers -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-green-500 transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Active Cashiers</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $activeCashiersToday }}/{{ $totalCashiers }}</h3>
                    <p class="text-gray-600 text-sm mt-1">Working today</p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Today's Summary -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-2xl shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm mb-1">Today's Revenue</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
                </div>
                <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 rounded-2xl shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Today's Orders</p>
                    <h3 class="text-2xl font-bold">{{ number_format($todayOrders) }}</h3>
                </div>
                <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-2xl shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Today's Customers</p>
                    <h3 class="text-2xl font-bold">{{ number_format($todayCustomers) }}</h3>
                </div>
                <svg class="w-12 h-12 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Charts & Activity -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Revenue Overview Chart -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Revenue Overview (Last 7 Days)</h3>
            <div style="position: relative; height: 300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        
        <!-- Orders Chart -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Orders Trend (Last 7 Days)</h3>
            <div style="position: relative; height: 300px;">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Monthly Revenue Chart -->
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Monthly Revenue (Last 6 Months)</h3>
        <div style="position: relative; height: 350px;">
            <canvas id="monthlyRevenueChart"></canvas>
        </div>
    </div>
    
    <!-- Top Products & Payment Methods -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Top Selling Products -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Top Selling Products</h3>
            <div class="space-y-3">
                @forelse($topProducts as $index => $product)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                            <p class="text-xs text-gray-600">{{ $product->total_sold }} units sold</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-600">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <p>No sales data available</p>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Payment Methods Distribution -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Payment Methods</h3>
            <div style="position: relative; height: 280px;">
                <canvas id="paymentMethodsChart"></canvas>
            </div>
            <div class="mt-4 space-y-2">
                @foreach($paymentMethods as $method)
                <div class="flex items-center justify-between p-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full payment-method-{{ $method->payment_method }}"></div>
                        <span class="text-sm text-gray-700 capitalize">{{ str_replace('_', ' ', $method->payment_method) }}</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-800">{{ $method->total }} orders</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Recent Transactions & Low Stock Alert -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Recent Transactions -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Recent Transactions</h3>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @forelse($recentTransactions as $transaction)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors border-b border-gray-100 last:border-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $transaction->transaction_code }}</p>
                            <p class="text-xs text-gray-600">
                                {{ $transaction->user->name }} • {{ $transaction->member ? $transaction->member->name : 'Guest' }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $transaction->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-600">Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
                        <span class="inline-block px-2 py-1 text-xs rounded-full 
                            @if($transaction->payment_method == 'cash') bg-green-100 text-green-700
                            @elseif($transaction->payment_method == 'card') bg-blue-100 text-blue-700
                            @elseif($transaction->payment_method == 'qris') bg-purple-100 text-purple-700
                            @else bg-orange-100 text-orange-700
                            @endif">
                            {{ ucfirst($transaction->payment_method) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <p>No transactions yet</p>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Low Stock Alert -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Low Stock Alert
            </h3>
            <div class="space-y-3">
                @forelse($lowStockProducts as $product)
                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                        <p class="text-xs text-gray-600">Category: {{ $product->category->name ?? 'N/A' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-red-600">{{ $product->stock }}</p>
                        <p class="text-xs text-red-500">units left</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <svg class="w-16 h-16 mx-auto text-green-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-600 font-semibold">All products are well stocked!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart (Last 7 Days)
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($last7Days->pluck('day')),
            datasets: [{
                label: 'Revenue (Rp)',
                data: @json($last7Days->pluck('revenue')),
                borderColor: 'rgb(6, 182, 212)',
                backgroundColor: 'rgba(6, 182, 212, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgb(6, 182, 212)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
    
    // Orders Chart (Last 7 Days)
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ordersCtx, {
        type: 'bar',
        data: {
            labels: @json($ordersLast7Days->pluck('day')),
            datasets: [{
                label: 'Orders',
                data: @json($ordersLast7Days->pluck('orders')),
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    
    // Monthly Revenue Chart
    const monthlyCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: @json($monthlyRevenue->pluck('month')),
            datasets: [{
                label: 'Monthly Revenue',
                data: @json($monthlyRevenue->pluck('revenue')),
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: 'rgb(16, 185, 129)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 3,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
    
    // Payment Methods Pie Chart
    const paymentCtx = document.getElementById('paymentMethodsChart').getContext('2d');
    const paymentData = @json($paymentMethods);
    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: paymentData.map(p => p.payment_method.charAt(0).toUpperCase() + p.payment_method.slice(1)),
            datasets: [{
                data: paymentData.map(p => p.total),
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(249, 115, 22, 0.8)'
                ],
                borderColor: [
                    'rgb(16, 185, 129)',
                    'rgb(59, 130, 246)',
                    'rgb(168, 85, 247)',
                    'rgb(249, 115, 22)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.4,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>

<style>
.payment-method-cash {
    background-color: rgb(16, 185, 129);
}
.payment-method-card {
    background-color: rgb(59, 130, 246);
}
.payment-method-qris {
    background-color: rgb(168, 85, 247);
}
.payment-method-transfer {
    background-color: rgb(249, 115, 22);
}
</style>
@endpush
@endsection
