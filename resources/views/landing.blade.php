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
            
            <div class="fade-in-right">
                <img src="{{ asset('images/Image-4.png') }}" alt="POS Kasir - Kasir Modern" class="w-full max-w-lg mx-auto drop-shadow-2xl floating">
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
                <img src="{{ asset('images/Aset_Fitur_AplikasiKasir_ContentBlock2.png') }}" alt="Ragam Opsi Pembayaran" class="w-full max-w-lg mx-auto drop-shadow-2xl">
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
    </div>
</section>

<!-- Cashier Management Section -->
<section class="py-20 px-6 bg-white cashier-section">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center mb-20">
            <div class="fade-in">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-800">
                    Kelola Kasir dengan <span class="text-cyan-500">Lebih Mudah dan Efisien</span>
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Sistem kasir yang dirancang untuk memaksimalkan produktivitas dan meminimalkan kesalahan transaksi
                </p>
                
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Proses Transaksi Cepat</h3>
                            <p class="text-gray-600">Interface intuitif yang memungkinkan kasir melakukan transaksi dalam hitungan detik</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Perhitungan Otomatis</h3>
                            <p class="text-gray-600">Sistem otomatis menghitung total, diskon, dan kembalian dengan akurat</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Multi Payment Method</h3>
                            <p class="text-gray-600">Terima berbagai metode pembayaran dalam satu transaksi</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="fade-in-right">
                <img src="{{ asset('images/cashier.png') }}" alt="Sistem Kasir Modern" class="w-full max-w-lg mx-auto drop-shadow-2xl rounded-2xl">
            </div>
        </div>
        
        <!-- Second Cashier Section -->
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="fade-in-left order-2 md:order-1">
                <img src="{{ asset('images/cashier2.png') }}" alt="Laporan dan Analytics" class="w-full max-w-lg mx-auto drop-shadow-2xl rounded-2xl">
            </div>
            
            <div class="fade-in order-1 md:order-2">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-800">
                    Laporan Lengkap untuk <span class="text-cyan-500">Keputusan Bisnis Tepat</span>
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Monitor performa bisnis Anda secara real-time dengan dashboard analitik yang komprehensif
                </p>
                
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Laporan Real-time</h3>
                            <p class="text-gray-600">Pantau penjualan, stok, dan kinerja bisnis secara langsung</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Analisis Penjualan</h3>
                            <p class="text-gray-600">Identifikasi produk terlaris dan tren penjualan untuk strategi bisnis</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Export Data</h3>
                            <p class="text-gray-600">Export laporan ke berbagai format untuk keperluan akuntansi dan audit</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 px-6 bg-gradient-to-r from-cyan-500 to-blue-600">
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

<!-- Contact Section -->
<section class="py-20 px-6 bg-gray-50" id="kontak">
    <div class="container mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-800">Hubungi Kami</h2>
            <p class="text-xl text-gray-600">Kami siap membantu Anda mengembangkan bisnis</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Phone Contact -->
            <div class="contact-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 text-center">
                <div class="w-16 h-16 bg-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 icon-bounce">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Telepon</h3>
                <p class="text-gray-600 mb-4">Hubungi kami untuk konsultasi</p>
                <a href="tel:+6281381391621" class="text-cyan-500 font-bold text-lg hover:text-cyan-600 transition-colors">
                    +62 813-8139-1621
                </a>
                <div class="mt-4">
                    <a href="https://wa.me/6281381391621" target="_blank" class="whatsapp-btn inline-flex items-center px-6 py-3 bg-green-500 text-white rounded-full font-bold hover:bg-green-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        WhatsApp
                    </a>
                </div>
            </div>
            
            <!-- Address -->
            <div class="contact-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 text-center">
                <div class="w-16 h-16 bg-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 icon-bounce">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Alamat</h3>
                <p class="text-gray-600 mb-4">Kunjungi kantor kami</p>
                <p class="text-gray-700 font-medium">
                    JL. Haji Mugeni III
                </p>
            </div>
            
            <!-- Email -->
            <div class="contact-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 text-center">
                <div class="w-16 h-16 bg-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 icon-bounce">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Email</h3>
                <p class="text-gray-600 mb-4">Kirim pertanyaan Anda</p>
                <a href="mailto:bismilahdan&@mail.com" class="text-cyan-500 font-bold text-lg hover:text-cyan-600 transition-colors break-all">
                    bismilahdan&@mail.com
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 py-12 px-6">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <div>
                <h3 class="text-2xl font-bold mb-4"><span class="text-cyan-500">pos</span><span class="text-white">kasir</span></h3>
                <p class="text-gray-400 mb-4">Sistem kasir modern untuk bisnis masa depan</p>
                <div class="flex space-x-4">
                    <a href="#" class="social-icon w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-cyan-500 transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-icon w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-cyan-500 transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-icon w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-cyan-500 transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-4">Produk</h4>
                <ul class="space-y-2">
                    <li><a href="#fitur" class="hover:text-cyan-500 transition-colors">Fitur</a></li>
                    <li><a href="#solusi" class="hover:text-cyan-500 transition-colors">Solusi</a></li>
                    <li><a href="#keunggulan" class="hover:text-cyan-500 transition-colors">Keunggulan</a></li>
                    <li><a href="#harga" class="hover:text-cyan-500 transition-colors">Harga</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-4">Perusahaan</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">Blog</a></li>
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">Karir</a></li>
                    <li><a href="#" class="hover:text-cyan-500 transition-colors">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-4">Contact Us</h4>
                <ul class="space-y-3">
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-cyan-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm">JL. Haji Mugeni III</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-cyan-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <a href="tel:+6281381391621" class="text-sm hover:text-cyan-500 transition-colors">+62 813-8139-1621</a>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-cyan-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:bismilahdan&@mail.com" class="text-sm hover:text-cyan-500 transition-colors break-all">bismilahdan&@mail.com</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 text-center text-gray-500">
            <p>&copy; 2024 POS Kasir. All rights reserved. Made with ❤️ for your business</p>
        </div>
    </div>
</footer>
@endsection
