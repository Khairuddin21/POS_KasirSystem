@extends('layouts.kasir')

@section('title', 'Kasir Dashboard - POS Kasir')

@section('page-title', 'Dashboard Kasir')
@section('page-description', 'Mulai transaksi baru atau lihat ringkasan harian Anda')

@section('content')
<div class="space-y-6">
    <!-- Quick Stats -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Today's Sales</p>
                    <h3 class="text-3xl font-bold text-gray-800">Rp 2.5M</h3>
                    <p class="text-green-600 text-sm mt-1">32 transactions</p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Transactions</p>
                    <h3 class="text-3xl font-bold text-gray-800">32</h3>
                    <p class="text-gray-600 text-sm mt-1">Today</p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Average Ticket</p>
                    <h3 class="text-3xl font-bold text-gray-800">Rp 78K</h3>
                    <p class="text-gray-600 text-sm mt-1">Per transaction</p>
                </div>
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Quick Actions</h3>
        <div class="grid md:grid-cols-4 gap-4">
            <button class="p-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl text-white hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <p class="font-bold">New Transaction</p>
            </button>
            
            <button class="p-6 bg-gradient-to-br from-green-500 to-green-600 rounded-xl text-white hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="font-bold">View History</p>
            </button>
            
            <button class="p-6 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl text-white hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <p class="font-bold">Cash Report</p>
            </button>
            
            <button class="p-6 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl text-white hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <p class="font-bold">Print Receipt</p>
            </button>
        </div>
    </div>
    
    <!-- Recent Transactions -->
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Recent Transactions</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold">ID</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold">Time</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold">Items</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold">Total</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold">Payment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">#TRX001</td>
                        <td class="py-3 px-4">10:35 AM</td>
                        <td class="py-3 px-4">5 items</td>
                        <td class="py-3 px-4 font-bold">Rp 125,000</td>
                        <td class="py-3 px-4"><span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Cash</span></td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">#TRX002</td>
                        <td class="py-3 px-4">10:28 AM</td>
                        <td class="py-3 px-4">3 items</td>
                        <td class="py-3 px-4 font-bold">Rp 75,000</td>
                        <td class="py-3 px-4"><span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">Debit</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
