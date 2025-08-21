@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-0">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-12">
        <div>
            <h1 class="text-3xl font-light text-gray-900 serif tracking-wide mb-2">Writing</h1>
            <p class="text-gray-600">Thoughts, stories, and insights</p>
        </div>
        @auth
            <a href="{{ route('blogs.create') }}" 
               class="mt-6 sm:mt-0 relative gradient-border bg-white text-gray-800 px-6 py-2 rounded-full text-sm font-medium hover:shadow-md transition-all duration-300">
                New Story
            </a>
        @endauth
    </div>

    @if($blogs->count() > 0)
        {{-- Blog Posts Stack --}}
        <div class="space-y-12">
            @foreach($blogs as $blog)
                <article class="group">
                    {{-- Meta Information --}}
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <time datetime="{{ $blog->created_at->toISOString() }}" class="tracking-wide">
                            {{ $blog->created_at->format('M j, Y') }}
                        </time>
                        @if($blog->category)
                            <a href="{{ route('categories.show', $blog->category->slug) }}" 
                               class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-300">
                                {{ $blog->category->name }}
                            </a>
                        @endif
                    </div>

                    {{-- Featured Image --}}
                    @if($blog->featured_image)
                        <div class="mb-6 overflow-hidden rounded-lg">
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                 alt="{{ $blog->title }}" 
                                 class="w-full aspect-video object-cover group-hover:scale-[1.02] transition-transform duration-700 ease-out"
                                 loading="lazy">
                        </div>
                    @endif

                    {{-- Title --}}
                    <h2 class="text-2xl sm:text-3xl font-light text-gray-900 serif tracking-wide mb-4">
                        <a href="{{ route('blogs.show', $blog->slug) }}" 
                           class="hover:text-gray-700 transition-colors duration-300">
                            {{ $blog->title }}
                        </a>
                    </h2>

                    {{-- Excerpt --}}
                    <p class="text-gray-600 leading-relaxed text-lg mb-6 max-w-3xl">
                        {{ $blog->excerpt ? Str::limit($blog->excerpt, 200) : Str::limit(strip_tags($blog->content), 200) }}
                    </p>

                    {{-- Author & Read More --}}
                    <div class="flex items-center justify-between pt-4">
                        @if($blog->author)
                            <div class="flex items-center text-sm text-gray-600">
                                @if($blog->author->avatar)
                                    <img src="{{ asset('storage/' . $blog->author->avatar) }}" 
                                         alt="{{ $blog->author->name }}" 
                                         class="w-8 h-8 rounded-full mr-3">
                                @else
                                    <div class="w-8 h-8 bg-gray-200 rounded-full mr-3 flex items-center justify-center text-xs font-medium text-gray-700">
                                        {{ substr($blog->author->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="font-medium tracking-wide">{{ $blog->author->name }}</span>
                                @if($blog->read_time)
                                    <span class="mx-3 text-gray-400">·</span>
                                    <span class="text-gray-500">{{ $blog->read_time }} min read</span>
                                @endif
                            </div>
                        @endif
                        
                        <a href="{{ route('blogs.show', $blog->slug) }}" 
                           class="text-gray-600 hover:text-gray-900 font-medium text-sm tracking-wide transition-colors duration-300 group">
                            Read story
                            <span class="inline-block transition-transform duration-300 group-hover:translate-x-1 ml-1">→</span>
                        </a>
                    </div>

                    {{-- Separator --}}
                    @if(!$loop->last)
                        <div class="w-16 h-px bg-gray-200 mt-12"></div>
                    @endif
                </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($blogs->hasPages())
            <div class="mt-16 ">
                    {{ $blogs->links() }}
            </div>
        @endif

    @else
        {{-- Empty State --}}
        <div class="text-center py-24">
            <div class="mb-6">
                <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" 
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-light text-gray-900 serif tracking-wide mb-3">No stories yet</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                This space is waiting for the first story to be shared.
            </p>
            @auth
                <a href="{{ route('blogs.create') }}" 
                   class="relative gradient-border bg-white text-gray-800 px-6 py-3 rounded-full font-medium hover:shadow-md transition-all duration-300">
                    Write the first story
                </a>
            @else
                <p class="text-gray-500 tracking-wide">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 font-medium transition-colors duration-300">Sign in</a> 
                    to start writing
                </p>
            @endif
        </div>
    @endif
</div>
@endsection