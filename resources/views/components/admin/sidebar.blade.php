<!-- Admin Sidebar -->
<aside class="w-64 bg-gray-900 text-white min-h-screen flex flex-col">
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-2"><span class="text-cyan-500">POS</span>Kasir</h2>
        <p class="text-gray-400 text-sm">Admin Panel</p>
    </div>
    
    <nav class="mt-6 flex-1">
        <a href="/admin/dashboard" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-cyan-500 transition-colors {{ request()->is('admin/dashboard') ? 'bg-gray-800 text-cyan-500 border-l-4 border-cyan-500' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Dashboard
        </a>
        
        <a href="/admin/users" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-cyan-500 transition-colors {{ request()->is('admin/users*') ? 'bg-gray-800 text-cyan-500 border-l-4 border-cyan-500' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            User Management
        </a>
        
        <a href="/admin/products" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-cyan-500 transition-colors {{ request()->is('admin/products*') ? 'bg-gray-800 text-cyan-500 border-l-4 border-cyan-500' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            Products
        </a>
        
        <a href="/admin/transactions" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-cyan-500 transition-colors {{ request()->is('admin/transactions*') ? 'bg-gray-800 text-cyan-500 border-l-4 border-cyan-500' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Transactions
        </a>
        
        <a href="/admin/reports" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-cyan-500 transition-colors {{ request()->is('admin/reports*') ? 'bg-gray-800 text-cyan-500 border-l-4 border-cyan-500' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Reports
        </a>
        
        <a href="/admin/settings" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-cyan-500 transition-colors {{ request()->is('admin/settings*') ? 'bg-gray-800 text-cyan-500 border-l-4 border-cyan-500' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Settings
        </a>
    </nav>
    
    <!-- Logout Button - Always at Bottom -->
    <div class="p-6 border-t border-gray-800 mt-auto">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="flex items-center text-gray-300 hover:text-red-500 transition-colors w-full">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>
