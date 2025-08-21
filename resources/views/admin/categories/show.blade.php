@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <div class="flex items-center mb-4">
            @if($category->color)
            <div class="w-10 h-10 rounded-full" style="background-color: {{ $category->color }}"></div>
            @endif
            <h1 class="ml-4 text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
        </div>
        
        @if($category->description)
        <p class="text-gray-600 max-w-3xl">
            {{ $category->description }}
        </p>
        @endif
    </div>
    
    <h2 class="text-2xl font-bold text-gray-900 mb-6">
        Posts ({{ $blogs->total() }})
    </h2>
    
    @if($blogs->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-500 text-lg">No posts in this category yet.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-8">
            @foreach($blogs as $blog)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        <a href="{{ route('posts.show', $blog) }}" class="hover:text-blue-600">
                            {{ $blog->title }}
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 mb-4">
                        {{ $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 200) }}
                    </p>
                    
                    <div class="flex items-center text-sm text-gray-500">
                        <span class="mr-4">
                            {{ $blog->published_at->format('M d, Y') }}
                        </span>
                        <span>
                            by {{ $blog->author->name }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $blogs->links() }}
        </div>
    @endif
</div>
@endsection