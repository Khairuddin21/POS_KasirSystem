@extends('layouts.kasir')

@section('title', 'Daily Report - Kasir')

@section('content')
<div class="report-container min-h-screen bg-gray-50">
    <!-- Sidebar Component -->
    @include('components.kasir.sidebar')

    <!-- Main Content -->
    <div class="main-content p-8">
        <!-- Header -->
        <div class="header-section mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">📊 Daily Report</h1>
                    <p class="text-gray-600">Aktivitas dan performa harian Anda</p>
                </div>
                <div class="flex items-center gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tanggal</label>
                        <input type="date" id="reportDate" class="px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                    <div class="text-right mt-6">
                        <div id="currentDateTime" class="text-sm text-gray-600 font-medium"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="profile-card bg-gradient-to-r from-cyan-500 to-blue-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-4xl">
                        👤
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-1" id="profileName">Loading...</h2>
                        <p class="text-cyan-100 mb-1" id="profileEmail">-</p>
                        <div class="flex items-center gap-4 text-sm">
                            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full" id="profileRole">-</span>
                            <span class="opacity-90" id="profileMemberSince">Member since: -</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm opacity-90 mb-1">Total Transaksi Hari Ini</div>
                    <div class="text-4xl font-bold" id="profileTotalTransactions">0</div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <!-- Total Sales -->
            <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-5xl">💰</div>
                </div>
                <div class="text-3xl font-bold mb-1" id="totalSales">Rp 0</div>
                <div class="text-sm opacity-90">Total Penjualan</div>
            </div>

            <!-- Total Items -->
            <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-5xl">📦</div>
                </div>
                <div class="text-3xl font-bold mb-1" id="totalItems">0</div>
                <div class="text-sm opacity-90">Item Terjual</div>
            </div>

            <!-- Average Transaction -->
            <div class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-5xl">📈</div>
                </div>
                <div class="text-3xl font-bold mb-1" id="avgTransaction">Rp 0</div>
                <div class="text-sm opacity-90">Rata-rata Transaksi</div>
            </div>

            <!-- Payment Methods -->
            <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-5xl">💳</div>
                </div>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between">
                        <span class="opacity-90">Cash:</span>
                        <span class="font-semibold" id="cashCount">0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="opacity-90">Card:</span>
                        <span class="font-semibold" id="cardCount">0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="opacity-90">QRIS:</span>
                        <span class="font-semibold" id="qrisCount">0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="opacity-90">Transfer:</span>
                        <span class="font-semibold" id="transferCount">0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hourly Activity Chart -->
        <div class="chart-card bg-white rounded-2xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Per Jam</h2>
            <div class="chart-container" style="height: 350px;">
                <canvas id="hourlyChart"></canvas>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="table-card bg-white rounded-2xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Transaksi Terbaru</h2>
                <div class="text-sm text-gray-600">
                    <span id="transactionCount" class="font-semibold">0</span> transaksi hari ini
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full" id="transactionsTable">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b-2 border-blue-200">
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kode Transaksi</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Waktu</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Items</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Metode</th>
                        </tr>
                    </thead>
                    <tbody id="transactionsBody" class="divide-y divide-gray-200">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-12 hidden">
                <div class="text-6xl mb-4">📭</div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Transaksi</h3>
                <p class="text-gray-500">Belum ada transaksi pada tanggal yang dipilih</p>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="text-center py-12 hidden">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                <p class="text-gray-600 font-medium">Memuat data...</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .report-container {
        display: flex;
        font-family: 'Figtree', sans-serif;
    }

    .main-content {
        flex: 1;
        margin-left: 0;
        min-width: 0;
    }

    .profile-card {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card {
        animation: scaleIn 0.3s ease-out;
        transform-origin: center;
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    .chart-card, .table-card {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    #transactionsTable tbody tr {
        transition: all 0.2s ease;
    }

    #transactionsTable tbody tr:hover {
        background-color: #f8fafc;
        transform: scale(1.01);
    }

    /* Print Styles */
    @media print {
        .no-print,
        button,
        input[type="date"] {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
        }

        .stat-card,
        .chart-card,
        .table-card {
            page-break-inside: avoid;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ========== PREVENT APP.JS CONFLICTS ==========
(function() {
    'use strict';
    
// ========== GLOBAL VARIABLES ==========
let hourlyChart = null;

// ========== ROUTE URLS ==========
const URL_REPORT_DATA = "{{ route('kasir.report.data') }}";

// ========== INITIALIZE ==========
document.addEventListener('DOMContentLoaded', function() {
    console.log('Daily Report Page: Initializing...');
    initializeDateField();
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    // Small delay to ensure DOM is fully ready
    setTimeout(() => {
        console.log('Daily Report Page: Loading report...');
        loadReport();
    }, 100);
    
    // Date change listener
    const dateInput = document.getElementById('reportDate');
    if (dateInput) {
        dateInput.addEventListener('change', function() {
            console.log('Date changed to:', this.value);
            loadReport();
        });
    }
});

// ========== DATE & TIME ==========
function initializeDateField() {
    const today = new Date();
    const dateInput = document.getElementById('reportDate');
    if (dateInput) {
        dateInput.valueAsDate = today;
    }
}

function updateDateTime() {
    const now = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    const dateTimeEl = document.getElementById('currentDateTime');
    if (dateTimeEl) {
        dateTimeEl.textContent = now.toLocaleDateString('id-ID', options);
    }
}

// ========== LOAD REPORT ==========
async function loadReport() {
    console.log('loadReport called');
    
    const dateInput = document.getElementById('reportDate');
    if (!dateInput) {
        console.error('Date input not found!');
        return;
    }
    
    const date = dateInput.value;
    console.log('Loading report for date:', date);
    
    showLoading();

    try {
        const params = new URLSearchParams({ date });
        const url = `${URL_REPORT_DATA}?${params.toString()}`;
        console.log('Fetching:', url);
        
        const response = await fetch(url);
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`Request failed: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Data received:', data);

        if (data.success) {
            updateProfile(data.profile);
            updateStatistics(data.statistics);
            updateHourlyChart(data.hourlyData);
            updateTransactionsTable(data.recentTransactions);
            console.log('Report loaded successfully!');
        } else {
            showEmpty();
        }
    } catch (error) {
        console.error('Error loading report:', error);
        alert('Gagal memuat laporan: ' + error.message);
        showEmpty();
    }
}

// ========== UPDATE PROFILE ==========
function updateProfile(profile) {
    const nameEl = document.getElementById('profileName');
    const emailEl = document.getElementById('profileEmail');
    const roleEl = document.getElementById('profileRole');
    const memberSinceEl = document.getElementById('profileMemberSince');
    
    if (nameEl) nameEl.textContent = profile.name;
    if (emailEl) emailEl.textContent = profile.email;
    if (roleEl) roleEl.textContent = profile.role.toUpperCase();
    if (memberSinceEl) memberSinceEl.textContent = 'Member since: ' + profile.member_since;
}

// ========== UPDATE STATISTICS ==========
function updateStatistics(stats) {
    const totalTransactionsEl = document.getElementById('profileTotalTransactions');
    const totalSalesEl = document.getElementById('totalSales');
    const totalItemsEl = document.getElementById('totalItems');
    const avgTransactionEl = document.getElementById('avgTransaction');
    const cashCountEl = document.getElementById('cashCount');
    const cardCountEl = document.getElementById('cardCount');
    const qrisCountEl = document.getElementById('qrisCount');
    const transferCountEl = document.getElementById('transferCount');
    const transactionCountEl = document.getElementById('transactionCount');
    
    if (totalTransactionsEl) totalTransactionsEl.textContent = stats.totalTransactions || 0;
    if (totalSalesEl) totalSalesEl.textContent = 'Rp ' + formatNumber(stats.totalSales || 0);
    if (totalItemsEl) totalItemsEl.textContent = stats.totalItems || 0;
    if (avgTransactionEl) avgTransactionEl.textContent = 'Rp ' + formatNumber(stats.avgTransaction || 0);
    if (cashCountEl) cashCountEl.textContent = stats.cashTransactions || 0;
    if (cardCountEl) cardCountEl.textContent = stats.cardTransactions || 0;
    if (qrisCountEl) qrisCountEl.textContent = stats.qrisTransactions || 0;
    if (transferCountEl) transferCountEl.textContent = stats.transferTransactions || 0;
    if (transactionCountEl) transactionCountEl.textContent = stats.totalTransactions || 0;
}

// ========== UPDATE HOURLY CHART ==========
function updateHourlyChart(hourlyData) {
    const ctx = document.getElementById('hourlyChart');
    if (!ctx) {
        console.error('Chart canvas not found!');
        return;
    }

    if (hourlyChart) {
        hourlyChart.destroy();
    }

    const labels = hourlyData.map(item => item.hour);
    const transactions = hourlyData.map(item => item.transactions);
    const sales = hourlyData.map(item => item.sales);

    hourlyChart = new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Jumlah Transaksi',
                    data: transactions,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 2,
                    yAxisID: 'y',
                },
                {
                    label: 'Total Penjualan (Rp)',
                    data: sales,
                    type: 'line',
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                if (context.datasetIndex === 1) {
                                    label += 'Rp ' + formatNumber(context.parsed.y);
                                } else {
                                    label += context.parsed.y + ' transaksi';
                                }
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Transaksi',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Penjualan (Rp)',
                        font: {
                            weight: 'bold'
                        }
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + formatNumber(value);
                        }
                    }
                }
            }
        }
    });
}

// ========== UPDATE TRANSACTIONS TABLE ==========
function updateTransactionsTable(transactions) {
    const tbody = document.getElementById('transactionsBody');
    if (!tbody) {
        console.error('Table body not found!');
        return;
    }
    
    tbody.innerHTML = '';

    if (transactions.length === 0) {
        showEmpty();
        return;
    }

    transactions.forEach((transaction, index) => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 transition-colors';
        row.innerHTML = `
            <td class="px-4 py-3 text-sm text-gray-900">${index + 1}</td>
            <td class="px-4 py-3 text-sm font-semibold text-blue-600">${transaction.transaction_code}</td>
            <td class="px-4 py-3 text-sm text-gray-900">${transaction.time}</td>
            <td class="px-4 py-3 text-sm text-center">
                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                    ${transaction.items_count} item
                </span>
            </td>
            <td class="px-4 py-3 text-sm font-bold text-green-600">Rp ${formatNumber(transaction.total)}</td>
            <td class="px-4 py-3 text-sm">
                <span class="px-3 py-1 ${getPaymentBadgeClass(transaction.payment_method)} rounded-full text-xs font-semibold">
                    ${getPaymentMethodText(transaction.payment_method)}
                </span>
            </td>
        `;
        tbody.appendChild(row);
    });

    hideLoading();
}

// ========== UTILITY FUNCTIONS ==========
function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function getPaymentMethodText(method) {
    const methods = {
        'cash': 'Tunai',
        'card': 'Kartu',
        'qris': 'QRIS',
        'transfer': 'Transfer'
    };
    return methods[method] || method;
}

function getPaymentBadgeClass(method) {
    const classes = {
        'cash': 'bg-green-100 text-green-700',
        'card': 'bg-blue-100 text-blue-700',
        'qris': 'bg-purple-100 text-purple-700',
        'transfer': 'bg-orange-100 text-orange-700'
    };
    return classes[method] || 'bg-gray-100 text-gray-700';
}

function showLoading() {
    const loadingEl = document.getElementById('loadingState');
    const emptyEl = document.getElementById('emptyState');
    const tbodyEl = document.getElementById('transactionsBody');
    
    if (loadingEl) loadingEl.classList.remove('hidden');
    if (emptyEl) emptyEl.classList.add('hidden');
    if (tbodyEl) tbodyEl.innerHTML = '';
}

function hideLoading() {
    const loadingEl = document.getElementById('loadingState');
    if (loadingEl) loadingEl.classList.add('hidden');
}

function showEmpty() {
    const emptyEl = document.getElementById('emptyState');
    const loadingEl = document.getElementById('loadingState');
    const tbodyEl = document.getElementById('transactionsBody');
    
    if (emptyEl) emptyEl.classList.remove('hidden');
    if (loadingEl) loadingEl.classList.add('hidden');
    if (tbodyEl) tbodyEl.innerHTML = '';
}

// ========== END IIFE ==========
})();
</script>
@endpush
@endsection
