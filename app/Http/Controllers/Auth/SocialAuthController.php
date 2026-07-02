<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;

class SocialAuthController extends Controller
{
    // GOOGLE
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        // try {
        //     $googleUser = Socialite::driver('google')->user();
        //     dd($googleUser);
        // } catch (Exception $e) {
        //     dd($e->getMessage());
        // }

        try {
            $googleUser = Socialite::driver('google')->user();
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                Auth::login($existingUser);
                return redirect()->route('user.landing');
            }

            // Show registration completion page
            return view('auth.social-register', [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'provider' => 'google',
            ]);
        } catch (Exception $e) {
            return redirect()->route('register-form')->with('error', 'Google login failed.');
        }
    }

    // FACEBOOK
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $fbUser = Socialite::driver('facebook')->user();
            $existingUser = User::where('email', $fbUser->getEmail())->first();

            if ($existingUser) {
                Auth::login($existingUser);
                return redirect()->route('user.landing');
            }

            // Show registration completion page
            return view('auth.social-register', [
                'email' => $fbUser->getEmail(),
                'name' => $fbUser->getName(),
                'provider' => 'facebook',
            ]);
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Facebook login failed.');
        }
    }

    // COMPLETE REGISTRATION (for both Google and Facebook)
    public function completeSocialRegistration(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'provider' => 'required|string',
        ]);

        $user = User::create([
            'email' => $request->email,
            'name' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('user.landing')->with('msg', 'Welcome to LangLearn!');
    }

}
