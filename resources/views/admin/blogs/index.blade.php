@extends('layouts.admin')

@section('title', 'Manage Blogs')

@section('content')
<div class="container mx-auto px-6 py-6">
    

    {{-- Success / Error alerts --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Table of Blogs --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($blogs as $blog)
                    <tr>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.blogs.show', $blog) }}" 
                               class="text-blue-600 hover:underline font-medium">
                                {{ $blog->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4">{{ $blog->author->name ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if($blog->status === 'published')
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">Published</span>
                            @elseif($blog->status === 'draft')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">Draft</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $blog->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                {{-- <a href="{{ route('admin.blogs.edit', $blog) }}" 
                                   class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                    Edit
                                </a> --}}

                                {{-- Publish / Unpublish toggle --}}
                                @if($blog->status === 'published')
                                    <form action="{{ route('admin.blogs.unpublish', $blog) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                            class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm">
                                            Unpublish
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.blogs.publish', $blog) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                            Publish
                                        </button>
                                    </form>
                                @endif

                                {{-- Delete --}}
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No blogs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $blogs->links() }}
    </div>
</div>
@endsection
