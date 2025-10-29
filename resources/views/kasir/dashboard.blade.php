@extends('layouts.kasir')

@section('title', 'POS Kasir - Conventional Shop')

@section('content')
<div class="pos-container flex min-h-screen bg-gray-50">
    <!-- Sidebar Component -->
    @include('components.kasir.sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 flex overflow-hidden ml-0 relative">
        <!-- Products Section -->
        <div class="flex-1 flex flex-col bg-gray-50">
            <!-- Top Bar -->
            <header class="bg-white shadow-md px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="ml-3">Conventional Shop POS</span>
                        </h1>
                        <p class="text-sm text-gray-500 mt-1">
                            <span class="inline-flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                Kasir: <strong class="ml-1">{{ Auth::user()->name }}</strong>
                            </span>
                            <span class="mx-2">•</span>
                            <span id="currentTime" class="font-mono"></span>
                        </p>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <!-- Search Bar -->
                        <div class="relative search-container">
                            <input 
                                type="text" 
                                id="searchProduct" 
                                placeholder="Cari produk..." 
                            class="search-input px-4 py-3 w-80 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            >
                            <div id="searchResults" class="search-results hidden absolute top-full mt-2 w-full bg-white rounded-xl shadow-2xl border-2 border-blue-100 max-h-96 overflow-y-auto z-50"></div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Categories Horizontal Scroll -->
            <div class="category-section bg-white border-b shadow-sm">
                <div class="flex items-center space-x-3 overflow-x-auto px-6 py-4 category-scroll">
                    <button class="category-chip active" data-category="all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span>Semua</span>
                        <span class="badge">{{ $products->count() }}</span>
                    </button>
                    @foreach($categories as $category)
                    <button class="category-chip" data-category="{{ $category->id }}">
                        <span class="text-xl">{{ $category->icon }}</span>
                        <span>{{ $category->name }}</span>
                        <span class="badge">{{ $category->products->count() }}</span>
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Products Grid with Real Images -->
            <div class="products-container flex-1 p-6">
                <div id="productsGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 2xl:grid-cols-6 gap-4">
                    @foreach($products as $product)
                    <div class="product-card-modern group" 
                         data-category="{{ $product->category_id }}"
                         data-product='@json($product)'
                         data-id="{{ $product->id }}"
                         data-name="{{ $product->name }}"
                         data-price="{{ $product->price }}"
                         data-stock="{{ $product->stock }}">
                        
                        <div class="product-image-wrapper relative overflow-hidden bg-transparent rounded-2xl">
                            @if($product->image && file_exists(public_path('images/barang kasir/' . $product->image)))
                            <img src="{{ asset('images/barang kasir/' . $product->image) }}" 
                                 alt="{{ $product->name }}"
                                 class="product-image object-contain transform group-hover:scale-110 transition-transform duration-500"
                                 loading="lazy">
                            @else
                            <div class="product-placeholder w-full h-full flex items-center justify-center bg-gray-100">
                                <span class="text-6xl">{{ $product->category->icon ?? '📦' }}</span>
                            </div>
                            @endif
                            
                            <!-- Stock Badge -->
                            @if($product->stock < 10)
                            <span class="stock-badge low">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Stok: {{ $product->stock }}
                            </span>
                            @else
                            <span class="stock-badge">Stok: {{ $product->stock }}</span>
                            @endif

                            <!-- Quick Add Button -->
                            <button class="quick-add-btn" onclick="quickAddToCart(event, {{ $product->id }})">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="product-info p-3">
                            <h3 class="product-name font-bold text-gray-800 text-sm mb-1">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between">
                                <p class="product-price text-blue-600 font-bold text-lg">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                <button class="add-cart-btn" onclick="addToCartWithAnimation({{ $product->id }})">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Empty State -->
                <div id="emptyState" class="hidden text-center py-20">
                    <div class="empty-icon">🔍</div>
                    <h3 class="text-xl font-bold text-gray-600 mt-4">Produk tidak ditemukan</h3>
                    <p class="text-gray-400 mt-2">Coba kata kunci lain atau pilih kategori berbeda</p>
                </div>
            </div>
        </div>

        <!-- Right Sidebar - Shopping Cart -->
        <aside class="cart-sidebar w-96 bg-white shadow-2xl flex flex-col border-l-2 border-blue-100 sticky top-0 h-screen">
            <!-- Cart Header -->
            <div class="cart-header bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-5 relative">
                <p class="text-blue-100 text-sm">Order saat ini</p>
            </div>

            <!-- Cart Items List -->
            <div id="cartItems" class="cart-items-container flex-1 overflow-y-auto p-4">
                <div class="empty-cart text-center py-16">
                    <div class="empty-cart-icon">
                        <svg class="w-20 h-20 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-400 text-lg font-medium mt-4">Keranjang kosong</p>
                    <p class="text-gray-300 text-sm mt-2">Pilih produk untuk memulai transaksi</p>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary border-t border-gray-200 px-4 py-3 bg-gray-50">
                <div class="space-y-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold text-gray-800" id="subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-600">Pajak (10%)</span>
                        <span class="font-semibold text-gray-800" id="tax">Rp 0</span>
                    </div>
                    <div class="border-t border-gray-300 pt-2 flex justify-between">
                        <span class="text-sm font-bold text-gray-800">TOTAL</span>
                        <span class="text-lg font-bold text-blue-600" id="total">Rp 0</span>
                    </div>
                </div>
            </div>

            <!-- Payment Section - Compact -->
            <div class="payment-section border-t border-gray-200 px-4 py-3">
                <label class="text-xs font-bold text-gray-700 block mb-2">Metode Pembayaran</label>
                <div class="payment-methods grid grid-cols-4 gap-1 mb-3">
                    <button class="payment-method-btn active" data-method="cash" title="Tunai">
                        <span class="text-lg">💵</span>
                    </button>
                    <button class="payment-method-btn" data-method="card" title="Kartu">
                        <span class="text-lg">💳</span>
                    </button>
                    <button class="payment-method-btn" data-method="qris" title="QRIS">
                        <span class="text-lg">📱</span>
                    </button>
                    <button class="payment-method-btn" data-method="transfer" title="Transfer">
                        <span class="text-lg">🏦</span>
                    </button>
                </div>

                <label class="text-xs font-bold text-gray-700 block mb-1">Uang Dibayar</label>
                <div class="relative mb-2">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm font-semibold">Rp</span>
                    <input 
                        type="text" 
                        id="paidAmount" 
                        placeholder="0" 
                        class="payment-input w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-right text-lg font-bold text-gray-800"
                    >
                </div>
                
                <div class="change-display p-2 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-medium text-gray-600">Kembalian</span>
                        <span class="text-lg font-bold text-green-600" id="change">Rp 0</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons - Compact -->
            <div class="action-buttons border-t border-gray-200 px-4 py-3 space-y-2 bg-white">
                <button 
                    id="processBtn"
                    class="process-btn w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold text-sm rounded-lg transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    onclick="processTransaction()"
                    disabled
                >
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Bayar (F4)
                    </span>
                </button>
                <button 
                    class="clear-btn w-full py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm rounded-lg transition-all duration-300"
                    onclick="clearCart()"
                >
                    <span class="flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Bersihkan
                    </span>
                </button>
            </div>
        </aside>
    </div>
</div>

@push('styles')
<style>
    /* ========== GENERAL STYLES ========== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
    }

    .pos-container {
        font-family: 'Figtree', sans-serif;
        min-height: 100vh;
    }

    /* ========== SEARCH BAR ========== */
    .search-input {
        transition: all 0.3s ease;
    }

    .search-input:focus {
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.2);
        transform: translateY(-1px);
    }

    .search-results {
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ========== CATEGORY CHIPS ========== */
    .category-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        position: relative;
        overflow: hidden;
    }

    .category-chip::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.5s;
    }

    .category-chip:hover::before {
        left: 100%;
    }

    .category-chip:hover {
        border-color: #3b82f6;
        color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }

    .category-chip.active {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-color: #3b82f6;
        color: white;
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4);
    }

    .category-chip .badge {
        background: rgba(0, 0, 0, 0.1);
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 700;
    }

    .category-chip.active .badge {
        background: rgba(255, 255, 255, 0.3);
    }

    .category-scroll::-webkit-scrollbar {
        height: 6px;
    }

    .category-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    .category-scroll::-webkit-scrollbar-thumb {
        background: #3b82f6;
        border-radius: 3px;
    }

    /* ========== PRODUCT CARDS ========== */
    .product-card-modern {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        position: relative;
    }

    .product-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(59, 130, 246, 0.2);
    }

    .product-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
        z-index: 1;
    }

    .product-card-modern:hover::before {
        opacity: 1;
    }

    .product-image-wrapper {
        aspect-ratio: 1;
        position: relative;
        background: transparent;
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image {
        max-width: 90%;
        max-height: 90%;
        width: auto;
        height: auto;
        object-fit: contain;
        margin: auto;
    }

    .stock-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(34, 197, 94, 0.95);
        color: white;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        gap: 4px;
        z-index: 2;
    }

    .stock-badge.low {
        background: rgba(239, 68, 68, 0.95);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    .quick-add-btn {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        z-index: 2;
    }

    .product-card-modern:hover .quick-add-btn {
        opacity: 1;
        transform: scale(1);
    }

    .quick-add-btn:hover {
        transform: scale(1.1) rotate(90deg);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.6);
    }

    .quick-add-btn:active {
        transform: scale(0.95);
    }

    .product-info {
        background: white;
        position: relative;
        z-index: 2;
        padding: 12px;
    }

    .product-name {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.3;
        min-height: 2.6em;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .add-cart-btn {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .add-cart-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.5);
    }

    .add-cart-btn:active {
        transform: scale(0.95);
    }

    /* ========== CART SECTION ========== */
    .cart-icon {
        animation: bounce 1s infinite;
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-5px);
        }
    }

    .cart-count-badge {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 14px;
        min-width: 32px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        animation: scaleIn 0.3s ease;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }

    .cart-items-container::-webkit-scrollbar {
        width: 6px;
    }

    .cart-items-container::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    .cart-items-container::-webkit-scrollbar-thumb {
        background: #3b82f6;
        border-radius: 3px;
    }

    .cart-item {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 16px;
        padding: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
        animation: slideInRight 0.4s ease;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .cart-item:hover {
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        transform: translateX(-4px);
    }

    .cart-item-image {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: contain;
        background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%);
        padding: 8px;
        flex-shrink: 0;
    }

    .cart-item-info {
        flex: 1;
        min-width: 0;
    }

    .cart-item-name {
        font-weight: 700;
        font-size: 14px;
        color: #1f2937;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cart-item-price {
        font-weight: 700;
        color: #3b82f6;
        font-size: 16px;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .qty-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid #e5e7eb;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 700;
        color: #6b7280;
    }

    .qty-btn:hover {
        border-color: #3b82f6;
        color: #3b82f6;
        transform: scale(1.1);
    }

    .qty-btn.minus:active {
        transform: scale(0.9) rotate(-90deg);
    }

    .qty-btn.plus {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-color: #3b82f6;
        color: white;
    }

    .qty-btn.plus:hover {
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .qty-btn.plus:active {
        transform: scale(0.9) rotate(90deg);
    }

    .qty-display {
        min-width: 32px;
        text-align: center;
        font-weight: 700;
        font-size: 16px;
        color: #1f2937;
    }

    .remove-btn {
        color: #ef4444;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 4px;
    }

    .remove-btn:hover {
        transform: scale(1.2) rotate(15deg);
    }

    .remove-btn:active {
        transform: scale(0.9);
    }

    /* ========== PAYMENT SECTION ========== */
    .payment-method-btn {
        padding: 8px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        background: white;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        height: 44px;
    }

    .payment-method-btn:hover {
        border-color: #3b82f6;
        background: #eff6ff;
        transform: translateY(-1px);
    }

    .payment-method-btn.active {
        border-color: #3b82f6;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .payment-input {
        transition: all 0.3s ease;
    }

    .payment-input:focus {
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }

    .change-display {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* ========== QUICK AMOUNT BUTTONS ========== */
    .quick-btn {
        padding: 8px 16px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .quick-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.5);
    }

    .quick-btn:active {
        transform: scale(0.95);
    }

    /* ========== EMPTY STATES ========== */
    .empty-cart-icon {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .empty-icon {
        font-size: 80px;
        animation: float 3s ease-in-out infinite;
        filter: grayscale(50%);
    }

    /* ========== MODAL ========== */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-container {
        max-width: 500px;
        width: 90%;
        animation: zoomIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes zoomIn {
        from {
            opacity: 0;
            transform: scale(0.8) translateY(20px);
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
        text-align: center;
    }

    .success-animation {
        margin-bottom: 24px;
    }

    .checkmark-circle {
        width: 100px;
        height: 100px;
        margin: 0 auto;
        position: relative;
    }

    .checkmark {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: block;
        stroke-width: 3;
        stroke: #22c55e;
        stroke-miterlimit: 10;
        box-shadow: inset 0 0 0 #22c55e;
        animation: fillGreen 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
    }

    .checkmark-circle-path {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 3;
        stroke-miterlimit: 10;
        stroke: #22c55e;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        stroke: #22c55e;
        stroke-width: 3;
    }

    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }

    @keyframes scale {
        0%, 100% {
            transform: none;
        }
        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }

    @keyframes fillGreen {
        100% {
            box-shadow: inset 0 0 0 50px #22c55e;
        }
    }

    .transaction-details {
        text-align: left;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .detail-label {
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
    }

    .detail-value {
        color: #1f2937;
        font-size: 16px;
        font-weight: 700;
    }

    /* ========== NOTIFICATIONS ========== */
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

    /* ========== TIME DISPLAY ========== */
    #currentTime {
        animation: fadeIn 1s ease;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 1024px) {
        .search-input {
            width: 250px;
        }
        
        .quick-amount-btns {
            display: none !important;
        }
        
        #productsGrid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 768px) {
        .cart-sidebar {
            width: 100%;
            position: fixed;
            right: -100%;
            top: 0;
            bottom: 0;
            transition: right 0.3s ease;
            z-index: 1000;
        }

        .cart-sidebar.open {
            right: 0;
        }

        .search-input {
            width: 200px;
        }

        #productsGrid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .product-image-wrapper {
            height: 140px;
        }
        
        .product-name {
            font-size: 13px;
        }
    }

    @media (max-width: 640px) {
        .search-input {
            width: 150px;
            font-size: 14px;
            padding: 8px 8px 8px 36px;
        }
        
        #productsGrid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .product-image-wrapper {
            height: 130px;
        }
        
        .product-name {
            font-size: 12px;
        }

        .search-input + svg {
            width: 18px;
            height: 18px;
            left: 10px;
        }
    }

    /* ========== MOBILE CART TOGGLE ========== */
    .mobile-cart-toggle {
        display: none;
    }

    @media (max-width: 768px) {
        .cart-sidebar {
            width: 100%;
            position: fixed;
            right: -100%;
            top: 0;
            bottom: 0;
            transition: right 0.3s ease;
            z-index: 1000;
        }

        .cart-sidebar.show {
            right: 0;
        }

        .search-input {
            width: 200px;
        }

        #productsGrid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .product-image-wrapper {
            height: 140px;
        }
        
        .product-name {
            font-size: 13px;
        }
    }

    /* ========== LOADING ANIMATION ========== */
    .loading-spinner {
        border: 3px solid #f3f4f6;
        border-top: 3px solid #3b82f6;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

<!-- Success Modal -->
<div id="successModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-content">
            <div class="success-animation">
                <div class="checkmark-circle">
                    <svg class="checkmark" viewBox="0 0 52 52">
                        <circle class="checkmark-circle-path" cx="26" cy="26" r="25" fill="none"/>
                        <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                    </svg>
                </div>
            </div>
            
            <h3 class="text-3xl font-bold text-gray-800 mb-2">Transaksi Berhasil!</h3>
            <p class="text-gray-600 mb-6">Pembayaran telah diproses dengan sukses</p>
            
            <div class="transaction-details bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 mb-6">
                <div class="detail-row">
                    <span class="detail-label">Kode Transaksi</span>
                    <span class="detail-value" id="modalTransCode">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal</span>
                    <span class="detail-value" id="modalDate">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Belanja</span>
                    <span class="detail-value text-blue-600" id="modalTotal">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Uang Dibayar</span>
                    <span class="detail-value" id="modalPaid">-</span>
                </div>
                <div class="detail-row border-t-2 border-blue-200 pt-3 mt-3">
                    <span class="detail-label font-bold">Kembalian</span>
                    <span class="detail-value text-green-600 font-bold text-xl" id="modalChange">-</span>
                </div>
            </div>

            <div class="flex space-x-3">
                <button onclick="printReceipt()" class="flex-1 py-3 bg-white border-2 border-blue-600 text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-all duration-300">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Struk
                    </span>
                </button>
                <button onclick="closeSuccessModal()" class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300">
                    Transaksi Baru
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Notification Toast -->
<div id="notificationToast" class="notification-toast"></div>

@push('scripts')
<script>
// ========== GLOBAL VARIABLES ==========
let cart = [];
let subtotal = 0;
let tax = 0;
let total = 0;
let currentPaymentMethod = 'cash';
let searchTimeout;
let toastHideTimer = null; // timer untuk notifikasi agar tidak saling tumpang tindih

// ========== INITIALIZE ==========
document.addEventListener('DOMContentLoaded', function() {
    initializeClock();
    initializeCategoryFilter();
    initializeSearch();
    initializePaymentMethods();
    updateCart();
    
    showNotification('🎉 POS System siap digunakan!', 'success');
    console.log('🛒 Conventional Shop POS System Ready!');
});

// ========== CLOCK ==========
function initializeClock() {
    function updateClock() {
        const now = new Date();
        const time = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit',
            second: '2-digit'
        });
        const date = now.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        document.getElementById('currentTime').textContent = `${time} - ${date}`;
    }
    updateClock();
    setInterval(updateClock, 1000);
}

// ========== CATEGORY FILTER ==========
function initializeCategoryFilter() {
    const categoryBtns = document.querySelectorAll('.category-chip');
    
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active from all
            categoryBtns.forEach(b => b.classList.remove('active'));
            
            // Add active to clicked
            this.classList.add('active');
            
            const category = this.dataset.category;
            filterProducts(category);
            
            // Animate transition
            const productsGrid = document.getElementById('productsGrid');
            productsGrid.style.opacity = '0';
            productsGrid.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                productsGrid.style.transition = 'all 0.3s ease';
                productsGrid.style.opacity = '1';
                productsGrid.style.transform = 'scale(1)';
            }, 100);
        });
    });
}

function filterProducts(categoryId) {
    const products = document.querySelectorAll('.product-card-modern');
    let visibleCount = 0;
    
    products.forEach((product, index) => {
        setTimeout(() => {
            if (categoryId === 'all' || product.dataset.category === categoryId) {
                product.style.display = 'block';
                product.style.animation = `slideInUp 0.4s ease ${index * 0.05}s both`;
                visibleCount++;
            } else {
                product.style.display = 'none';
            }
        }, index * 20);
    });
    
    // Show empty state if no products
    setTimeout(() => {
        const emptyState = document.getElementById('emptyState');
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }, 500);
}

// Add slideInUp animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);

// ========== SEARCH FUNCTIONALITY ==========
function initializeSearch() {
    const searchInput = document.getElementById('searchProduct');
    const searchResults = document.getElementById('searchResults');
    
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const query = e.target.value.toLowerCase().trim();
        
        if (query.length === 0) {
            searchResults.classList.add('hidden');
            filterProducts('all');
            return;
        }
        
        searchTimeout = setTimeout(() => {
            searchProducts(query);
        }, 300);
    });
    
    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length > 0) {
            searchResults.classList.remove('hidden');
        }
    });
    
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
}

function searchProducts(query) {
    const products = document.querySelectorAll('.product-card-modern');
    const searchResults = document.getElementById('searchResults');
    let results = [];
    let visibleCount = 0;
    
    products.forEach(product => {
        const name = product.dataset.name.toLowerCase();
        const productData = JSON.parse(product.dataset.product);
        
        if (name.includes(query)) {
            product.style.display = 'block';
            visibleCount++;
            results.push(productData);
        } else {
            product.style.display = 'none';
        }
    });
    
    // Show search results dropdown
    if (results.length > 0) {
        searchResults.innerHTML = results.slice(0, 5).map(product => `
            <div class="p-3 hover:bg-blue-50 cursor-pointer transition-colors border-b border-gray-100 last:border-b-0" 
                 onclick="addToCartWithAnimation(${product.id})">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                        ${product.category?.icon || '📦'}
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-gray-800">${product.name}</p>
                        <p class="text-blue-600 font-bold text-sm">Rp ${formatNumber(product.price)}</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
            </div>
        `).join('');
        searchResults.classList.remove('hidden');
    } else {
        searchResults.innerHTML = `
            <div class="p-6 text-center text-gray-400">
                <p>Produk tidak ditemukan</p>
            </div>
        `;
        searchResults.classList.remove('hidden');
    }
    
    // Empty state
    const emptyState = document.getElementById('emptyState');
    if (visibleCount === 0) {
        emptyState.classList.remove('hidden');
    } else {
        emptyState.classList.add('hidden');
    }
}

// ========== PAYMENT METHODS ==========
function initializePaymentMethods() {
    const paymentBtns = document.querySelectorAll('.payment-method-btn');
    
    paymentBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            paymentBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentPaymentMethod = this.dataset.method;
            
            // Animate selection
            this.style.transform = 'scale(1.1)';
            setTimeout(() => {
                this.style.transform = '';
            }, 200);
        });
    });
}

// ========== CART FUNCTIONALITY ==========
function quickAddToCart(event, productId) {
    event.stopPropagation();
    addToCartWithAnimation(productId);
}

function addToCartWithAnimation(productId) {
    const productCard = document.querySelector(`[data-id="${productId}"]`);
    if (!productCard) return;
    
    const productData = JSON.parse(productCard.dataset.product);
    
    // Check stock
    if (productData.stock <= 0) {
        showNotification('❌ Stok produk habis!', 'error');
        return;
    }
    
    // Check if already in cart
    const existingItem = cart.find(item => item.id === productId);
    if (existingItem) {
        if (existingItem.quantity >= productData.stock) {
            showNotification('⚠️ Jumlah melebihi stok tersedia!', 'warning');
            return;
        }
        existingItem.quantity++;
    } else {
        cart.push({
            id: productData.id,
            name: productData.name,
            price: productData.price,
            image: productData.image,
            icon: productData.category?.icon || '📦',
            quantity: 1,
            stock: productData.stock
        });
    }
    
    // Visual feedback
    productCard.style.transform = 'scale(1.1)';
    setTimeout(() => {
        productCard.style.transform = '';
    }, 200);
    
    updateCart();
    showNotification(`✅ ${productData.name} ditambahkan ke keranjang`, 'success');
}

function updateCart() {
    const cartItemsDiv = document.getElementById('cartItems');
    const cartCount = document.getElementById('cartCount');
    
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    if (cartCount) {
        cartCount.textContent = totalItems;
    }
    
    if (cart.length === 0) {
        cartItemsDiv.innerHTML = `
            <div class="empty-cart text-center py-16">
                <div class="empty-cart-icon">
                    <svg class="w-20 h-20 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <p class="text-gray-400 text-lg font-medium mt-4">Keranjang kosong</p>
                <p class="text-gray-300 text-sm mt-2">Pilih produk untuk memulai transaksi</p>
            </div>
        `;
    } else {
        cartItemsDiv.innerHTML = cart.map((item, index) => `
            <div class="cart-item" style="animation-delay: ${index * 0.05}s">
                ${item.image ? 
                    `<img src="/images/barang kasir/${item.image}" alt="${item.name}" class="cart-item-image">` :
                    `<div class="cart-item-image text-3xl">${item.icon}</div>`
                }
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">Rp ${formatNumber(item.price)}</div>
                    <div class="text-xs text-gray-500 mt-1">Subtotal: Rp ${formatNumber(item.price * item.quantity)}</div>
                </div>
                <div class="quantity-controls">
                    <button class="qty-btn minus" onclick="decreaseQuantity(${item.id})">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <div class="qty-display">${item.quantity}</div>
                    <button class="qty-btn plus" onclick="increaseQuantity(${item.id})">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>
                <button class="remove-btn" onclick="removeFromCart(${item.id})">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        `).join('');
    }
    
    calculateTotals();
}

function increaseQuantity(productId) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        if (item.quantity >= item.stock) {
            showNotification('⚠️ Jumlah melebihi stok tersedia!', 'warning');
            return;
        }
        item.quantity++;
        updateCart();
        playSound('increment');
    }
}

function decreaseQuantity(productId) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        if (item.quantity > 1) {
            item.quantity--;
            updateCart();
            playSound('decrement');
        } else {
            removeFromCart(productId);
        }
    }
}

function removeFromCart(productId) {
    const item = cart.find(item => item.id === productId);
    if (confirm(`Hapus ${item.name} dari keranjang?`)) {
        cart = cart.filter(item => item.id !== productId);
        updateCart();
        showNotification('🗑️ Produk dihapus dari keranjang', 'info');
    }
}

function clearCart() {
    if (cart.length === 0) {
        showNotification('ℹ️ Keranjang sudah kosong', 'info');
        return;
    }
    
    if (confirm('Yakin ingin membersihkan seluruh keranjang?')) {
        cart = [];
        updateCart();
        document.getElementById('paidAmount').value = '';
        showNotification('🗑️ Keranjang telah dibersihkan', 'info');
    }
}

function calculateTotals() {
    subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    tax = Math.round(subtotal * 0.1);
    total = subtotal + tax;
    
    document.getElementById('subtotal').textContent = 'Rp ' + formatNumber(subtotal);
    document.getElementById('tax').textContent = 'Rp ' + formatNumber(tax);
    document.getElementById('total').textContent = 'Rp ' + formatNumber(total);
    
    calculateChange();
}

// ========== PAYMENT CALCULATION ==========
const paidInput = document.getElementById('paidAmount');
paidInput.addEventListener('input', function(e) {
    // Format as number
    let value = e.target.value.replace(/\D/g, '');
    e.target.value = formatInputNumber(parseInt(value) || 0);
    calculateChange();
});

function calculateChange() {
    const paidValue = document.getElementById('paidAmount').value.replace(/\D/g, '');
    const paid = parseInt(paidValue) || 0;
    const change = Math.max(0, paid - total);
    
    document.getElementById('change').textContent = 'Rp ' + formatNumber(change);
    
    // Enable/disable process button
    const processBtn = document.getElementById('processBtn');
    if (cart.length > 0 && paid >= total) {
        processBtn.disabled = false;
        processBtn.classList.add('animate-pulse');
    } else {
        processBtn.disabled = true;
        processBtn.classList.remove('animate-pulse');
    }
}

// ========== PROCESS TRANSACTION ==========
function processTransaction() {
    if (cart.length === 0) {
        showNotification('❌ Keranjang kosong!', 'error');
        return;
    }
    
    const paidValue = document.getElementById('paidAmount').value.replace(/\D/g, '');
    const paid = parseInt(paidValue) || 0;
    
    if (paid < total) {
        showNotification('❌ Pembayaran tidak mencukupi!', 'error');
        return;
    }
    
    // Show loading
    const processBtn = document.getElementById('processBtn');
    const originalText = processBtn.innerHTML;
    processBtn.innerHTML = '<div class="loading-spinner"></div>';
    processBtn.disabled = true;
    
    const data = {
        items: cart.map(item => ({
            product_id: item.id,
            quantity: item.quantity
        })),
        payment_method: currentPaymentMethod,
        paid: paid,
        subtotal: subtotal,
        tax: tax,
        total: total,
        change: paid - total
    };
    
    // Send to server
    fetch('{{ route("kasir.transaction.process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessModal(data.transaction);
            cart = [];
            updateCart();
            document.getElementById('paidAmount').value = '';
        } else {
            showNotification('❌ ' + (data.message || 'Terjadi kesalahan'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('❌ Gagal memproses transaksi', 'error');
    })
    .finally(() => {
        processBtn.innerHTML = originalText;
        processBtn.disabled = false;
    });
}

// ========== SUCCESS MODAL ==========
function showSuccessModal(transaction) {
    const modal = document.getElementById('successModal');
    
    document.getElementById('modalTransCode').textContent = transaction.transaction_code;
    document.getElementById('modalDate').textContent = new Date().toLocaleString('id-ID');
    document.getElementById('modalTotal').textContent = 'Rp ' + formatNumber(transaction.total);
    document.getElementById('modalPaid').textContent = 'Rp ' + formatNumber(transaction.paid);
    document.getElementById('modalChange').textContent = 'Rp ' + formatNumber(transaction.change);
    
    modal.classList.add('show');
    playSound('success');
}

function closeSuccessModal() {
    const modal = document.getElementById('successModal');
    modal.classList.remove('show');
}

function printReceipt() {
    showNotification('🖨️ Mencetak struk...', 'info');
    // Implement print functionality
    window.print();
}

// ========== NOTIFICATIONS ==========
function showNotification(message, type = 'info') {
    const toast = document.getElementById('notificationToast');

    const colors = {
        success: 'linear-gradient(135deg, #22c55e 0%, #16a34a 100%)',
        error: 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
        warning: 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
        info: 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)'
    };

    // set style sesuai tipe
    toast.style.background = colors[type] || colors.info;
    toast.textContent = message;

    // clear timer lama agar tidak menyisakan state
    if (toastHideTimer) {
        clearTimeout(toastHideTimer);
        toastHideTimer = null;
    }

    // tampilkan
    toast.classList.add('show');

    // sembunyikan otomatis
    toastHideTimer = setTimeout(() => {
        toast.classList.remove('show');
        // opsional: bersihkan konten setelah animasi
        setTimeout(() => { toast.textContent = ''; }, 350);
    }, 3000);

    // klik untuk dismiss cepat
    toast.onclick = () => {
        if (toastHideTimer) clearTimeout(toastHideTimer);
        toast.classList.remove('show');
        setTimeout(() => { toast.textContent = ''; }, 200);
    };
}

// ========== UTILITY FUNCTIONS ==========
function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function formatInputNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function playSound(type) {
    // Audio feedback (optional - can add sound files)
    const audio = new Audio();
    const sounds = {
        success: 'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/KnZh0JNnix6KBVFApHnePyvmwhBSqCy/',
        increment: '',
        decrement: ''
    };
    // Uncomment to add sounds
    // audio.src = sounds[type] || '';
    // audio.play().catch(e => console.log('Audio play failed'));
}

// ========== KEYBOARD SHORTCUTS ==========
document.addEventListener('keydown', function(e) {
    // F2 - Focus search
    if (e.key === 'F2') {
        e.preventDefault();
        document.getElementById('searchProduct').focus();
    }
    
    // F3 - Focus payment
    if (e.key === 'F3') {
        e.preventDefault();
        document.getElementById('paidAmount').focus();
    }
    
    // F4 - Process transaction
    if (e.key === 'F4') {
        e.preventDefault();
        const processBtn = document.getElementById('processBtn');
        if (!processBtn.disabled) {
            processTransaction();
        }
    }
    
    // ESC - Close modal
    if (e.key === 'Escape') {
        closeSuccessModal();
        closeMobileCart();
    }
});

// ========== LOG INFO ==========
console.log('%c🛒 Conventional Shop POS System', 'font-size: 20px; font-weight: bold; color: #3b82f6;');
console.log('%cKeyboard Shortcuts:', 'font-size: 14px; font-weight: bold; color: #6b7280;');
console.log('F2 - Focus Search');
console.log('F3 - Focus Payment Input');
console.log('F4 - Process Transaction');
console.log('ESC - Close Modal');
</script>
@endpush
@endsection
