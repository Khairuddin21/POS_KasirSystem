<?php

use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('landing');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', function () {
        return view('auth.admin-login');
    })->name('admin.login');
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/users', function () {
        return view('admin.users');
    })->name('admin.users');
    
    Route::get('/products', function () {
        return view('admin.products');
    })->name('admin.products');
    
    Route::get('/transactions', function () {
        return view('admin.transactions');
    })->name('admin.transactions');
    
    Route::get('/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');
    
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
});

// Kasir Routes
Route::prefix('kasir')->group(function () {
    Route::get('/login', function () {
        return view('auth.kasir-login');
    })->name('kasir.login');
    
    Route::get('/dashboard', function () {
        return view('kasir.dashboard');
    })->name('kasir.dashboard');
    
    Route::get('/transaction', function () {
        return view('kasir.transaction');
    })->name('kasir.transaction');
    
    Route::get('/history', function () {
        return view('kasir.history');
    })->name('kasir.history');
    
    Route::get('/products', function () {
        return view('kasir.products');
    })->name('kasir.products');
    
    Route::get('/report', function () {
        return view('kasir.report');
    })->name('kasir.report');
});

// User Routes
Route::prefix('user')->group(function () {
    Route::get('/login', function () {
        return view('auth.user-login');
    })->name('user.login');
    
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    
    Route::get('/transactions', function () {
        return view('user.transactions');
    })->name('user.transactions');
    
    Route::get('/profile', function () {
        return view('user.profile');
    })->name('user.profile');
    
    Route::get('/settings', function () {
        return view('user.settings');
    })->name('user.settings');
});

// Auth Routes (Common)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/logout', function () {
    // Logout logic here
    return redirect('/');
})->name('logout');
