<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function showRegisterForm()
    {
        return view('auth.register');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password'
            ]);
        }

        Auth::login($user);

        if ($user->role === 'superuser') {
            return response()->json([
                'success' => true,
                'message' => 'Login successful (admin)',
                'redirect' => route('admin_dashboard')
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful (user)',
            'redirect' => route('user_landing')
        ]);
    }


    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('msg', 'Registration successful. Please log in.');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
