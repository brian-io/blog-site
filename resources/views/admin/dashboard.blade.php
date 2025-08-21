@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-0">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-12">
        <div>
            <h1 class="text-3xl font-light text-gray-900 serif tracking-wide mb-2">Dashboard</h1>
            <p class="text-gray-600">Overview of your content management system</p>
        </div>
        <div class="mt-6 sm:mt-0 text-sm text-gray-500 tracking-wide">
            Last updated: {{ now()->format('M j, Y \a\t g:i A') }}
        </div>
    </div>

    {{-- Quick Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="group">
            <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600 tracking-wide">TOTAL POSTS</h3>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-light text-gray-900 serif mb-1">{{ $totalBlogs ?? 0 }}</p>
                <p class="text-sm text-gray-500">
                    <span class="text-green-600">+{{ $blogsThisMonth ?? 0 }}</span> this month
                </p>
            </div>
        </div>

        <div class="group">
            <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600 tracking-wide">ACTIVE USERS</h3>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-light text-gray-900 serif mb-1">{{ $activeUsers ?? 0 }}</p>
                <p class="text-sm text-gray-500">
                    <span class="text-blue-600">{{ $totalUsers ?? 0 }}</span> total users
                </p>
            </div>
        </div>

        <div class="group">
            <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600 tracking-wide">COMMENTS</h3>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.681L3 21l2.975-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-light text-gray-900 serif mb-1">{{ $totalComments ?? 0 }}</p>
                <p class="text-sm text-gray-500">
                    <span class="text-yellow-600">{{ $pendingComments ?? 0 }}</span> pending approval
                </p>
            </div>
        </div>

        <div class="group">
            <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600 tracking-wide">CATEGORIES</h3>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-light text-gray-900 serif mb-1">{{ $totalCategories ?? 0 }}</p>
                <p class="text-sm text-gray-500">
                    <span class="text-purple-600">{{ $totalTags ?? 0 }}</span> tags
                </p>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        {{-- Posts Over Time Chart --}}
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-light text-gray-900 serif tracking-wide">Content Growth</h3>
                <select class="text-sm border border-gray-200 rounded px-3 py-1 text-gray-600 focus:outline-none focus:border-gray-400">
                    <option>Last 6 months</option>
                    <option>Last year</option>
                    <option>All time</option>
                </select>
            </div>
            <div class="h-64 flex items-end justify-between space-x-2">
                {{-- Simple bar chart representation --}}
                @php
                    $chartData = $monthlyPosts ?? [3, 7, 5, 12, 8, 15]; // Sample data
                    $maxValue = max($chartData);
                @endphp
                @foreach($chartData as $month => $count)
                    <div class="flex flex-col items-center flex-1">
                        <div class="bg-gray-100 hover:bg-gray-200 transition-colors duration-300 w-full rounded-t" 
                             style="height: {{ ($count / $maxValue) * 200 }}px"></div>
                        <span class="text-xs text-gray-500 mt-2">
                            {{ date('M', strtotime('-' . (5 - $month) . ' months')) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Popular Categories --}}
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-light text-gray-900 serif tracking-wide mb-6">Popular Categories</h3>
            <div class="space-y-4">
                @php
                    $popularCategories = $popularCategories ?? [
                        ['name' => 'Technology', 'count' => 23, 'percentage' => 85],
                        ['name' => 'Design', 'count' => 18, 'percentage' => 65],
                        ['name' => 'Lifestyle', 'count' => 12, 'percentage' => 45],
                        ['name' => 'Business', 'count' => 8, 'percentage' => 30],
                    ];
                @endphp
                @foreach($popularCategories as $category)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700 tracking-wide">{{ $category['name'] }}</span>
                            <span class="text-sm text-gray-500">{{ $category['count'] }} posts</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-gray-300 h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ $category['percentage'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Recent Activity & Quick Actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Recent Posts --}}
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-light text-gray-900 serif tracking-wide">Recent Posts</h3>
                <a href="{{ route('admin.blogs.index') }}" 
                   class="text-gray-600 hover:text-gray-900 font-medium text-sm tracking-wide transition-colors duration-300 group">
                    View all
                    <span class="inline-block transition-transform duration-300 group-hover:translate-x-1 ml-1">→</span>
                </a>
            </div>
            
            <div class="space-y-6">
                @forelse($recentBlogs ?? [] as $blog)
                    <article class="group border-b border-gray-100 last:border-0 pb-6 last:pb-0">
                        <div class="flex items-start space-x-4">
                            @if($blog->featured_image ?? false)
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                     alt="{{ $blog->title }}" 
                                     class="w-16 h-16 rounded object-cover flex-shrink-0">
                            @else
                                <div class="w-16 h-16 bg-gray-100 rounded flex-shrink-0 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-900 group-hover:text-gray-600 transition-colors duration-300 mb-1">
                                    <a href="{{ route('admin.blogs.show', $blog->id ?? 1) }}">
                                        {{ $blog->title ?? 'Sample Blog Post Title' }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-600 mb-2">
                                    {{ Str::limit($blog->excerpt ?? 'This is a sample excerpt for demonstration purposes.', 100) }}
                                </p>
                                <div class="flex items-center text-xs text-gray-500 space-x-4">
                                    <span>{{ $blog->author->name ?? 'John Doe' }}</span>
                                    <span>•</span>
                                    <time>{{ $blog->created_at->format('M j, Y') ?? 'Jan 15, 2024' }}</time>
                                    @if($blog->status ?? 'published' === 'draft')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700">
                                            Draft
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    {{-- Sample posts for demonstration --}}
                    @for($i = 1; $i <= 3; $i++)
                        <article class="group border-b border-gray-100 last:border-0 pb-6 last:pb-0">
                            <div class="flex items-start space-x-4">
                                <div class="w-16 h-16 bg-gray-100 rounded flex-shrink-0 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900 group-hover:text-gray-600 transition-colors duration-300 mb-1">
                                        <a href="{{ route('admin.blogs.show', 1) }}">
                                            Sample Blog Post Title {{ $i }}
                                        </a>
                                    </h4>
                                    <p class="text-sm text-gray-600 mb-2">
                                        This is a sample excerpt for demonstration purposes. It shows how recent posts would appear in the dashboard.
                                    </p>
                                    <div class="flex items-center text-xs text-gray-500 space-x-4">
                                        <span>John Doe</span>
                                        <span>•</span>
                                        <time>{{ now()->subDays($i)->format('M j, Y') }}</time>
                                        @if($i === 3)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700">
                                                Draft
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endfor
                @endforelse
            </div>
        </div>

        {{-- Quick Actions --}}
        <div>
            <h3 class="text-lg font-light text-gray-900 serif tracking-wide mb-6">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.blogs.create') }}" 
                   class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-lg hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors duration-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700 tracking-wide">New Post</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-lg hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors duration-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700 tracking-wide">Manage Users</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('admin.comments.index') }}" 
                   class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-lg hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors duration-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.681L3 21l2.975-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700 tracking-wide">Review Comments</span>
                        @if(($pendingComments ?? 0) > 0)
                            <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                {{ $pendingComments }}
                            </span>
                        @endif
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-lg hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors duration-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700 tracking-wide">Categories & Tags</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            {{-- System Status --}}
            <div class="mt-8 pt-6 border-t border-gray-100">
                <h4 class="text-sm font-medium text-gray-600 tracking-wide mb-4">SYSTEM STATUS</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Storage Used</span>
                        <span class="font-medium text-gray-900">{{ $storageUsed ?? '2.4 GB' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Database Size</span>
                        <span class="font-medium text-gray-900">{{ $databaseSize ?? '15.2 MB' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Cache Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">
                            Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection