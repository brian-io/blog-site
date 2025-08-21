@extends('layouts.guest')

@section('content')
<div class="px-4 sm:px-0 max-w-md mx-auto">
    {{-- Header --}}
    <div class="text-center mb-12">
        <h1 class="text-3xl font-light text-gray-900 serif tracking-wide mb-2">Welcome Back</h1>
        <p class="text-gray-600">Sign in to continue writing</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-8 p-4 bg-gray-50 border border-gray-100 rounded-lg">
            <p class="text-sm text-gray-700 tracking-wide">{{ session('status') }}</p>
        </div>
    @endif

    {{-- Login Form --}}
    <form method="POST" action="{{ route('login') }}" class="space-y-8">
        @csrf

        {{-- Email Address --}}
        <div class="space-y-3">
            <label for="email" class="block text-sm font-medium text-gray-900 tracking-wide">
                Email Address
            </label>
            <input 
                id="email" 
                class="block w-full px-0 py-3 border-0 border-b border-gray-200 bg-transparent placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-gray-400 text-gray-900 transition-colors duration-300" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                placeholder="Enter your email address"
                required 
                autofocus 
                autocomplete="username" 
            />
            @error('email')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="space-y-3">
            <label for="password" class="block text-sm font-medium text-gray-900 tracking-wide">
                Password
            </label>
            <input 
                id="password" 
                class="block w-full px-0 py-3 border-0 border-b border-gray-200 bg-transparent placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-gray-400 text-gray-900 transition-colors duration-300" 
                type="password" 
                name="password" 
                placeholder="Enter your password"
                required 
                autocomplete="current-password" 
            />
            @error('password')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="flex items-center justify-between pt-4">
            <label for="remember_me" class="flex items-center cursor-pointer">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="h-4 w-4 text-gray-600 focus:ring-gray-400 border-gray-300 rounded transition-colors duration-300" 
                    name="remember"
                >
                <span class="ml-3 text-sm text-gray-600 tracking-wide">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 hover:text-gray-900 font-medium tracking-wide transition-colors duration-300" 
                   href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        {{-- Submit Button --}}
        <div class="pt-6">
            <button 
                type="submit" 
                class="w-full relative gradient-border bg-white text-gray-800 px-6 py-3 rounded-full text-sm font-medium hover:shadow-md transition-all duration-300 tracking-wide"
            >
                Sign In
            </button>
        </div>
    </form>

    {{-- Sign Up Link --}}
    <div class="mt-12 text-center pt-8 border-t border-gray-100">
        <p class="text-gray-600 tracking-wide">
            Don't have an account? 
            <a href="#" class="text-gray-900 hover:text-gray-700 font-medium transition-colors duration-300">
                Create one here
            </a>
        </p>
    </div>
</div>
@endsection