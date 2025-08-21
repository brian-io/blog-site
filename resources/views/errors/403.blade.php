@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-0 max-w-2xl mx-auto text-center py-16">
    {{-- Animation --}}
    <div class="mb-12 relative">
        <!-- Floating lock animation -->
        <div class="relative inline-block">
            <div class="floating-lock lock-1"></div>
            <div class="floating-lock lock-2"></div>
            
            <!-- Main 403 typography -->
            <div class="relative z-10 mb-8">
                <h1 class="text-8xl sm:text-9xl font-light text-gray-200 serif tracking-wider mb-4 select-none">
                    4<span class="inline-block transform rotate-12 text-gray-300">0</span>3
                </h1>
            </div>
        </div>
    </div>

    {{-- Poetic description --}}
    <div class="prose prose-lg mx-auto mb-12 text-gray-600 leading-relaxed">
        <p class="mb-6">
            Beyond this gate lies a chapter you cannot enter.  
            The ink is guarded, the parchment sealed.  
            Some stories are not ours to read.
        </p>
        <p class="text-sm text-gray-500 italic">
            "The locked page whispers, but only to those with the key."
        </p>
    </div>

    {{-- Navigation options --}}
    <div class="space-y-6">
        <!-- Primary action -->
        <div>
            <a href="{{ route('blogs.index') }}" 
               class="relative gradient-border bg-white text-gray-800 px-8 py-3 rounded-full text-sm font-medium hover:shadow-md transition-all duration-300 tracking-wide inline-flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Return to Stories
            </a>
        </div>

        <!-- Secondary actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center text-sm">
            <a href="#" onclick="history.back(); return false;" 
               class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-300 tracking-wide">
                Go Back
            </a>
            <span class="hidden sm:inline text-gray-300">·</span>
            <a href="{{ route('blogs.index') }}#search" 
               class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-300 tracking-wide">
                Search Stories
            </a>
        </div>
    </div>

    {{-- Decorative separator --}}
    <div class="mt-16 mb-8">
        <div class="w-24 h-px bg-gray-200 mx-auto"></div>
    </div>

    {{-- Footer message --}}
    <div class="text-xs text-gray-400 tracking-wide">
        <p>Error 403 · Unauthorized Access</p>
    </div>
</div>

{{-- Custom styles for animations --}}
<style>
    @keyframes swing {
        0%, 100% { transform: rotate(-5deg); }
        50% { transform: rotate(5deg); }
    }

    @keyframes float-fade {
        0%, 100% { transform: translateY(0px); opacity: 0.4; }
        50% { transform: translateY(-10px); opacity: 0.7; }
    }

    .floating-lock {
        position: absolute;
        width: 50px;
        height: 60px;
        border: 2px solid #d1d5db;
        border-radius: 6px;
        background: linear-gradient(145deg, #f9fafb 0%, #f3f4f6 100%);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .floating-lock::before {
        content: '';
        position: absolute;
        top: -18px;
        left: 10px;
        right: 10px;
        height: 16px;
        border: 2px solid #d1d5db;
        border-bottom: none;
        border-radius: 9999px 9999px 0 0;
        background: #f9fafb;
    }

    .lock-1 {
        top: -40px;
        left: -80px;
        animation: swing 4s ease-in-out infinite;
        opacity: 0.7;
    }

    .lock-2 {
        bottom: -30px;
        right: -70px;
        animation: float-fade 6s ease-in-out infinite;
        opacity: 0.5;
    }

    
</style>
@endsection
