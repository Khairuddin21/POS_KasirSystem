<!-- Kasir Sidebar - Compact Version -->
<aside class="w-20 text-white flex flex-col" style="background-color: #19c9e5; min-height: 100vh;">
    <!-- Logo -->
    <div class="p-4 text-center border-b border-white border-opacity-20">
        <div class="w-12 h-12 mx-auto bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
            <span class="text-2xl font-bold">🏪</span>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="mt-4 flex-1 flex flex-col items-center space-y-2 px-2">
        <a href="/kasir/dashboard" 
           class="nav-btn {{ request()->is('kasir/dashboard') ? 'active' : '' }}" 
           title="Dashboard">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
        </a>
        
        <a href="/kasir/transaction" 
           class="nav-btn {{ request()->is('kasir/transaction*') ? 'active' : '' }}" 
           title="New Transaction">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </a>
        
        <a href="/kasir/history" 
           class="nav-btn {{ request()->is('kasir/history*') ? 'active' : '' }}" 
           title="Transaction History">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
        </a>
        
        <a href="/kasir/products" 
           class="nav-btn {{ request()->is('kasir/products*') ? 'active' : '' }}" 
           title="Products">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
        </a>
        
        <a href="/kasir/report" 
           class="nav-btn {{ request()->is('kasir/report*') ? 'active' : '' }}" 
           title="Daily Report">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </a>
    </nav>
    
    <!-- Logout -->
    <div class="mt-auto p-2 border-t border-white border-opacity-20 flex items-center justify-center">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="nav-btn logout-btn" title="Logout">
                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </button>
        </form>
    </div>
</aside>

<style>
.nav-btn {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    transition: all 0.3s ease;
    color: rgba(255, 255, 255, 0.7);
    position: relative;
}

.nav-btn:hover {
    background-color: rgba(255, 255, 255, 0.15);
    color: white;
    transform: translateX(2px);
}

.nav-btn.active {
    background-color: rgba(255, 255, 255, 0.25);
    color: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.nav-btn.active::before {
    content: '';
    position: absolute;
    left: -8px;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 24px;
    background-color: white;
    border-radius: 0 4px 4px 0;
}

.logout-btn:hover {
    background-color: rgba(239, 68, 68, 0.2);
    color: #fee;
}
</style>
