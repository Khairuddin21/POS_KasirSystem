@extends('layouts.main')

@section('title', 'Login - POS Kasir')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Image Slider -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-cyan-400 via-cyan-500 to-cyan-600 relative overflow-hidden">
        <div class="absolute inset-0 flex items-center justify-center p-12">
            <!-- Image 1 -->
            <div class="login-image active w-full h-full flex items-center justify-center">
                <img src="{{ asset('images/login-1.png') }}" alt="POS Kasir System" class="max-w-full max-h-full object-contain drop-shadow-2xl">
            </div>
            <!-- Image 2 -->
            <div class="login-image w-full h-full flex items-center justify-center">
                <img src="{{ asset('images/login-2.png') }}" alt="Modern Dashboard" class="max-w-full max-h-full object-contain drop-shadow-2xl">
            </div>
            <!-- Image 3 -->
            <div class="login-image w-full h-full flex items-center justify-center">
                <img src="{{ asset('images/login-3.png') }}" alt="Analytics & Reports" class="max-w-full max-h-full object-contain drop-shadow-2xl">
            </div>
        </div>
        
        <!-- Overlay Text -->
        <div class="absolute bottom-12 left-12 right-12 text-white z-10">
            <h2 class="text-4xl font-bold mb-4">Sistem Kasir Modern</h2>
            <p class="text-xl text-cyan-50">Kelola bisnis Anda dengan lebih efisien dan profesional</p>
        </div>
    </div>
    
    <!-- Right Side - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <h1 class="text-4xl font-bold">
                        <span class="text-cyan-500">pos</span><span class="text-gray-800">kasir</span>
                    </h1>
                </a>
                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-2">Selamat Datang Kembali</h2>
                <p class="text-gray-600">Silahkan Login dengan akun Anda</p>
            </div>
            
            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 @error('email') border-red-500 @enderror"
                        placeholder="nama@email.com"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        >
                            <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-cyan-500 border-gray-300 rounded focus:ring-cyan-500">
                        <span class="ml-2 text-sm text-gray-600">Tetap Masuk</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-cyan-500 hover:text-cyan-600 font-medium">
                        Lupa Password?
                    </a>
                </div>
                
                <!-- Login Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-cyan-500 hover:bg-cyan-600 text-white font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                >
                    Login
                </button>
            </form>
            
            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">Atau login dengan</span>
                </div>
            </div>
            
            <!-- Google Login -->
            <button 
                type="button"
                onclick="loginWithGoogle()"
                class="w-full py-3 px-4 border-2 border-gray-300 rounded-lg flex items-center justify-center space-x-3 hover:border-cyan-500 hover:bg-cyan-50 transition-all duration-300 group"
            >
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="font-medium text-gray-700 group-hover:text-cyan-600">Login dengan Google</span>
            </button>
            
            <!-- Register Link -->
            <p class="text-center mt-8 text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-cyan-500 hover:text-cyan-600 font-bold transition-colors">
                    Daftar sekarang!
                </a>
            </p>
            
            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="/" class="text-sm text-gray-500 hover:text-cyan-500 transition-colors inline-flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Image Slider Styles */
    .login-image {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        pointer-events: none;
    }
    
    .login-image.active {
        opacity: 1;
        pointer-events: auto;
    }
    
    /* Animation for form */
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .w-full.max-w-md {
        animation: slideInRight 0.6s ease-out;
    }
    
    /* Input Focus Effect */
    input:focus {
        transform: translateY(-2px);
    }
    
    /* Button Ripple Effect */
    @keyframes ripple {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        animation: ripple 0.6s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
    // Image Slider
    let currentImage = 0;
    const images = document.querySelectorAll('.login-image');
    const slideInterval = 6000; // 6 seconds
    
    function showNextImage() {
        images[currentImage].classList.remove('active');
        currentImage = (currentImage + 1) % images.length;
        images[currentImage].classList.add('active');
    }
    
    // Auto slide images
    setInterval(showNextImage, slideInterval);
    
    // Toggle Password Visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }
    
    // Google Login (placeholder - implement with your OAuth)
    function loginWithGoogle() {
        // Implement Google OAuth login here
        console.log('Google login clicked');
        alert('Google login akan diimplementasikan dengan OAuth 2.0');
        // window.location.href = '/auth/google/redirect';
    }
    
    // Form Validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
            e.preventDefault();
            alert('Mohon lengkapi semua field');
            return false;
        }
        
        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert('Format email tidak valid');
            return false;
        }
    });
    
    // Add ripple effect to buttons
    document.querySelectorAll('button[type="submit"]').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Auto focus on first input
    window.addEventListener('load', function() {
        document.getElementById('email').focus();
    });
    
    // Handle enter key
    document.getElementById('email').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('password').focus();
        }
    });
    
    console.log('Login Page Loaded! 🔐');
</script>
@endpush
@endsection
