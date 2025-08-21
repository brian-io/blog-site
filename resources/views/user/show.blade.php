@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 flex items-center">
            @if($user->avatar)
            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover">
            @else
            <div class="bg-gray-200 border-2 border-dashed rounded-full w-24 h-24"></div>
            @endif
            
            <div class="ml-6">
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                
                @if($user->bio)
                <p class="text-gray-600 mt-2">
                    {{ $user->bio }}
                </p>
                @endif
                
                @if($user->website)
                <a href="{{ $user->website }}" target="_blank" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                    {{ parse_url($user->website, PHP_URL_HOST) }}
                </a>
                @endif
            </div>
        </div>
    </div>
    
    <h2 class="text-2xl font-bold text-gray-900 mt-12 mb-6">Latest Posts</h2>
    
    @if($blogs->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-500 text-lg">No posts yet.</p>
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
                    
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach($blog->categories as $category)
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                            {{ $category->name }}
                        </span>
                        @endforeach
                    </div>
                    
                    <div class="text-sm text-gray-500">
                        {{ $blog->published_at->format('M d, Y') }} • {{ $blog->views_count }} views
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