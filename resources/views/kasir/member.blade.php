@extends('layouts.kasir')

@section('title', 'Member Management - Conventional Shop')

@section('content')
<div class="pos-container flex min-h-screen bg-gray-50">
    <!-- Sidebar Component -->
    @include('components.kasir.sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 overflow-auto p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                            <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Member Management
                        </h1>
                        <p class="text-gray-500 mt-1">Kelola data member Conventional Shop</p>
                    </div>
                    <button onclick="openAddModal()" class="btn-primary flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Daftar Member Baru
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="stat-card">
                    <div class="stat-icon bg-blue-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="stat-label">Total Member</p>
                        <p class="stat-value">{{ $members->total() }}</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-green-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="stat-label">Member Aktif</p>
                        <p class="stat-value">{{ $members->where('is_active', true)->count() }}</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-yellow-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="stat-label">Member Baru (Bulan Ini)</p>
                        <p class="stat-value">{{ $members->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-purple-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="stat-label">Total Poin</p>
                        <p class="stat-value">{{ number_format($members->sum('points')) }}</p>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                <div class="relative">
                    <input 
                        type="text" 
                        id="searchMember" 
                        placeholder="Cari member berdasarkan nama, kode, atau telepon..."
                        class="w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    >
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Members Table -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                            <tr>
                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider">No</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider">Member</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kontak</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider">Poin</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="memberTableBody" class="divide-y divide-gray-200">
                            @forelse($members as $index => $member)
                            <tr class="member-row hover:bg-blue-50 transition-colors" 
                                data-member-id="{{ $member->id }}"
                                data-member-code="{{ $member->member_code }}"
                                data-member-name="{{ $member->name }}"
                                data-barcode="{{ $member->barcode }}">
                                <td class="px-4 py-4 text-sm text-gray-600 font-medium">
                                    {{ ($members->currentPage() - 1) * $members->perPage() + $index + 1 }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-lg mr-3 shadow-sm">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $member->name }}</p>
                                            <p class="text-xs text-blue-600 font-mono font-semibold">{{ $member->member_code }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="space-y-1">
                                        <p class="text-sm text-gray-800 flex items-center">
                                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            {{ $member->phone }}
                                        </p>
                                        @if($member->email)
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <svg class="w-3 h-3 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $member->email }}
                                        </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-sm">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        {{ number_format($member->points) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($member->is_active)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                        Aktif
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                        Nonaktif
                                    </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button onclick="showBarcodeModal('{{ $member->barcode }}', '{{ $member->name }}', '{{ $member->member_code }}')" class="btn-icon btn-barcode" title="Barcode">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                            </svg>
                                        </button>
                                        <button onclick="editMember({{ $member->id }})" class="btn-icon btn-edit" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button onclick="toggleStatus({{ $member->id }})" class="btn-icon btn-toggle" title="Toggle Status">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                            </svg>
                                        </button>
                                        <button onclick="deleteMember({{ $member->id }})" class="btn-icon btn-delete" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Belum ada member terdaftar</p>
                                        <p class="text-sm mt-1">Klik tombol "Daftar Member Baru" untuk memulai</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($members->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $members->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Member Modal -->
<div id="memberModal" class="modal-overlay">
    <div class="modal-container max-w-2xl">
        <div class="modal-content">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg class="w-7 h-7 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <span id="modalTitle">Daftar Member Baru</span>
                </h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="memberForm">
                @csrf
                <input type="hidden" id="memberId" name="member_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" class="form-input" placeholder="Masukkan nama lengkap" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="tel" id="phone" name="phone" class="form-input" placeholder="Contoh: 08123456789" required>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Email (Opsional)</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Contoh: member@email.com">
                </div>

                <div class="form-group mb-6">
                    <label class="form-label">Alamat (Opsional)</label>
                    <textarea id="address" name="address" rows="3" class="form-input" placeholder="Masukkan alamat lengkap"></textarea>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="btn-primary flex-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Member
                    </button>
                    <button type="button" onclick="closeModal()" class="btn-secondary flex-1">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal-overlay">
    <div class="modal-container max-w-md">
        <div class="modal-content text-center">
            <div class="success-animation mb-6">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Berhasil!</h3>
            <p id="successMessage" class="text-gray-600 mb-6">Member berhasil didaftarkan</p>
            <div id="memberCard" class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-xl p-6 mb-6 text-left">
                <p class="text-sm opacity-90 mb-2">Kode Member</p>
                <p id="memberCodeDisplay" class="text-3xl font-bold font-mono mb-4">MBR2510290001</p>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="opacity-75">Nama</p>
                        <p id="memberNameDisplay" class="font-semibold">-</p>
                    </div>
                    <div>
                        <p class="opacity-75">Telepon</p>
                        <p id="memberPhoneDisplay" class="font-semibold">-</p>
                    </div>
                </div>
            </div>
            <button onclick="closeSuccessModal()" class="btn-primary w-full">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Barcode Modal -->
<div id="barcodeModal" class="modal-overlay">
    <div class="modal-container max-w-lg">
        <div class="modal-content text-center">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg class="w-7 h-7 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                    Barcode Member
                </h2>
                <button onclick="closeBarcodeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div id="barcodeCard" class="bg-white border-4 border-blue-600 rounded-2xl p-8 mb-6 print-area">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">Conventional Shop</h3>
                    <p class="text-sm text-gray-500">Member Card</p>
                </div>
                
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 mb-4">
                    <p class="text-sm text-gray-600 mb-2">Member</p>
                    <p id="barcodeNameDisplay" class="text-2xl font-bold text-gray-800 mb-1">-</p>
                    <p id="barcodeCodeDisplay" class="text-sm text-blue-600 font-mono font-semibold">-</p>
                </div>

                <div class="bg-white p-4 rounded-xl border-2 border-gray-200">
                    <svg id="barcodeImage"></svg>
                </div>

                <p class="text-xs text-gray-400 mt-4">Tunjukkan barcode ini saat melakukan transaksi</p>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button onclick="printBarcode()" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Barcode
                </button>
                <button onclick="closeBarcodeModal()" class="btn-secondary">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Notification Toast -->
<div id="notificationToast" class="notification-toast"></div>

<!-- JsBarcode Library -->
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>

@push('styles')
<style>
    /* General Styles */
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        border: none;
        cursor: pointer;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #6b7280;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-barcode {
        background: #ede9fe;
        color: #7c3aed;
    }

    .btn-barcode:hover {
        background: #ddd6fe;
        transform: scale(1.1);
    }

    .btn-edit {
        background: #eff6ff;
        color: #3b82f6;
    }

    .btn-edit:hover {
        background: #dbeafe;
        transform: scale(1.1);
    }

    .btn-toggle {
        background: #fef3c7;
        color: #f59e0b;
    }

    .btn-toggle:hover {
        background: #fde68a;
        transform: scale(1.1);
    }

    .btn-delete {
        background: #fee2e2;
        color: #ef4444;
    }

    .btn-delete:hover {
        background: #fecaca;
        transform: scale(1.1);
    }

    /* Stats Card */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .stat-label {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
        will-change: opacity;
    }

    .modal-overlay.show {
        display: flex;
        animation: modalFadeIn 0.3s ease;
    }

    .modal-container {
        width: 100%;
        animation: modalSlideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        will-change: transform, opacity;
    }

    .modal-content {
        background: white;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 24px 48px rgba(0, 0, 0, 0.2);
        max-height: 90vh;
        overflow-y: auto;
        /* Hide thin scrollbar lines that look like a cyan bar */
        scrollbar-width: none; /* Firefox */
    }

    .modal-content::-webkit-scrollbar {
        width: 0; /* Safari/Chrome */
    }

    @keyframes modalFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes modalSlideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Success Animation */
    .checkmark {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        display: block;
    }

    .checkmark-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke: #22c55e;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke-width: 3;
        stroke: #22c55e;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes stroke {
        to {
            stroke-dashoffset: 0;
        }
    }

    /* Notification Toast */
    .notification-toast {
        position: fixed;
        top: 24px;
        right: 24px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.4);
        transform: translateX(120%);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease;
        z-index: 10000;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .notification-toast.show {
        transform: translateX(0);
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    /* Table Animations */
    .member-row {
        animation: memberSlideIn 0.2s ease;
        will-change: transform, opacity;
    }

    @keyframes memberSlideIn {
        from {
            opacity: 0;
            transform: translateX(15px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Print Styles */
    @media print {
        body * {
            visibility: hidden;
        }
        .print-area, .print-area * {
            visibility: visible;
        }
        .print-area {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    }
</style>
@endpush

@push('scripts')
<script>
let editingMemberId = null;
let toastHideTimer = null;

// Open Add Modal
function openAddModal() {
    editingMemberId = null;
    document.getElementById('modalTitle').textContent = 'Daftar Member Baru';
    document.getElementById('memberForm').reset();
    document.getElementById('memberId').value = '';
    document.getElementById('memberModal').classList.add('show');
}

// Close Modal
function closeModal() {
    document.getElementById('memberModal').classList.remove('show');
    editingMemberId = null;
}

// Close Success Modal
function closeSuccessModal() {
    document.getElementById('successModal').classList.remove('show');
    location.reload();
}

// Submit Form
document.getElementById('memberForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    const url = editingMemberId 
        ? `/kasir/member/${editingMemberId}`
        : '/kasir/member';
    
    const method = editingMemberId ? 'PUT' : 'POST';
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('[name="csrf-token"]').content || '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            closeModal();
            
            if (!editingMemberId) {
                // Show success modal with member card
                document.getElementById('memberCodeDisplay').textContent = result.member.member_code;
                document.getElementById('memberNameDisplay').textContent = result.member.name;
                document.getElementById('memberPhoneDisplay').textContent = result.member.phone;
                document.getElementById('successMessage').textContent = result.message;
                document.getElementById('successModal').classList.add('show');
            } else {
                showNotification(result.message, 'success');
                setTimeout(() => location.reload(), 1500);
            }
        } else {
            showNotification(result.message || 'Terjadi kesalahan', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Gagal menyimpan data member', 'error');
    }
});

// Edit Member
async function editMember(id) {
    try {
        const response = await fetch(`/kasir/member/${id}`);
        const result = await response.json();
        
        if (result.success) {
            editingMemberId = id;
            document.getElementById('modalTitle').textContent = 'Edit Data Member';
            document.getElementById('memberId').value = id;
            document.getElementById('name').value = result.member.name;
            document.getElementById('email').value = result.member.email || '';
            document.getElementById('phone').value = result.member.phone;
            document.getElementById('address').value = result.member.address || '';
            document.getElementById('memberModal').classList.add('show');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Gagal memuat data member', 'error');
    }
}

// Toggle Status
async function toggleStatus(id) {
    if (!confirm('Yakin ingin mengubah status member ini?')) return;
    
    try {
        const response = await fetch(`/kasir/member/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('[name="csrf-token"]').content || '{{ csrf_token() }}'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification(result.message, 'success');
            setTimeout(() => location.reload(), 1000);
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Gagal mengubah status', 'error');
    }
}

// Delete Member
async function deleteMember(id) {
    if (!confirm('Yakin ingin menghapus member ini? Data yang dihapus tidak dapat dikembalikan.')) return;
    
    try {
        const response = await fetch(`/kasir/member/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('[name="csrf-token"]').content || '{{ csrf_token() }}'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification(result.message, 'success');
            setTimeout(() => location.reload(), 1000);
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Gagal menghapus member', 'error');
    }
}

// Search Member
document.getElementById('searchMember').addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.member-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
    });
});

// Barcode Modal Functions
function showBarcodeModal(barcode, name, code) {
    const modal = document.getElementById('barcodeModal');
    const nameDisplay = document.getElementById('barcodeNameDisplay');
    const codeDisplay = document.getElementById('barcodeCodeDisplay');
    const barcodeImage = document.getElementById('barcodeImage');
    
    // Set member info
    nameDisplay.textContent = name;
    codeDisplay.textContent = code;
    
    // Generate barcode using JsBarcode
    try {
        JsBarcode(barcodeImage, barcode, {
            format: "CODE128",
            width: 2,
            height: 80,
            displayValue: true,
            fontSize: 16,
            margin: 10,
            background: "#ffffff",
            lineColor: "#000000"
        });
    } catch (error) {
        console.error('Error generating barcode:', error);
        showNotification('Gagal generate barcode', 'error');
        return;
    }
    
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeBarcodeModal() {
    const modal = document.getElementById('barcodeModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

function printBarcode() {
    window.print();
}

// Close barcode modal on background click
document.getElementById('barcodeModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeBarcodeModal();
    }
});

// Notification
function showNotification(message, type = 'info') {
    const toast = document.getElementById('notificationToast');
    
    const colors = {
        success: 'linear-gradient(135deg, #22c55e 0%, #16a34a 100%)',
        error: 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
        warning: 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
        info: 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)'
    };
    
    toast.style.background = colors[type] || colors.info;
    toast.textContent = message;
    
    if (toastHideTimer) {
        clearTimeout(toastHideTimer);
        toastHideTimer = null;
    }
    
    toast.classList.add('show');
    
    toastHideTimer = setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => { toast.textContent = ''; }, 350);
    }, 3000);
    
    toast.onclick = () => {
        if (toastHideTimer) clearTimeout(toastHideTimer);
        toast.classList.remove('show');
        setTimeout(() => { toast.textContent = ''; }, 200);
    };
}

// Close modal on ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
        closeSuccessModal();
    }
});

// Close modal on outside click
document.getElementById('memberModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

document.getElementById('successModal').addEventListener('click', function(e) {
    if (e.target === this) closeSuccessModal();
});
</script>
@endpush
@endsection
