@extends('layouts.auth')

@section('main-content')
<div class="w-full min-h-screen flex items-center justify-center">
    <div class="bg-white/85 border border-slate-200 backdrop-blur-xl rounded-[32px] shadow-lg p-10 max-w-md w-full text-center">
        <img src="https://img.icons8.com/color/96/language.png" alt="Language Icon" class="mx-auto mb-4">
        <h1 class="text-3xl font-extrabold mb-2 bg-gradient-to-r from-indigo-400 to-purple-500 text-transparent bg-clip-text">
            Welcome to Language Platform
        </h1>
        <p class="text-slate-500 text-lg mb-6">
            Empowering learners to master new languages in a friendly environment.
        </p>

        <form id="loginForm" method="POST" action="{{ route('login-form') }}" class="flex flex-col gap-4 mb-4">
            @csrf
            <div class="relative">
                <input type="email" name="email" placeholder="Email" required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3 py-3 text-base focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-400 transition">
                <img src="https://img.icons8.com/ios-filled/24/667eea/new-post.png"
                    class="absolute left-3 top-1/2 -translate-y-1/2">
            </div>

            <div class="relative">
                <input type="password" name="password" placeholder="Enter Password" required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3 py-3 text-base focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-400 transition">
                <img src="https://img.icons8.com/ios-filled/24/667eea/lock-2.png"
                    class="absolute left-3 top-1/2 -translate-y-1/2">
            </div>

            <button type="submit"
                class="rounded-xl bg-gradient-to-r from-sky-400 to-cyan-400 text-white font-bold text-lg py-3 shadow-md hover:from-indigo-400 hover:to-purple-500 transform hover:-translate-y-1 hover:scale-105 transition">
                Login
            </button>
        </form>

        <p class="text-slate-600 text-sm mb-4">or continue with</p>

        <!-- Social login icons -->
        <div class="flex justify-center gap-3 mb-1">
            <a href="{{ route('google.login') }}"
                class="p-1 rounded-full border border-slate-300 hover:bg-slate-100 transition transform hover:scale-110">
                <img src="https://img.icons8.com/color/36/google-logo.png" alt="Google">
            </a>

            <a href="{{ route('facebook.login') }}"
                class="p-1 rounded-full border border-slate-300 hover:bg-slate-100 transition transform hover:scale-110">
                <img src="https://img.icons8.com/color/36/facebook-new.png" alt="Facebook">
            </a>
        </div>

        <p class="text-slate-600 text-sm">You don't have an Account?
            <a href="{{ route('register') }}"
                class="text-indigo-500 font-semibold hover:text-purple-500 hover:underline transition mt-2 inline-block">
                <i class="fa-solid fa-user-plus mr-1"></i> Register
            </a>
        </p>
    </div>
</div>

<script>
    const LOGIN_URL = "{{ route('login-form') }}";
</script>
@endsection
