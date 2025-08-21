{{-- resources/views/admin/comments/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-0">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-12">
        <div>
            <h1 class="text-3xl font-light text-gray-900 serif tracking-wide mb-2">Comment Moderation</h1>
            <p class="text-gray-600">Review and manage user responses</p>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex space-x-1 mb-8 bg-gray-100 rounded-lg p-1">
        <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" 
           class="flex-1 text-center py-2 px-4 rounded-md font-medium text-sm transition-all duration-200 {{ request('status', 'pending') === 'pending' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
            Pending ({{ $pendingCount }})
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}" 
           class="flex-1 text-center py-2 px-4 rounded-md font-medium text-sm transition-all duration-200 {{ request('status') === 'approved' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
            Approved
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'rejected']) }}" 
           class="flex-1 text-center py-2 px-4 rounded-md font-medium text-sm transition-all duration-200 {{ request('status') === 'rejected' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
            Rejected
        </a>
        <a href="{{ route('admin.comments.index') }}" 
           class="flex-1 text-center py-2 px-4 rounded-md font-medium text-sm transition-all duration-200 {{ !request('status') ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
            All
        </a>
    </div>

    @if($comments->count() > 0)
        {{-- Comments List --}}
        <div class="space-y-6">
            @foreach($comments as $comment)
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    {{-- Comment Header --}}
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                {{-- Status Badge --}}
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    {{ $comment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $comment->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $comment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($comment->status) }}
                                </span>
                                
                                {{-- Author Info --}}
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-300 rounded-full mr-3 flex items-center justify-center text-sm font-medium text-gray-700">
                                        {{ substr($comment->getAuthorDisplayName(), 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            {{ $comment->getAuthorDisplayName() }}
                                            @if($comment->user)
                                                <span class="text-xs text-green-600 ml-1">(Registered User)</span>
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $comment->getAuthorDisplayName() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="text-sm text-gray-500">
                                <time datetime="{{ $comment->created_at->toISOString() }}">
                                    {{ $comment->created_at->format('M j, Y \a\t g:i A') }}
                                </time>
                            </div>
                        </div>
                    </div>

                    {{-- Comment Content --}}
                    <div class="px-6 py-4">
                        {{-- Blog Reference --}}
                        <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                            <p class="text-sm text-blue-800">
                                <span class="font-medium">On:</span> 
                                <a href="{{ route('blogs.show', $comment->blog->slug) }}" 
                                   class="hover:underline">{{ $comment->blog->title }}</a>
                            </p>
                        </div>

                        {{-- Comment Text --}}
                        <div class="prose prose-sm max-w-none mb-6">
                            <p class="text-gray-700 leading-relaxed">{{ $comment->content }}</p>
                        </div>

                        {{-- Meta Info --}}
                        <div class="text-xs text-gray-500 mb-4 space-y-1">
                            <p><span class="font-medium">IP:</span> {{ $comment->ip_address }}</p>
                            <p><span class="font-medium">User Agent:</span> {{ Str::limit($comment->user_agent, 80) }}</p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center space-x-4 pt-4 border-t border-gray-100">
                            @if($comment->status === 'pending')
                                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white font-medium rounded-lg hover:bg-yellow-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Reject
                                    </button>
                                </form>
                            @endif

                            @if($comment->status === 'approved')
                                <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white font-medium rounded-lg hover:bg-yellow-700 transition-colors duration-200">
                                        Reject
                                    </button>
                                </form>
                            @endif

                            @if($comment->status === 'rejected')
                                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                        Approve
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to permanently delete this comment?')"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </form>

                            <a href="{{ route('blogs.show', $comment->blog->slug) }}#comment-{{ $comment->id }}" 
                               class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-200">
                                View on Blog →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($comments->hasPages())
            <div class="mt-12">
                {{ $comments->withQueryString()->links() }}
            </div>
        @endif

    @else
        {{-- Empty State --}}
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-light text-gray-900 serif tracking-wide mb-2">
                No {{ request('status', 'pending') }} comments
            </h3>
            <p class="text-gray-600">
                @if(request('status') === 'pending')
                    All caught up! No comments awaiting moderation.
                @else
                    No comments found with this status.
                @endif
            </p>
        </div>
    @endif
</div>
@endsection