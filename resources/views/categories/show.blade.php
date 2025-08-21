{{-- resources/views/categories/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-0">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
        @if($category->description)
            <p class="text-gray-600 mt-2">{{ $category->description }}</p>
        @endif
        <p class="text-sm text-gray-500 mt-2">{{ $blogs->total() }} blogs in this category</p>
    </div>

    @if($blogs->count() > 0)
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($blogs as $blog)
                <article class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    @if($blog->featured_image)
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="hover:text-blue-600">
                                {{ $blog->title }}
                            </a>
                        </h2>
                        <p class="text-gray-600 mb-4">{{ Str::limit($blog->excerpt, 120) }}</p>
                        <div class="text-sm text-gray-500">
                            {{ $blog->created_at->format('M j, Y') }}
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $blogs->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-lg font-medium text-gray-900 mb-2">No blogs in this category</h3>
            <p class="text-gray-600">Posts will appear here once added to this category.</p>
        </div>
    @endif
</div>
@endsection