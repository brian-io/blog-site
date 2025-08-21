@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">User Profile</h1>

    {{-- User Info --}}
    <div class="bg-white shadow rounded p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">User Details</h2>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
        <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
    </div>

    {{-- Recent Activity --}}
    <div class="bg-white shadow rounded p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
        @if($activities->isEmpty())
            <p class="text-gray-600">No activity recorded.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($activities as $activity)
                    <li class="py-2">
                        <strong>{{ $activity->action }}</strong> — 
                        {{ $activity->description }} <br>
                        <span class="text-gray-500 text-sm">
                            {{ $activity->created_at->diffForHumans() }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- User Comments --}}
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-semibold mb-4">Recent Comments</h2>
        @if($comments->isEmpty())
            <p class="text-gray-600">No comments made.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($comments as $comment)
                    <li class="py-2">
                        <span class="font-medium">{{ $comment->content }}</span>
                        <br>
                        <small class="text-gray-500">
                            Status: {{ ucfirst($comment->status) }} |
                            Blog: <a href="{{ route('blogs.show', $comment->blog) }}" class="text-blue-600 hover:underline">{{ $comment->blog->title }}</a> |
                            {{ $comment->created_at->diffForHumans() }}
                        </small>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
