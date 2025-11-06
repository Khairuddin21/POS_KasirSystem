<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'User Dashboard - POS Kasir')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        @include('components.user.header')
        
        <!-- Page Content -->
        <main class="flex-1">
            @yield('content')
        </main>
        
        <!-- Footer -->
        @include('components.user.footer')
    </div>
    
    <!-- Profile Dropdown Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownBtn = document.getElementById('profileDropdownBtn');
            const dropdownMenu = document.getElementById('profileDropdownMenu');
            const dropdownIcon = document.getElementById('profileDropdownIcon');
            
            if (dropdownBtn && dropdownMenu) {
                // Toggle dropdown
                dropdownBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                    
                    // Rotate icon
                    if (dropdownMenu.classList.contains('hidden')) {
                        dropdownIcon.style.transform = 'rotate(0deg)';
                    } else {
                        dropdownIcon.style.transform = 'rotate(180deg)';
                    }
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.add('hidden');
                        dropdownIcon.style.transform = 'rotate(0deg)';
                    }
                });
                
                // Close dropdown when pressing ESC
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !dropdownMenu.classList.contains('hidden')) {
                        dropdownMenu.classList.add('hidden');
                        dropdownIcon.style.transform = 'rotate(0deg)';
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
