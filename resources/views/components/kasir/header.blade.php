<!-- Kasir Header -->
<header class="bg-white shadow-sm">
    <div class="flex items-center justify-between px-6 py-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard Kasir')</h1>
            <p class="text-sm text-gray-600">@yield('page-description', 'Selamat datang!')</p>
        </div>
        
        <div class="flex items-center space-x-4">
            <!-- Quick Actions -->
            <button class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition-colors font-medium">
                New Transaction
            </button>
            
            <!-- Profile -->
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Kasir' }}</p>
                    <p class="text-xs text-gray-600">Cashier</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name ?? 'K', 0, 1) }}
                </div>
            </div>
        </div>
    </div>
</header>
