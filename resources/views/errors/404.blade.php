{{-- resources/views/errors/404.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-0 max-w-2xl mx-auto text-center py-16">
    {{--Animation --}}
    <div class="mb-12 relative">
        <!-- Floating pages animation -->
        <div class="relative inline-block">
            <div class="floating-page page-1"></div>
            <div class="floating-page page-2"></div>
            <div class="floating-page page-3"></div>
            
            <!-- Main 404 typography -->
            <div class="relative z-10 mb-8">
                <h1 class="text-8xl sm:text-9xl font-light text-gray-200 serif tracking-wider mb-4 select-none">
                    4<span class="inline-block transform rotate-12 text-gray-300">0</span>4
                </h1>
            </div>
        </div>
        
        {{-- <!-- typewriter effect -->
        <div class="typewriter-container mb-8">
            <h2 class="text-2xl sm:text-3xl font-light text-gray-900 serif tracking-wide typewriter">
                This story doesn't exist
            </h2>
        </div> --}}
    </div>

    {{-- Poetic description hehe --}}
    <div class="prose prose-lg mx-auto mb-12 text-gray-600 leading-relaxed">
        <p class="mb-6">
            Like a page torn from an unwritten book, this path leads nowhere. 
            Perhaps it was a story that was never meant to be told, or maybe 
            it's waiting for the right moment to unfold.
        </p>
        <p class="text-sm text-gray-500 italic">
            "Not all who wander are lost, but some pages simply don't exist."
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
            @auth
                <span class="hidden sm:inline text-gray-300">·</span>
                <a href="{{ route('blogs.create') }}" 
                   class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-300 tracking-wide">
                    Write New Story
                </a>
            @endauth
        </div>
    </div>

    {{-- Decorative separator --}}
    <div class="mt-16 mb-8">
        <div class="w-24 h-px bg-gray-200 mx-auto"></div>
    </div>

    {{-- Footer message --}}
    <div class="text-xs text-gray-400 tracking-wide">
        <p>Error 404 · Page Not Found</p>
    </div>
</div>

{{-- Custom styles for animations --}}
<style>
    @keyframes float {
        0%, 100% {
            transform: translateY(0px) rotate(-5deg);
        }
        50% {
            transform: translateY(-10px) rotate(5deg);
        }
    }

    @keyframes float-alt {
        0%, 100% {
            transform: translateY(-5px) rotate(3deg);
        }
        50% {
            transform: translateY(5px) rotate(-3deg);
        }
    }

    @keyframes fade-float {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
            opacity: 0.3;
        }
        50% {
            transform: translateY(-15px) rotate(10deg);
            opacity: 0.6;
        }
    }

    .floating-page {
        position: absolute;
        width: 60px;
        height: 80px;
        background: linear-gradient(145deg, #f9fafb 0%, #f3f4f6 100%);
        border: 1px solid #e5e7eb;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .floating-page::before {
        content: '';
        position: absolute;
        top: 8px;
        left: 8px;
        right: 8px;
        height: 2px;
        background: #d1d5db;
        border-radius: 1px;
        box-shadow: 0 8px 0 #e5e7eb, 0 16px 0 #e5e7eb, 0 24px 0 #e5e7eb;
    }

    .page-1 {
        top: -40px;
        left: -80px;
        animation: float 4s ease-in-out infinite;
        animation-delay: 0s;
        opacity: 0.7;
    }

    .page-2 {
        top: -20px;
        right: -90px;
        animation: float-alt 5s ease-in-out infinite;
        animation-delay: 1s;
        opacity: 0.5;
    }

    .page-3 {
        bottom: -30px;
        left: -60px;
        animation: fade-float 6s ease-in-out infinite;
        animation-delay: 2s;
        opacity: 0.4;
    }

    @keyframes typewriter {
        from {
            width: 0;
        }
        to {
            width: 100%;
        }
    }

    @keyframes blink-caret {
        from, to {
            border-color: transparent;
        }
        50% {
            border-color: #6b7280;
        }
    }

    .typewriter-container {
        display: inline-block;
    }

    .typewriter {
        overflow: hidden;
        border-right: 2px solid #6b7280;
        white-space: nowrap;
        margin: 0 auto;
        animation: 
            typewriter 3s steps(40, end),
            blink-caret 0.75s step-end infinite;
        animation-delay: 0.5s;
        animation-fill-mode: both;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .floating-page {
            width: 40px;
            height: 60px;
        }
        
        .page-1 {
            left: -60px;
        }
        
        .page-2 {
            right: -70px;
        }
        
        .page-3 {
            left: -40px;
        }
    }

    /* Hover effect for the main 404 */
    h1:hover {
        transform: scale(1.02);
        transition: transform 0.3s ease;
    }

    /* Subtle gradient border utility */
    .gradient-border {
        position: relative;
    }
    
    .gradient-border::before {
        content: '';
        position: absolute;
        inset: 0;
        padding: 1px;
        background: linear-gradient(135deg, #e5e7eb, #9ca3af);
        border-radius: inherit;
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: xor;
        -webkit-mask-composite: xor;
    }

    /* Serif font for headings */
    .serif {
        font-family: 'Crimson Text', Georgia, serif;
    }
</style>
@endsection