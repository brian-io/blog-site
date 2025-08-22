{{-- resources/views/partials/comment.blade.php --}}
@php
    $maxDepth = 5; // Maximum nesting level
    $indentClass = $depth > 0 ? 'ml-' . min($depth * 8, 40) : '';
@endphp

<div class="comment-item {{ $indentClass }}" data-comment-id="{{ $comment->id }}">
    <div class="flex space-x-4">
        <!-- Avatar -->
        <div class="flex-shrink-0">
            @if($comment->user && $comment->user->avatar)
                <img src="{{ asset('storage/' . $comment->user->avatar) }}" 
                     alt="{{ $comment->user->name }}" 
                     class="w-10 h-10 rounded-full">
            @elseif($comment->user)
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-medium text-gray-700 text-sm">
                    {{ substr($comment->user->name, 0, 1) }}
                </div>
            @else
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-medium text-gray-700 text-sm">
                    {{ substr($comment->user_name ?? 'A', 0, 1) }}
                </div>
            @endif
        </div>

        <!-- Comment Content -->
        <div class="flex-1 min-w-0">
            <!-- Comment Header -->
            <div class="flex items-center space-x-2 mb-2">
                <h4 class="font-medium text-gray-900 text-sm">
                    {{ $comment->user->name ?? $comment->user_name ?? 'Anonymous' }}
                </h4>
                <span class="text-gray-400">·</span>
                <time class="text-sm text-gray-500" datetime="{{ $comment->created_at->toISOString() }}">
                    {{ $comment->created_at->diffForHumans() }}
                </time>
                @if($comment->updated_at != $comment->created_at)
                    <span class="text-gray-400">·</span>
                    <span class="text-sm text-gray-500">edited</span>
                @endif
            </div>

            <!-- Comment Text -->
            <div class="prose prose-sm max-w-none text-gray-700 mb-3">
                {!! nl2br(e($comment->content)) !!}
            </div>

            <!-- Comment Actions -->
            <div class="flex items-center space-x-6">
                <!-- Voting -->
                <div class="comment-votes flex items-center space-x-2">
                    @auth
                        {{-- Upvote --}}
                        <button class="vote-btn upvote-btn upvote {{ auth()->user()->hasVoted($comment, 1) ? 'active' : '' }}" 
                                data-comment-id="{{ $comment->id }}" 
                                data-vote="1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5 5 5M7 19l5-5 5 5"></path>
                            </svg>
                        </button>

                        {{-- the number of votes --}}
                        <span class="vote-score text-sm font-medium text-gray-600">{{ $comment->vote_score }}</span>

                        {{-- Downvote --}}
                        <button class="vote-btn downvote-btn downvote {{ auth()->user()->hasVoted($comment, -1) ? 'active' : '' }}" 
                                data-comment-id="{{ $comment->id }}" 
                                data-vote="-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5-5-5M17 5l-5 5-5-5"></path>
                            </svg>
                        </button>
                    @else
                        <div class="flex items-center space-x-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5 5 5M7 19l5-5 5 5"></path>
                            </svg>
                            <span class="vote-score text-sm">{{ $comment->vote_score ?? 0 }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5-5-5M17 5l-5 5-5-5"></path>
                            </svg>
                        </div>
                    @endauth
                </div>

                <!-- Reply Button -->
                @if($depth < $maxDepth)
                    <button class="reply-btn text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200" 
                            data-comment-id="{{ $comment->id }}">
                        Reply
                    </button>
                @endif

                <!-- Edit/Delete for comment owner -->
                @auth
                    @if(auth()->user()->can('update', $comment))
                        <button class="edit-comment-btn text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200" 
                                data-comment-id="{{ $comment->id }}">
                            Edit
                        </button>
                    @endif
                    @if(auth()->user()->can('delete', $comment))
                        <form action="{{ route('comments.destroy', $comment) }}" 
                              method="POST" 
                              class="inline" 
                              onsubmit="return confirm('Are you sure you want to delete this comment?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-sm text-red-500 hover:text-red-700 transition-colors duration-200">
                                Delete
                            </button>
                        </form>
                    @endif
                @endauth
            </div>

            <!-- Reply Form (Initially Hidden) -->
            @if($depth < $maxDepth)
                <div id="reply-form-{{ $comment->id }}" class="mt-6 hidden">
                    <form action="{{ route('comments.store', ['blog' => $blog ?? $comment->blog]) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        
                        @guest
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="reply_user_name_{{ $comment->id }}" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                    <input type="text" 
                                           id="reply_user_name_{{ $comment->id }}"
                                           name="user_name" 
                                           required 
                                           value="{{ old('user_name') }}"
                                           class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-300 text-sm">
                                </div>
                                <div>
                                    <label for="reply_user_email_{{ $comment->id }}" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" 
                                           id="reply_user_email_{{ $comment->id }}"
                                           name="user_email" 
                                           required 
                                           value="{{ old('user_email') }}"
                                           class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-300 text-sm">
                                </div>
                            </div>
                        @endguest
                        
                        <div>
                            <label for="reply_content_{{ $comment->id }}" class="block text-sm font-medium text-gray-700 mb-1">Reply</label>
                            <textarea name="content" 
                                      id="reply_content_{{ $comment->id }}"
                                      rows="3" 
                                      required 
                                      placeholder="Write your reply..."
                                      class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-300 resize-none text-sm"></textarea>
                        </div>
                        
                        <div class="flex space-x-3">
                            <button type="submit" 
                                    class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors duration-300 text-sm font-medium">
                                Post Reply
                            </button>
                            <button type="button" 
                                    class="cancel-reply-btn text-gray-600 hover:text-gray-800 px-4 py-2 transition-colors duration-300 text-sm"
                                    data-comment-id="{{ $comment->id }}">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Edit Form (Initially Hidden) -->
            @auth
                @if(auth()->user()->can('update', $comment))
                    <div id="edit-form-{{ $comment->id }}" class="mt-6 hidden">
                        <form action="{{ route('comments.update', $comment) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <label for="edit_content_{{ $comment->id }}" class="block text-sm font-medium text-gray-700 mb-1">Edit Comment</label>
                                <textarea name="content" 
                                          id="edit_content_{{ $comment->id }}"
                                          rows="4" 
                                          required 
                                          class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-300 resize-none text-sm">{{ $comment->content }}</textarea>
                            </div>
                            
                            <div class="flex space-x-3">
                                <button type="submit" 
                                        class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors duration-300 text-sm font-medium">
                                    Update Comment
                                </button>
                                <button type="button" 
                                        class="cancel-edit-btn text-gray-600 hover:text-gray-800 px-4 py-2 transition-colors duration-300 text-sm"
                                        data-comment-id="{{ $comment->id }}">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            @endauth

            <!-- Nested Comments -->
            @if($comment->replies && $comment->replies->count() > 0 && $depth < $maxDepth)
                <div class="mt-8 space-y-6">
                    @foreach($comment->replies as $reply)
                        @include('partials.comment', ['comment' => $reply, 'depth' => $depth + 1, 'blog' => $blog])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Only add scripts and styles on the first comment (depth 0) to avoid duplication --}}
@if($depth === 0)
    @push('styles')

    <style>
    .vote-btn {
        @apply text-gray-400 hover:text-gray-600 transition-colors duration-200;
       
    }
    .vote-btn.active {
        @apply text-blue-600 hover:text-blue-700;
    }
    .vote-btn.upvote.active {
        @apply text-green-600 hover:text-green-700;
    }
    .vote-btn.downvote.active {
        @apply text-red-600 hover:text-red-700;
    }
    </style>
    @endpush

    @push('scripts')

    <script>
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log("Comment scripts loaded successfully!");
        console.log("CSRF Token found:", document.querySelector('meta[name="csrf-token"]') ? 'YES' : 'NO');
        console.log("Vote buttons found:", document.querySelectorAll('.vote-btn').length);
        
        // Test click handler
        document.addEventListener('click', function(e) {
            console.log("Click detected on:", e.target);
            
            // Handle voting
            if (e.target.closest('button.vote-btn')) {
                console.log("Vote button clicked!");
                e.preventDefault();
                
                const button = e.target.closest('.vote-btn');
                const commentId = button.dataset.commentId;
                const voteType = button.dataset.vote;
                
                console.log("Comment ID:", commentId, "Vote type:", voteType);
                
                @auth
                    console.log("User is authenticated, making fetch request...");
                    fetch(`/comments/${commentId}/vote`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ vote: voteType })
                    })
                    .then(response => {
                        console.log("Response status:", response.status);
                        if (response.status === 401) {
                            window.location.href = '/login';
                            return Promise.reject('Authentication required');
                        }
                        if (response.status === 403) {
                            alert('You do not have permission to vote.');
                            return Promise.reject('Permission denied');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Response data:", data);
                        if (data.success) {
                            const scoreElement = button.closest('.comment-votes').querySelector('.vote-score');
                            const upvoteBtn = button.closest('.comment-votes').querySelector('.upvote-btn');
                            const downvoteBtn = button.closest('.comment-votes').querySelector('.downvote-btn');
                            
                            scoreElement.textContent = data.vote_score;
                            upvoteBtn.classList.toggle('active', data.user_vote == 1);
                            downvoteBtn.classList.toggle('active', data.user_vote == -1);
                        }
                    })
                    .catch(error => {
                        console.error('Voting Error:', error);
                    });
                @else
                    console.log("User not authenticated");
                    alert('Please log in to vote on comments.');
                @endauth

                return;
            }
            
            // Handle reply button
            if (e.target.closest('.reply-btn')) {
                console.log("Reply button clicked!");
                e.preventDefault();
                
                const commentId = e.target.dataset.commentId;
                const replyForm = document.getElementById(`reply-form-${commentId}`);
                const replyBtn = e.target;
                
                hideAllForms();
                resetAllButtons();
                
                if (replyForm.classList.contains('hidden')) {
                    replyForm.classList.remove('hidden');
                    replyBtn.textContent = 'Cancel Reply';
                    replyForm.querySelector('textarea')?.focus();
                } else {
                    replyForm.classList.add('hidden');
                    replyBtn.textContent = 'Reply';
                }
                return;
            }
            
            // Handle edit button
            if (e.target.closest('.edit-comment-btn')) {
                console.log("Edit button clicked!");
                e.preventDefault();
                
                const commentId = e.target.dataset.commentId;
                const editForm = document.getElementById(`edit-form-${commentId}`);
                const editBtn = e.target;
                
                hideAllForms();
                resetAllButtons();
                
                if (editForm.classList.contains('hidden')) {
                    editForm.classList.remove('hidden');
                    editBtn.textContent = 'Cancel Edit';
                    editForm.querySelector('textarea')?.focus();
                } else {
                    editForm.classList.add('hidden');
                    editBtn.textContent = 'Edit';
                }
                return;
            }
            
            // Handle cancel buttons
            if (e.target.closest('.cancel-reply-btn')) {
                const commentId = e.target.dataset.commentId;
                const replyForm = document.getElementById(`reply-form-${commentId}`);
                const replyBtn = document.querySelector(`.reply-btn[data-comment-id="${commentId}"]`);
                
                replyForm.classList.add('hidden');
                if (replyBtn) replyBtn.textContent = 'Reply';
                return;
            }
            
            if (e.target.closest('.cancel-edit-btn')) {
                const commentId = e.target.dataset.commentId;
                const editForm = document.getElementById(`edit-form-${commentId}`);
                const editBtn = document.querySelector(`.edit-comment-btn[data-comment-id="${commentId}"]`);
                
                editForm.classList.add('hidden');
                if (editBtn) editBtn.textContent = 'Edit';
                return;
            }
        });
        
        function hideAllForms() {
            document.querySelectorAll('[id^="reply-form-"], [id^="edit-form-"]').forEach(form => {
                form.classList.add('hidden');
            });
        }
        
        function resetAllButtons() {
            document.querySelectorAll('.reply-btn').forEach(btn => {
                btn.textContent = 'Reply';
            });
            document.querySelectorAll('.edit-comment-btn').forEach(btn => {
                btn.textContent = 'Edit';
            });
        }
    });
    </script>
    @endpush
@endif