@extends('layouts.auth')

@section('main-content')
<div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-xl border border-slate-200 p-10 w-full max-w-md text-center">
    <img src="https://img.icons8.com/color/96/language.png" alt="Language Icon" class="mx-auto mb-4">
        <h1 class="text-3xl font-extrabold mb-2 bg-gradient-to-r from-indigo-400 to-purple-500 text-transparent bg-clip-text">
            Welcome to Language Platform
        </h1>
        <p class="text-slate-500 text-lg mb-6">
            Register Your Account
        </p>

    <form method="POST" action="{{ route('social.register.complete') }}" class="flex flex-col gap-3">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="provider" value="{{ $provider }}">

        <input type="text" name="username" placeholder="Enter Username"
            value="{{ old('username', $name ?? '') }}"
            class="rounded-xl border border-slate-300 bg-slate-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400">
        @error('username')
            <p class="text-red-500 text-sm text-left pl-2">{{ $message }}</p>
        @enderror

        <input type="password" name="password" placeholder="Enter Password"
            class="rounded-xl border border-slate-300 bg-slate-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400">
        @error('password')
            <p class="text-red-500 text-sm text-left pl-2">{{ $message }}</p>
        @enderror

        <input type="password" name="password_confirmation" placeholder="Confirm Password"
            class="rounded-xl border border-slate-300 bg-slate-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400">

        <button type="submit"
            class="rounded-xl bg-gradient-to-r from-sky-400 to-cyan-400 text-white font-bold text-lg py-2 mt-2 shadow-md hover:from-indigo-500 hover:to-purple-500 transition-transform transform hover:scale-105">
            Register
        </button>
    </form>
</div>
@endsection
