@extends('layouts.app')

@section('title', 'Blog Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            Blog: {{ $blog->title }}
        </h1>
        <div class="flex space-x-2">
            @if($blog->status === 'published')
                <form method="POST" action="{{ route('admin.blogs.unpublish', $blog) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">
                        Unpublish
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.blogs.publish', $blog) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Publish
                    </button>
                </form>
            @endif

            <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}"
                  onsubmit="return confirm('Are you sure you want to delete this blog?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4">
            <h2 class="text-lg font-medium text-gray-700">Status</h2>
            <span class="inline-block mt-1 px-2 py-1 rounded 
                {{ $blog->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                {{ ucfirst($blog->status) }}
            </span>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-medium text-gray-700">Author</h2>
            <p class="text-gray-600">{{ $blog->author->name ?? 'Unknown' }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-medium text-gray-700">Created At</h2>
            <p class="text-gray-600">{{ $blog->created_at->format('M d, Y H:i') }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-medium text-gray-700">Last Updated</h2>
            <p class="text-gray-600">{{ $blog->updated_at->format('M d, Y H:i') }}</p>
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-medium text-gray-700">Content</h2>
            <div class="prose max-w-none mt-2">
                {!! nl2br(e($blog->content)) !!}
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    @if($blog->comments && $blog->comments->count() > 0)
        <div class="mt-8 bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">
                Comments ({{ $blog->comments->count() }})
            </h2>
            
            <div class="space-y-6">
                @foreach($blog->comments->where('parent_id', null) as $comment)
                    @include('partials.comment', ['comment' => $comment, 'depth' => 0, 'blog' => $blog])
                @endforeach
            </div>
        </div>
    @else
        <div class="mt-8 bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Comments</h2>
            <p class="text-gray-500">No comments yet.</p>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('admin.blogs.index') }}"
           class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            Back to Blogs
        </a>
    </div>
</div>
@endsection