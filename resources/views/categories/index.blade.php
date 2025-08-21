{{-- resources/views/categories/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-0">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
        <p class="text-gray-600 mt-2">Browse blogs by category</p>
    </div>

    @if($categories->count() > 0)
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" 
                   class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-6 block">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $category->name }}</h3>
                    @if($category->description)
                        <p class="text-gray-600 mb-3">{{ Str::limit($category->description, 100) }}</p>
                    @endif
                    <span class="text-sm text-blue-600">{{ $category->blogs_count ?? 0 }} blogs</span>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-lg font-medium text-gray-900 mb-2">No categories yet</h3>
            <p class="text-gray-600">Categories will appear here once created.</p>
        </div>
    @endif
</div>
@endsection