@extends('layouts.kasir')

@section('title', 'Laporan Penjualan - Kasir')

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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">📊 Laporan Penjualan</h1>
                    <p class="text-gray-600">Lihat dan analisis data penjualan Anda</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500 mb-1">Kasir: <span class="font-semibold">{{ Auth::user()->name }}</span></div>
                    <div id="currentDateTime" class="text-sm text-gray-600 font-medium"></div>
                </div>
            </div>
        </div>

        <!-- Filter & Export Section -->
        <div class="filter-card bg-white rounded-2xl shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Period Type -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Periode</label>
                    <select id="periodType" class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="daily">Harian</option>
                        <option value="monthly">Bulanan</option>
                        <option value="yearly">Tahunan</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" id="dateFrom" class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" id="dateTo" class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end gap-2">
                    <button id="filterButton" type="button" onclick="loadReport()" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filter
                        </span>
                    </button>
                </div>
            </div>

            <!-- Export Buttons -->
            <div class="mt-4 pt-4 border-t border-gray-200">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Export Data</label>
                <div class="flex gap-3">
                    <button onclick="exportExcel()" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all duration-300 shadow-md hover:shadow-lg" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%) !important;">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            CSV Excel
                        </span>
                    </button>
                    <button onclick="exportPDF()" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-300 shadow-md hover:shadow-lg" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            PDF
                        </span>
                    </button>
                    <button onclick="window.print()" class="px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-300 shadow-md hover:shadow-lg" style="background: linear-gradient(135deg, #4b5563 0%, #374151 100%) !important;">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <!-- Total Transaksi -->
            <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-5xl">📋</div>
                </div>
                <div class="text-3xl font-bold mb-1" id="totalTransactions">0</div>
                <div class="text-sm opacity-90">Total Transaksi</div>
            </div>

            <!-- Total Penjualan -->
            <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-5xl">💰</div>
                </div>
                <div class="text-3xl font-bold mb-1" id="totalSales">Rp 0</div>
                <div class="text-sm opacity-90">Total Penjualan</div>
            </div>

            <!-- Total Item Terjual -->
            <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-5xl">📦</div>
                </div>
                <div class="text-3xl font-bold mb-1" id="totalItems">0</div>
                <div class="text-sm opacity-90">Item Terjual</div>
            </div>

            <!-- Rata-rata Transaksi -->
            <div class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-5xl">📊</div>
                </div>
                <div class="text-3xl font-bold mb-1" id="avgTransaction">Rp 0</div>
                <div class="text-sm opacity-90">Rata-rata Transaksi</div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="chart-card bg-white rounded-2xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Grafik Penjualan</h2>
            <div class="chart-container" style="height: 400px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-card bg-white rounded-2xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Detail Transaksi</h2>
                <div class="text-sm text-gray-600">
                    Menampilkan <span id="recordFrom" class="font-semibold">0</span> - <span id="recordTo" class="font-semibold">0</span> dari <span id="recordTotal" class="font-semibold">0</span> data
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full" id="transactionsTable">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b-2 border-blue-200">
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kode Transaksi</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kasir</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Items</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Metode</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="transactionsBody" class="divide-y divide-gray-200">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div id="paginationContainer" class="mt-6 flex items-center justify-between border-t border-gray-200 pt-4">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Halaman <span id="currentPageText" class="font-semibold">1</span> dari <span id="totalPagesText" class="font-semibold">1</span></span>
                </div>
                <div class="flex space-x-2" id="paginationButtons">
                    <!-- Pagination buttons will be generated here -->
                </div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-12 hidden">
                <div class="text-6xl mb-4">📭</div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak Ada Data</h3>
                <p class="text-gray-500">Belum ada transaksi pada periode yang dipilih</p>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="text-center py-12 hidden">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                <p class="text-gray-600 font-medium">Memuat data...</p>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal-overlay">
    <div class="modal-container max-w-2xl">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Detail Transaksi</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div id="modalContent" class="space-y-4">
                <!-- Content will be loaded here -->
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
        /* Let flexbox handle layout next to the 80px sidebar */
        margin-left: 0; /* remove unintended gap next to sidebar */
        min-width: 0;   /* prevent flex overflow that can push content away */
    }

    .filter-card {
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

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        animation: modalFade 0.3s ease;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-container {
        width: 90%;
        animation: modalZoom 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes modalFade {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes modalZoom {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .modal-content {
        background: white;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 24px 48px rgba(0, 0, 0, 0.2);
        max-height: 90vh;
        overflow-y: auto;
    }

    /* Print Styles */
    @media print {
        .filter-card,
        .no-print,
        button,
        .modal-overlay {
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
// Stop event propagation if coming from Vite's app.js that expects landing page elements
(function() {
    'use strict';
    
// ========== GLOBAL VARIABLES ==========
let salesChart = null;
let currentData = [];
let currentPage = 1;
let totalPages = 1;
let currentPagination = null;

// ========== ROUTE URLS (server-generated to support subfolder deployments) ==========
const URL_DATA = "{{ route('kasir.history.data') }}";
const URL_HISTORY_BASE = "{{ route('kasir.history') }}"; // e.g., /kasir/history
const URL_EXPORT_EXCEL = "{{ route('kasir.history.export.excel') }}";
const URL_EXPORT_PDF = "{{ route('kasir.history.export.pdf') }}";

// ========== INITIALIZE ==========
document.addEventListener('DOMContentLoaded', function() {
    console.log('History Page: Initializing...');
    initializeDateFields();
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    // Small delay to ensure DOM is fully ready
    setTimeout(() => {
        console.log('History Page: Loading initial report...');
        loadReport();
    }, 100);
});

// ========== DATE & TIME ==========
function initializeDateFields() {
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    
    document.getElementById('dateFrom').valueAsDate = firstDay;
    document.getElementById('dateTo').valueAsDate = today;
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
    document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
}

// ========== LOAD REPORT ==========
async function loadReport(page = 1) {
    console.log('loadReport called with page:', page);
    
    const periodType = document.getElementById('periodType');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    
    if (!periodType || !dateFrom || !dateTo) {
        console.error('Required form elements not found!');
        alert('Error: Form elements not loaded properly. Please refresh the page.');
        return;
    }
    
    const periodValue = periodType.value;
    const dateFromValue = dateFrom.value;
    const dateToValue = dateTo.value;

    if (!dateFromValue || !dateToValue) {
        alert('Mohon pilih tanggal terlebih dahulu');
        return;
    }

    console.log('Filter params:', { period: periodValue, from: dateFromValue, to: dateToValue, page });
    
    showLoading();
    // Disable filter button during load to prevent double clicks
    const btn = document.getElementById('filterButton');
    if (btn) {
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
    }

    try {
        const params = new URLSearchParams({
            period: periodValue,
            from: dateFromValue,
            to: dateToValue,
            page: String(page)
        });
        const url = `${URL_DATA}?${params.toString()}`;
        console.log('Fetching:', url);
        
        const response = await fetch(url);
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`Request failed: ${response.status}`);
        }
        const data = await response.json();
        console.log('Data received:', data);

        if (data.success) {
            currentData = data.data;
            currentPage = data.pagination.current_page;
            totalPages = data.pagination.last_page;
            currentPagination = data.pagination;
            
            updateStatistics(data.statistics);
            updateChart(data.chartData);
            updateTable(data.data, data.pagination);
            updatePagination(data.pagination);
            console.log('Report loaded successfully!');
        } else {
            console.warn('API returned success=false');
            showEmpty();
        }
    } catch (error) {
        console.error('Error loading report:', error);
        alert('Gagal memuat laporan: ' + error.message + '\n\nSilakan periksa koneksi atau coba lagi.');
        showEmpty();
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.classList.remove('opacity-70', 'cursor-not-allowed');
        }
    }
}

// ========== UPDATE STATISTICS ==========
function updateStatistics(stats) {
    document.getElementById('totalTransactions').textContent = stats.totalTransactions || 0;
    document.getElementById('totalSales').textContent = 'Rp ' + formatNumber(stats.totalSales || 0);
    document.getElementById('totalItems').textContent = stats.totalItems || 0;
    document.getElementById('avgTransaction').textContent = 'Rp ' + formatNumber(stats.avgTransaction || 0);
}

// ========== UPDATE CHART ==========
function updateChart(chartData) {
    const ctx = document.getElementById('salesChart').getContext('2d');

    if (salesChart) {
        salesChart.destroy();
    }

    salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: chartData.values,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
                            return 'Rp ' + formatNumber(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
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

// ========== UPDATE TABLE ==========
function updateTable(data, pagination) {
    const tbody = document.getElementById('transactionsBody');
    tbody.innerHTML = '';

    if (data.length === 0) {
        showEmpty();
        return;
    }

    // Update pagination info
    document.getElementById('recordFrom').textContent = pagination.from || 0;
    document.getElementById('recordTo').textContent = pagination.to || 0;
    document.getElementById('recordTotal').textContent = pagination.total || 0;

    data.forEach((transaction, index) => {
        const actualIndex = (pagination.current_page - 1) * pagination.per_page + index + 1;
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 transition-colors';
        row.innerHTML = `
            <td class="px-4 py-3 text-sm text-gray-900">${actualIndex}</td>
            <td class="px-4 py-3 text-sm font-semibold text-blue-600">${transaction.transaction_code}</td>
            <td class="px-4 py-3 text-sm text-gray-900">${formatDate(transaction.created_at)}</td>
            <td class="px-4 py-3 text-sm text-gray-900">${transaction.cashier_name}</td>
            <td class="px-4 py-3 text-sm text-gray-900">${transaction.customer_name || 'Umum'}</td>
            <td class="px-4 py-3 text-sm text-center">
                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                    ${transaction.total_items} item
                </span>
            </td>
            <td class="px-4 py-3 text-sm font-bold text-green-600">Rp ${formatNumber(transaction.total)}</td>
            <td class="px-4 py-3 text-sm">
                <span class="px-3 py-1 ${getPaymentBadgeClass(transaction.payment_method)} rounded-full text-xs font-semibold">
                    ${getPaymentMethodText(transaction.payment_method)}
                </span>
            </td>
            <td class="px-4 py-3 text-center">
                <button onclick="viewDetail(${transaction.id})" class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded-lg transition-all">
                    Detail
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });

    hideLoading();
}

// ========== UPDATE PAGINATION ==========
function updatePagination(pagination) {
    const paginationContainer = document.getElementById('paginationContainer');
    const paginationButtons = document.getElementById('paginationButtons');
    
    if (pagination.last_page <= 1) {
        paginationContainer.classList.add('hidden');
        return;
    }
    
    paginationContainer.classList.remove('hidden');
    
    // Update page text
    document.getElementById('currentPageText').textContent = pagination.current_page;
    document.getElementById('totalPagesText').textContent = pagination.last_page;
    
    // Generate pagination buttons
    paginationButtons.innerHTML = '';
    
    // Previous button
    const prevBtn = document.createElement('button');
    prevBtn.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    `;
    prevBtn.className = `px-3 py-2 rounded-lg transition-all ${pagination.current_page === 1 ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-600 text-white'}`;
    prevBtn.disabled = pagination.current_page === 1;
    prevBtn.onclick = () => !prevBtn.disabled && loadReport(pagination.current_page - 1);
    paginationButtons.appendChild(prevBtn);
    
    // Page numbers
    const maxButtons = 5;
    let startPage = Math.max(1, pagination.current_page - Math.floor(maxButtons / 2));
    let endPage = Math.min(pagination.last_page, startPage + maxButtons - 1);
    
    if (endPage - startPage < maxButtons - 1) {
        startPage = Math.max(1, endPage - maxButtons + 1);
    }
    
    // First page
    if (startPage > 1) {
        const firstBtn = createPageButton(1, pagination.current_page);
        paginationButtons.appendChild(firstBtn);
        
        if (startPage > 2) {
            const dots = document.createElement('span');
            dots.className = 'px-3 py-2 text-gray-500';
            dots.textContent = '...';
            paginationButtons.appendChild(dots);
        }
    }
    
    // Page buttons
    for (let i = startPage; i <= endPage; i++) {
        const pageBtn = createPageButton(i, pagination.current_page);
        paginationButtons.appendChild(pageBtn);
    }
    
    // Last page
    if (endPage < pagination.last_page) {
        if (endPage < pagination.last_page - 1) {
            const dots = document.createElement('span');
            dots.className = 'px-3 py-2 text-gray-500';
            dots.textContent = '...';
            paginationButtons.appendChild(dots);
        }
        
        const lastBtn = createPageButton(pagination.last_page, pagination.current_page);
        paginationButtons.appendChild(lastBtn);
    }
    
    // Next button
    const nextBtn = document.createElement('button');
    nextBtn.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    `;
    nextBtn.className = `px-3 py-2 rounded-lg transition-all ${pagination.current_page === pagination.last_page ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-600 text-white'}`;
    nextBtn.disabled = pagination.current_page === pagination.last_page;
    nextBtn.onclick = () => !nextBtn.disabled && loadReport(pagination.current_page + 1);
    paginationButtons.appendChild(nextBtn);
}

function createPageButton(pageNumber, currentPage) {
    const btn = document.createElement('button');
    btn.textContent = pageNumber;
    btn.className = `px-4 py-2 rounded-lg transition-all font-semibold ${pageNumber === currentPage ? 'bg-blue-600 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-700'}`;
    btn.onclick = () => loadReport(pageNumber);
    return btn;
}

// ========== VIEW DETAIL ==========
async function viewDetail(transactionId) {
    const modal = document.getElementById('detailModal');
    const modalContent = document.getElementById('modalContent');

    try {
        const response = await fetch(`${URL_HISTORY_BASE}/${transactionId}`);
        const data = await response.json();

        if (data.success) {
            const transaction = data.transaction;
            modalContent.innerHTML = `
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-4 mb-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-sm text-gray-600">Kode Transaksi</div>
                            <div class="font-bold text-lg">${transaction.transaction_code}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Tanggal</div>
                            <div class="font-bold text-lg">${formatDate(transaction.created_at)}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Kasir</div>
                            <div class="font-semibold">${transaction.cashier_name}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Pelanggan</div>
                            <div class="font-semibold">${transaction.customer_name || 'Umum'}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="font-bold text-gray-700 mb-2">Item Pembelian</h4>
                    <div class="space-y-2">
                        ${transaction.items.map(item => `
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <div class="font-semibold">${item.product_name}</div>
                                    <div class="text-sm text-gray-600">${item.quantity} x Rp ${formatNumber(item.price)}</div>
                                </div>
                                <div class="font-bold text-blue-600">Rp ${formatNumber(item.subtotal)}</div>
                            </div>
                        `).join('')}
                    </div>
                </div>

                <div class="border-t pt-4">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">Rp ${formatNumber(transaction.subtotal)}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Pajak</span>
                            <span class="font-semibold">Rp ${formatNumber(transaction.tax)}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold border-t pt-2">
                            <span>Total</span>
                            <span class="text-green-600">Rp ${formatNumber(transaction.total)}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-sm text-gray-600">Metode Bayar</div>
                            <div class="font-semibold">${getPaymentMethodText(transaction.payment_method)}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Dibayar</div>
                            <div class="font-semibold text-green-600">Rp ${formatNumber(transaction.paid)}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Kembalian</div>
                            <div class="font-semibold text-blue-600">Rp ${formatNumber(transaction.change)}</div>
                        </div>
                    </div>
                </div>
            `;

            modal.classList.add('show');
        }
    } catch (error) {
        console.error('Error loading detail:', error);
        alert('Gagal memuat detail transaksi');
    }
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('show');
}

// ========== EXPORT FUNCTIONS ==========
async function exportExcel() {
    const periodType = document.getElementById('periodType').value;
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    const params = new URLSearchParams({ period: periodType, from: dateFrom, to: dateTo });
    window.location.href = `${URL_EXPORT_EXCEL}?${params.toString()}`;
}

async function exportPDF() {
    const periodType = document.getElementById('periodType').value;
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    const params = new URLSearchParams({ period: periodType, from: dateFrom, to: dateTo });
    window.location.href = `${URL_EXPORT_PDF}?${params.toString()}`;
}

// ========== UTILITY FUNCTIONS ==========
function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
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
    document.getElementById('loadingState').classList.remove('hidden');
    document.getElementById('emptyState').classList.add('hidden');
    document.getElementById('transactionsBody').innerHTML = '';
}

function hideLoading() {
    document.getElementById('loadingState').classList.add('hidden');
}

function showEmpty() {
    document.getElementById('emptyState').classList.remove('hidden');
    document.getElementById('loadingState').classList.add('hidden');
    document.getElementById('transactionsBody').innerHTML = '';
    document.getElementById('recordFrom').textContent = '0';
    document.getElementById('recordTo').textContent = '0';
    document.getElementById('recordTotal').textContent = '0';
    document.getElementById('paginationContainer').classList.add('hidden');
}

// ========== END IIFE ==========
})(); // Close the isolation wrapper
</script>
@endpush
@endsection
