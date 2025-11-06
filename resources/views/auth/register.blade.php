@extends('layouts.main')

@section('title', 'Register - POS Kasir')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Image Slider -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-cyan-400 via-cyan-500 to-cyan-600 relative overflow-hidden">
        <div class="absolute inset-0 flex items-center justify-center p-12">
            <!-- Image 1 -->
            <div class="register-image active w-full h-full flex items-center justify-center">
                <img src="{{ asset('images/login-1.png') }}" alt="POS Kasir System" class="max-w-full max-h-full object-contain drop-shadow-2xl">
            </div>
            <!-- Image 2 -->
            <div class="register-image w-full h-full flex items-center justify-center">
                <img src="{{ asset('images/login-2.png') }}" alt="Modern Dashboard" class="max-w-full max-h-full object-contain drop-shadow-2xl">
            </div>
            <!-- Image 3 -->
            <div class="register-image w-full h-full flex items-center justify-center">
                <img src="{{ asset('images/login-3.png') }}" alt="Analytics & Reports" class="max-w-full max-h-full object-contain drop-shadow-2xl">
            </div>
        </div>
        
        <!-- Overlay Text -->
        <div class="absolute bottom-12 left-12 right-12 text-white z-10">
            <h2 class="text-4xl font-bold mb-4">Bergabunglah dengan Kami</h2>
            <p class="text-xl text-cyan-50">Mulai kelola bisnis Anda dengan sistem kasir modern dan profesional</p>
        </div>
    </div>
    
    <!-- Right Side - Register Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <h1 class="text-4xl font-bold">
                        <span class="text-cyan-500">pos</span><span class="text-gray-800">kasir</span>
                    </h1>
                </a>
                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-2">Buat Akun Baru</h2>
                <p class="text-gray-600">Daftar dan mulai gunakan POS Kasir sekarang</p>
            </div>
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Error Message -->
            @if($errors->has('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $errors->first('error') }}
                </div>
            @endif
            
            <!-- Register Form -->
            <form method="POST" action="{{ route('register.post') }}" class="space-y-5" id="registerForm">
                @csrf
                
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        required 
                        autofocus
                        class="w-full px-4 py-3 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300"
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        class="w-full px-4 py-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300"
                        placeholder="nama@email.com"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
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
                            class="w-full px-4 py-3 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300"
                            placeholder="Minimal 8 karakter"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        >
                            <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Password Strength Indicator -->
                    <div id="passwordStrength" class="hidden mt-2">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 bg-gray-200 rounded-full h-1.5">
                                <div id="strengthBar" class="h-1.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <span id="strengthText" class="text-xs font-medium"></span>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300"
                            placeholder="Ketik ulang password"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password_confirmation')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        >
                            <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    <p id="passwordMatch" class="hidden mt-2 text-sm"></p>
                </div>
                
                <!-- Terms & Conditions -->
                <div class="flex items-start">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        name="terms" 
                        required
                        class="w-4 h-4 mt-1 text-cyan-500 border-gray-300 rounded focus:ring-cyan-500"
                    >
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        Saya setuju dengan <a href="#" class="text-cyan-500 hover:text-cyan-600 font-medium">Syarat & Ketentuan</a> serta <a href="#" class="text-cyan-500 hover:text-cyan-600 font-medium">Kebijakan Privasi</a>
                    </label>
                </div>
                
                <!-- Register Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-cyan-500 hover:bg-cyan-600 text-white font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                >
                    Daftar Sekarang
                </button>
            </form>
            
            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">Atau daftar dengan</span>
                </div>
            </div>
            
            <!-- Google Register -->
            <button 
                type="button"
                onclick="registerWithGoogle()"
                class="w-full py-3 px-4 border-2 border-gray-300 rounded-lg flex items-center justify-center space-x-3 hover:border-cyan-500 hover:bg-cyan-50 transition-all duration-300 group"
            >
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="font-medium text-gray-700 group-hover:text-cyan-600">Daftar dengan Google</span>
            </button>
            
            <!-- Login Link -->
            <p class="text-center mt-8 text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-cyan-500 hover:text-cyan-600 font-bold transition-colors">
                    Login sekarang!
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
    .register-image {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        pointer-events: none;
    }
    
    .register-image.active {
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
</style>
@endpush

@push('scripts')
<script>
    // Image Slider
    let currentImage = 0;
    const images = document.querySelectorAll('.register-image');
    const slideInterval = 6000; // 6 seconds
    
    function showNextImage() {
        images[currentImage].classList.remove('active');
        currentImage = (currentImage + 1) % images.length;
        images[currentImage].classList.add('active');
    }
    
    // Auto slide images
    setInterval(showNextImage, slideInterval);
    
    // Toggle Password Visibility
    function togglePassword(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const button = passwordInput.nextElementSibling;
        const eyeIcon = button.querySelector('.eye-open');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.style.opacity = '0.5';
        } else {
            passwordInput.type = 'password';
            eyeIcon.style.opacity = '1';
        }
    }
    
    // Google Register
    function registerWithGoogle() {
        console.log('Google register clicked');
        alert('Google register akan diimplementasikan dengan OAuth 2.0');
    }
    
    // Password Strength Indicator
    const passwordInput = document.getElementById('password');
    const strengthContainer = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        if (password.length === 0) {
            strengthContainer.classList.add('hidden');
            return;
        }
        
        strengthContainer.classList.remove('hidden');
        
        let strength = 0;
        let color = '';
        let text = '';
        
        // Length check
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        
        // Character variety checks
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
        if (password.match(/\d/)) strength++;
        if (password.match(/[^a-zA-Z\d]/)) strength++;
        
        // Set color and text based on strength
        if (strength <= 1) {
            color = '#ef4444'; // red
            text = 'Lemah';
        } else if (strength === 2 || strength === 3) {
            color = '#f59e0b'; // orange
            text = 'Sedang';
        } else {
            color = '#22c55e'; // green
            text = 'Kuat';
        }
        
        strengthBar.style.width = (strength * 20) + '%';
        strengthBar.style.backgroundColor = color;
        strengthText.textContent = text;
        strengthText.style.color = color;
    });
    
    // Confirm password validation
    const passwordConfirmation = document.getElementById('password_confirmation');
    const passwordMatch = document.getElementById('passwordMatch');
    
    passwordConfirmation.addEventListener('input', function() {
        const password = passwordInput.value;
        const confirmation = this.value;
        
        if (confirmation.length === 0) {
            passwordMatch.classList.add('hidden');
            this.setCustomValidity('');
            return;
        }
        
        passwordMatch.classList.remove('hidden');
        
        if (password === confirmation) {
            passwordMatch.textContent = '✓ Password cocok';
            passwordMatch.className = 'mt-2 text-sm text-green-600 flex items-center';
            this.setCustomValidity('');
        } else {
            passwordMatch.textContent = '✗ Password tidak cocok';
            passwordMatch.className = 'mt-2 text-sm text-red-600 flex items-center';
            this.setCustomValidity('Password tidak cocok');
        }
    });
    
    // Form validation
    const registerForm = document.getElementById('registerForm');
    registerForm.addEventListener('submit', function(e) {
        const terms = document.getElementById('terms');
        if (!terms.checked) {
            e.preventDefault();
            alert('⚠️ Mohon setujui Syarat & Ketentuan untuk melanjutkan');
            terms.focus();
            return false;
        }
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        `;
    });
    
    console.log('✅ Register Page Loaded! 📝');
</script>
@endpush
@endsection
