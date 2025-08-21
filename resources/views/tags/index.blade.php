{{-- resources/views/tags/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-0">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Tags</h1>
        <p class="text-gray-600 mt-2">Browse blogs by tags</p>
    </div>

    @if($tags->count() > 0)
        <div class="flex flex-wrap gap-3">
            @foreach($tags as $tag)
                <a href="{{ route('tags.show', $tag->slug) }}" 
                   class="bg-white border border-gray-200 rounded-full px-4 py-2 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                    <span class="text-gray-700">{{ $tag->name }}</span>
                    <span class="text-sm text-gray-500 ml-2">({{ $tag->blogs_count ?? 0 }})</span>
                </a>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $tags->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-lg font-medium text-gray-900 mb-2">No tags yet</h3>
            <p class="text-gray-600">Tags will appear here once created.</p>
        </div>
    @endif
</div>
@endsection