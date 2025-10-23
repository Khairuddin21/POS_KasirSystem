@extends('layouts.main')

@section('title', 'POS Kasir - Sistem Kasir Modern untuk Bisnis Anda')

@section('content')
<!-- Navbar -->
<nav class="navbar fixed w-full top-0 z-50 bg-white shadow-sm transition-all duration-300" id="navbar">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="text-2xl font-bold text-cyan-500">
                <a href="/" class="flex items-center">
                    <span class="text-cyan-500">pos</span><span class="text-gray-800">kasir</span>
                </a>
            </div>
            
            <div class="hidden md:flex items-center space-x-8">
                <a href="#fitur" class="nav-link text-gray-700 hover:text-cyan-500 transition-colors">Fitur</a>
                <a href="#solusi" class="nav-link text-gray-700 hover:text-cyan-500 transition-colors">Solusi</a>
                <a href="#keunggulan" class="nav-link text-gray-700 hover:text-cyan-500 transition-colors">Keunggulan</a>
                <a href="#harga" class="nav-link text-gray-700 hover:text-cyan-500 transition-colors">Harga</a>
                <a href="#kontak" class="nav-link text-gray-700 hover:text-cyan-500 transition-colors">Kontak</a>
            </div>
            
            <div class="flex items-center space-x-4">
                <a href="/login" class="hidden md:block text-gray-700 hover:text-cyan-500 transition-colors font-medium">Log In</a>
                <a href="/register" class="btn-primary px-6 py-2 bg-cyan-500 text-white rounded-full hover:bg-cyan-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">Coba Gratis</a>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700" id="mobileMenuBtn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu hidden md:hidden mt-4 pb-4" id="mobileMenu">
            <a href="#fitur" class="block py-2 text-gray-700 hover:text-cyan-500">Fitur</a>
            <a href="#solusi" class="block py-2 text-gray-700 hover:text-cyan-500">Solusi</a>
            <a href="#keunggulan" class="block py-2 text-gray-700 hover:text-cyan-500">Keunggulan</a>
            <a href="#harga" class="block py-2 text-gray-700 hover:text-cyan-500">Harga</a>
            <a href="#kontak" class="block py-2 text-gray-700 hover:text-cyan-500">Kontak</a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section bg-gradient-to-br from-cyan-400 via-cyan-500 to-cyan-600 pt-32 pb-20 px-6">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="text-white fade-in">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Nikmati Kemudahan Transaksi dengan <span class="text-yellow-300">Fitur Lengkap</span> yang Praktis dan Mudah Digunakan
                </h1>
                <p class="text-xl mb-8 text-cyan-50">
                    Sistem kasir digital yang efisien untuk berbagai jenis bisnis. Kelola transaksi, inventori, dan laporan dengan mudah.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="/register" class="btn-hero px-8 py-4 bg-white text-cyan-600 rounded-full font-bold text-lg hover:bg-gray-100 transition-all duration-300 shadow-2xl hover:shadow-xl transform hover:-translate-y-1">
                        Mulai Sekarang
                    </a>
                    <a href="#demo" class="px-8 py-4 border-2 border-white text-white rounded-full font-bold text-lg hover:bg-white hover:text-cyan-600 transition-all duration-300">
                        Lihat Demo
                    </a>
                </div>
            </div>
            
            <div class="relative fade-in-right">
                <div class="hero-image-container relative">
                    <img src="{{ asset('images/Image-4.png') }}" alt="POS Kasir - Kasir Modern" class="w-full max-w-lg mx-auto drop-shadow-2xl floating">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section 1 -->
<section class="py-20 px-6" id="fitur">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-cyan-500 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Alur Transaksi Efisien</h3>
                <p class="text-gray-600 leading-relaxed">Alur transaksi jadi lebih efisien dan terbebas dari antre dengan sistem kasir digital modern</p>
            </div>
            
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animation-delay-100">
                <div class="w-16 h-16 bg-cyan-500 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Notifikasi Digital</h3>
                <p class="text-gray-600 leading-relaxed">Opsi kirim struk digital melalui email dan whatsapp, solusi cermat untuk bisnis masa kini</p>
            </div>
            
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animation-delay-200">
                <div class="w-16 h-16 bg-cyan-500 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Pencatatan Akurat</h3>
                <p class="text-gray-600 leading-relaxed">Pencatatan dan perhitungan arus kas secara digital yang lebih aman dan akurat</p>
            </div>
        </div>
    </div>
</section>

<!-- Payment Section -->
<section class="py-20 px-6 bg-gradient-to-r from-cyan-50 to-blue-50">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="order-2 md:order-1 fade-in-left">
                <div class="relative">
                    <img src="{{ asset('images/Aset_Fitur_AplikasiKasir_ContentBlock2.png') }}" alt="Ragam Opsi Pembayaran" class="w-full max-w-lg mx-auto drop-shadow-2xl">
                </div>
            </div>
            
            <div class="order-1 md:order-2 fade-in">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-800">
                    Ragam Opsi Pembayaran untuk <span class="text-cyan-500">Kenyamanan Bertransaksi</span>
                </h2>
                
                <div class="space-y-6 mt-8">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Pisahkan Tagihan</h3>
                            <p class="text-gray-600">Pisahkan tagihan, pelanggan hanya perlu membayar apa yang dipesan dengan mudah</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Metode Pembayaran Lengkap</h3>
                            <p class="text-gray-600">Mudahkan pelanggan untuk bayar dengan lebih dari satu metode pembayaran</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Cicilan Mudah</h3>
                            <p class="text-gray-600">Pembayaran makin mudah dan penjualan makin meningkat dengan opsi bayar dengan cicilan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Role Access Section -->
<section class="py-20 px-6" id="solusi">
    <div class="container mx-auto text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-800">Solusi untuk Semua Kebutuhan</h2>
        <p class="text-xl text-gray-600 mb-12">Akses khusus untuk setiap role dalam bisnis Anda</p>
        
        <div class="grid md:grid-cols-3 gap-8 mt-12">
            <div class="role-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-t-4 border-cyan-500">
                <div class="w-20 h-20 bg-gradient-to-br from-cyan-400 to-cyan-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Admin</h3>
                <p class="text-gray-600 mb-6">Kelola seluruh sistem, manajemen user, dan analisis bisnis komprehensif</p>
                <ul class="text-left text-gray-600 space-y-2 mb-6">
                    <li class="flex items-center"><svg class="w-5 h-5 text-cyan-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Dashboard Lengkap</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-cyan-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Manajemen User & Role</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-cyan-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Laporan & Analitik</li>
                </ul>
                <a href="/admin/login" class="inline-block px-6 py-3 bg-cyan-500 text-white rounded-full font-bold hover:bg-cyan-600 transition-all duration-300">Akses Admin</a>
            </div>
            
            <div class="role-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-t-4 border-blue-500 animation-delay-100">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Kasir</h3>
                <p class="text-gray-600 mb-6">Interface cepat untuk proses transaksi dan pengelolaan kasir harian</p>
                <ul class="text-left text-gray-600 space-y-2 mb-6">
                    <li class="flex items-center"><svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Transaksi Cepat</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Kelola Pembayaran</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Cetak Struk Digital</li>
                </ul>
                <a href="/kasir/login" class="inline-block px-6 py-3 bg-blue-500 text-white rounded-full font-bold hover:bg-blue-600 transition-all duration-300">Akses Kasir</a>
            </div>
            
            <div class="role-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-t-4 border-purple-500 animation-delay-200">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">User</h3>
                <p class="text-gray-600 mb-6">Dashboard personal untuk melihat transaksi dan riwayat pembelian</p>
                <ul class="text-left text-gray-600 space-y-2 mb-6">
                    <li class="flex items-center"><svg class="w-5 h-5 text-purple-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Riwayat Transaksi</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-purple-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Profile Management</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-purple-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Notifikasi Personal</li>
                </ul>
                <a href="/user/login" class="inline-block px-6 py-3 bg-purple-500 text-white rounded-full font-bold hover:bg-purple-600 transition-all duration-300">Akses User</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 px-6 bg-gradient-to-r from-cyan-500 to-blue-600" id="kontak">
    <div class="container mx-auto text-center text-white">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">Siap Meningkatkan Bisnis Anda?</h2>
        <p class="text-xl mb-8 text-cyan-50">Bergabung dengan ribuan bisnis yang telah mempercayai sistem kami</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="/register" class="px-8 py-4 bg-white text-cyan-600 rounded-full font-bold text-lg hover:bg-gray-100 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                Daftar Sekarang
            </a>
            <a href="#demo" class="px-8 py-4 border-2 border-white text-white rounded-full font-bold text-lg hover:bg-white hover:text-cyan-600 transition-all duration-300">
                Jadwalkan Demo
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 py-12 px-6">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <div>
                <h3 class="text-2xl font-bold mb-4"><span class="text-cyan-500">pos</span><span class="text-white">kasir</span></h3>
                <p class="text-gray-400">Sistem kasir modern untuk bisnis masa depan</p>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-4">Produk</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">Fitur</a></li>
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">Harga</a></li>
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">Demo</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-4">Perusahaan</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">Blog</a></li>
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">Karir</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-4">Bantuan</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">FAQ</a></li>
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">Kontak</a></li>
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">Support</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 text-center text-gray-500">
            <p>&copy; 2024 POS Kasir. All rights reserved.</p>
        </div>
    </div>
</footer>
@endsection
