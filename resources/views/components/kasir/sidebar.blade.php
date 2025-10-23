<!-- Kasir Sidebar -->
<aside class="w-64 bg-blue-900 text-white min-h-screen">
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-2"><span class="text-blue-300">POS</span>Kasir</h2>
        <p class="text-blue-200 text-sm">Kasir Panel</p>
    </div>
    
    <nav class="mt-6">
        <a href="/kasir/dashboard" class="flex items-center px-6 py-3 text-blue-200 hover:bg-blue-800 hover:text-white transition-colors {{ request()->is('kasir/dashboard') ? 'bg-blue-800 text-white border-l-4 border-blue-300' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Dashboard
        </a>
        
        <a href="/kasir/transaction" class="flex items-center px-6 py-3 text-blue-200 hover:bg-blue-800 hover:text-white transition-colors {{ request()->is('kasir/transaction*') ? 'bg-blue-800 text-white border-l-4 border-blue-300' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            New Transaction
        </a>
        
        <a href="/kasir/history" class="flex items-center px-6 py-3 text-blue-200 hover:bg-blue-800 hover:text-white transition-colors {{ request()->is('kasir/history*') ? 'bg-blue-800 text-white border-l-4 border-blue-300' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Transaction History
        </a>
        
        <a href="/kasir/products" class="flex items-center px-6 py-3 text-blue-200 hover:bg-blue-800 hover:text-white transition-colors {{ request()->is('kasir/products*') ? 'bg-blue-800 text-white border-l-4 border-blue-300' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            Products
        </a>
        
        <a href="/kasir/report" class="flex items-center px-6 py-3 text-blue-200 hover:bg-blue-800 hover:text-white transition-colors {{ request()->is('kasir/report*') ? 'bg-blue-800 text-white border-l-4 border-blue-300' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Daily Report
        </a>
    </nav>
    
    <div class="absolute bottom-0 w-64 p-6 border-t border-blue-800">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="flex items-center text-blue-200 hover:text-red-400 transition-colors w-full">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>
