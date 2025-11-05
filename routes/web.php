<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Kasir\KasirController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;

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
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard/data', [AdminController::class, 'getDashboardData'])->name('admin.dashboard.data');
        
        // User Management Routes
        Route::get('/users', [UserController::class, 'index'])->name('admin.users');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('admin.users.show');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('admin.users.reset-password');
        
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
    
    Route::get('/history', [KasirController::class, 'history'])->name('kasir.history');
    Route::get('/history/data', [KasirController::class, 'getReportData'])->name('kasir.history.data');
    Route::get('/history/export/excel', [KasirController::class, 'exportExcel'])->name('kasir.history.export.excel');
    Route::get('/history/export/pdf', [KasirController::class, 'exportPDF'])->name('kasir.history.export.pdf');
    Route::get('/history/{id}', [KasirController::class, 'getTransactionDetail'])->name('kasir.history.detail');
    
    Route::get('/products', function () {
        return view('kasir.products');
    })->name('kasir.products');
    
    Route::get('/report', [KasirController::class, 'dailyReport'])->name('kasir.report');
    Route::get('/report/data', [KasirController::class, 'getDailyReportData'])->name('kasir.report.data');
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
