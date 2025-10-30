<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Kasir\KasirController;
use App\Http\Controllers\MemberController;

// Landing Page
Route::get('/', function () {
    return view('landing');
});

// Auth Routes (Common)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    // Registration logic here
    return redirect()->route('login')->with('success', 'Registration successful! Please login.');
});

Route::get('/password/reset', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
    
    Route::middleware(['auth'])->group(function () {
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
});

// Kasir Routes
Route::prefix('kasir')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('kasir.dashboard');
    
    Route::post('/transaction/process', [KasirController::class, 'processTransaction'])->name('kasir.transaction.process');
    
    // Member Management Routes
    Route::get('/member', [MemberController::class, 'index'])->name('kasir.member');
    Route::post('/member', [MemberController::class, 'store'])->name('kasir.member.store');
    Route::get('/member/search', [MemberController::class, 'search'])->name('kasir.member.search');
    Route::get('/member/{member}', function(\App\Models\Member $member) {
        return response()->json(['success' => true, 'member' => $member]);
    });
    Route::put('/member/{member}', [MemberController::class, 'update'])->name('kasir.member.update');
    Route::delete('/member/{member}', [MemberController::class, 'destroy'])->name('kasir.member.destroy');
    Route::post('/member/{member}/toggle-status', [MemberController::class, 'toggleStatus'])->name('kasir.member.toggle');
    
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
Route::prefix('user')->middleware(['auth'])->group(function () {
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
