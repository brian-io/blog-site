{{-- resources/views/blogs/show.blade.php --}}
@extends('layouts.app')


@section('content')
<div class="px-4 sm:px-0">
    <!-- Back Navigation -->
    <div class="mb-8">
        <a href="{{ route('blogs.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 font-medium tracking-wide transition-colors duration-300 group">
            <svg class="w-4 h-4 mr-2 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Writing
        </a>
    </div>

    <article class="max-w-4xl mx-auto">
        <!-- Article Header -->
        <header class="mb-12">
            <!-- Meta Information -->
            <div class="flex items-center justify-between text-sm text-gray-500 mb-6">
                <time datetime="{{ $blog->created_at->toISOString() }}" class="tracking-wide">
                    {{ $blog->created_at->format('M j, Y') }}
                </time>
                
            </div>

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl font-light text-gray-900 serif tracking-wide leading-tight mb-8">
                {{ $blog->title }}
            </h1>

            <!-- Author & Reading Info -->
            <div class="flex items-center justify-between pb-8 border-b border-gray-200">
                @if($blog->author)
                    <div class="flex items-center">
                        @if($blog->author->avatar)
                            <img src="{{ asset('storage/' . $blog->author->avatar) }}" 
                                 alt="{{ $blog->author->name }}" 
                                 class="w-12 h-12 rounded-full mr-4">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-full mr-4 flex items-center justify-center font-medium text-gray-700">
                                {{ substr($blog->author->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-medium text-gray-900 tracking-wide">{{ $blog->author->name }}</p>
                            @if($blog->read_time)
                                <p class="text-sm text-gray-500">{{ $blog->read_time }} min read</p>
                            @endif
                        </div>
                    </div>
                @endif
                @if($blog->categories->first())
                    <a href="{{ route('categories.show', $blog->categories->first()->slug) }}" 
                       class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-300">
                        {{ $blog->categories->first()->name }}
                    </a>
                @endif

               
            </div>
        </header>

        <!-- Featured Image -->
        @if($blog->featured_image)
            <div class="mb-12 overflow-hidden rounded-lg">
                <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                     alt="{{ $blog->title }}" 
                     class="w-full aspect-video object-cover">
            </div>
        @endif

        <!-- Article Content -->
        <div class="prose prose-lg prose-gray max-w-none mb-12">
            <style>
                .prose {
                    font-size: 1.125rem;
                    line-height: 1.75;
                    color: #374151;
                }
                .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
                    font-family: 'Crimson Pro', serif;
                    font-weight: 300;
                    letter-spacing: 0.025em;
                    color: #111827;
                }
                .prose h2 {
                    font-size: 1.875rem;
                    margin-top: 2.5rem;
                    margin-bottom: 1rem;
                }
                .prose h3 {
                    font-size: 1.5rem;
                    margin-top: 2rem;
                    margin-bottom: 0.75rem;
                }
                .prose p {
                    margin-bottom: 1.5rem;
                }
                .prose a {
                    color: #374151;
                    text-decoration: underline;
                    text-decoration-color: #d1d5db;
                    transition: all 0.3s ease;
                }
                .prose a:hover {
                    text-decoration-color: #374151;
                }
                .prose blockquote {
                    border-left: 4px solid #e5e7eb;
                    padding-left: 1.5rem;
                    margin: 2rem 0;
                    font-style: italic;
                    color: #6b7280;
                }
                .prose code {
                    background: #f3f4f6;
                    padding: 0.25rem 0.5rem;
                    border-radius: 0.375rem;
                    font-size: 0.875rem;
                }
                .prose pre {
                    background: #f9fafb;
                    border: 1px solid #e5e7eb;
                    border-radius: 0.5rem;
                    padding: 1.5rem;
                    overflow-x: auto;
                    margin: 2rem 0;
                }
            </style>
            {!! $blog->content !!}
        </div>

        @if($blog->tags->count() > 0)
            <div class="flex flex-wrap gap-2 mb-12">
                @foreach($blog->tags as $tag)
                    <a href="{{ route('tags.show', $tag->slug) }}" 
                        class="text-xs bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-900 px-3 py-1 rounded-full transition-colors duration-300">
                        # {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Article Actions -->
        @auth
            @if(auth()->user()->can('update', $blog) || auth()->user()->can('delete', $blog))
                <div class="border-t border-gray-200 pt-8 mb-12">
                    <div class="flex items-center space-x-6">
                        @can('update', $blog)
                            <a href="{{ route('blogs.edit', $blog) }}" 
                               class="text-gray-600 hover:text-gray-900 font-medium tracking-wide transition-colors duration-300">
                                Edit Story
                            </a>
                        @endcan
                        @can('delete', $blog)
                            <form action="{{ route('blogs.destroy', $blog) }}" 
                                  method="POST" 
                                  class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this story?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 font-medium tracking-wide transition-colors duration-300">
                                    Delete Story
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            @endif
        @endauth

        
    </article>

     

    <!-- Comments Section -->
    <div class="max-w-4xl mx-auto mt-16 pt-16 border-t border-gray-200">
        <div class="mb-12">
            <h2 class="text-2xl font-light text-gray-900 serif tracking-wide mb-2">
                Comments {{ $comments->count() }}
            </h2>
            <p class="text-gray-600">Share your thoughts on this story</p>
        </div>
        
        <!-- Comment Form -->
        <form action="{{ route('comments.store', $blog) }}" method="POST" class="mb-16 p-8 bg-gray-50/50 rounded-lg border border-gray-100">
            @csrf
            <div class="space-y-6">
                @auth
                    <!-- Hidden fields for authenticated users -->
                    <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                @endauth
                @guest
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="user_name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <input type="text" 
                                   id="user_name"
                                   name="user_name" 
                                   required 
                                   class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-300">
                        </div>
                        <div>
                            <label for="user_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" 
                                   id="user_email"
                                   name="user_email" 
                                   required 
                                   class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-300">
                        </div>
                    </div>
                @endguest
                
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Your Response</label>
                    <textarea name="content" 
                              id="content"
                              rows="5" 
                              required 
                              placeholder="What are your thoughts on this story?"
                              class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-300 resize-none">
                            </textarea>
                </div>
                
                <button type="submit" 
                        class="bg-gray-900 text-white px-8 py-3 rounded-lg hover:bg-gray-800 hover:shadow-lg hover:shadow-gray-300 transform hover:-translate-y-0.15 transition duration-300 font-medium tracking-wide">
                    Post Comment
                </button>
            </div>
        </form>

        <!-- Comments List -->
        @if($comments->count() > 0)
            <div class="space-y-8">
                @foreach($comments as $comment)
                    @include('partials.comment', ['comment' => $comment, 'depth' => 0])
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-light text-gray-900 serif tracking-wide mb-2">No responses yet</h3>
                <p class="text-gray-600">Be the first to share your thoughts on this story.</p>
            </div>
        @endif
    </div>
</div>
@endsection