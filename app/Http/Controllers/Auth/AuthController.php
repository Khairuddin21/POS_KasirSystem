<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Show login form (user)
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Show admin login form
    public function showAdminLoginForm()
    {
        return view('auth.admin.login');
    }

    // Handle user login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect based on role
            return $this->redirectBasedOnRole($user);
        }

        return redirect()->back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput();
    }

    // Handle admin login
    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Check if user is admin
            if ($user->role !== 'admin') {
                Auth::logout();
                return redirect()->back()
                    ->withErrors(['email' => 'Halaman ini hanya untuk administrator.'])
                    ->withInput();
            }
            
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput();
    }

    // Redirect based on user role
    protected function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'kasir':
                return redirect()->route('kasir.dashboard');
            case 'user':
                return redirect()->route('user.dashboard');
            default:
                return redirect()->route('user.dashboard');
        }
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
