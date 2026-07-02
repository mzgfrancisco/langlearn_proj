@extends('layouts.auth')

@section('main-content')
    <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-xl border border-slate-200 p-10 w-full max-w-md text-center">
        <img src="https://img.icons8.com/color/96/language.png" alt="LangLearn Logo" class="w-20 h-20 mx-auto mb-5">
        <h1 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500 mb-2">
            Create Your Account
        </h1>
        <p class="text-slate-600 mb-6">Join LangLearn and start your language journey!</p>

        @if (session('msg'))
            <div class="mb-4 bg-gradient-to-r from-green-400 to-teal-300 text-green-900 font-semibold rounded-lg p-2">
                {{ session('msg') }}
            </div>
        @endif

        <form id="registerForm" method="POST" action="{{ route('register-form') }}" class="flex flex-col gap-3">
            @csrf
            <input type="text" name="username" placeholder="Enter Username"
                class="rounded-xl border border-slate-300 bg-slate-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400">
            <input type="email" name="email" placeholder="Enter Email"
                class="rounded-xl border border-slate-300 bg-slate-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400">
            <input type="password" name="password" placeholder="Enter Password"
                class="rounded-xl border border-slate-300 bg-slate-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400">
            <input type="password" name="password_confirmation" placeholder="Confirm Password"
                class="rounded-xl border border-slate-300 bg-slate-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400">
            
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit"
                class="rounded-xl bg-gradient-to-r from-sky-400 to-cyan-400 text-white font-bold text-lg py-2 mt-2 shadow-md hover:from-indigo-500 hover:to-purple-500 transition-transform transform hover:scale-105">
                Register
            </button>
        </form>

        <div class="mt-5">
            <a href="{{ route('login') }}" class="text-indigo-500 font-semibold hover:underline">
                Log In
            </a>
        </div>
    </div>
@endsection
