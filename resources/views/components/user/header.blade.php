<!-- User Header -->
<header class="bg-white shadow-sm sticky top-0 z-40">
    <nav class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="text-2xl font-bold">
                <a href="/" class="flex items-center">
                    <span class="text-purple-500">pos</span><span class="text-gray-800">kasir</span>
                </a>
            </div>
            
            <div class="hidden md:flex items-center space-x-8">
                <a href="/user/dashboard" class="text-gray-700 hover:text-purple-500 transition-colors">Dashboard</a>
                <a href="/user/transactions" class="text-gray-700 hover:text-purple-500 transition-colors">My Transactions</a>
                <a href="/user/profile" class="text-gray-700 hover:text-purple-500 transition-colors">Profile</a>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="relative p-2 text-gray-600 hover:text-purple-500 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                
                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                        <a href="/user/profile" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
                        <a href="/user/settings" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Settings</a>
                        <hr class="my-2">
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
