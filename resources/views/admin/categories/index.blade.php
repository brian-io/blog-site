@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Dashboard</h1>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Posts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_posts'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Published Posts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['published_posts'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Comments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_comments'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Additional Stats Row --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Draft Posts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['draft_posts'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-edit fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Comments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_comments'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comment fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Views Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['page_views_today'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Unique Views Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['unique_views_today'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Recent Posts --}}
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Posts</h6>
                    <a href="{{ route('posts.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @forelse($recent_posts as $blog)
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary text-white">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $blog->created_at->format('M d, Y') }}</div>
                                <a href="{{ route('posts.show', $blog) }}" class="font-weight-bold">{{ $blog->title }}</a>
                                <div class="small text-muted">by {{ $blog->author->name }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No recent posts found.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Pending Comments --}}
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-warning">Pending Comments</h6>
                    <a href="#" class="btn btn-sm btn-warning">Moderate</a>
                </div>
                <div class="card-body">
                    @forelse($pending_comments as $comment)
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-3">
                                <div class="icon-circle bg-warning text-white">
                                    <i class="fas fa-comment"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $comment->created_at->format('M d, Y') }}</div>
                                <div class="font-weight-bold">{{ Str::limit($comment->content, 60) }}</div>
                                <div class="small text-muted">
                                    on <a href="{{ route('posts.show', $comment->post) }}">{{ $comment->post->title }}</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No pending comments.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Popular Posts --}}
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Popular Posts This Month</h6>
                </div>
                <div class="card-body">
                    @forelse($popular_posts as $blog)
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-3">
                                <span class="text-primary font-weight-bold">{{ $blog->page_views_count }}</span>
                                <div class="small text-muted">views</div>
                            </div>
                            <div>
                                <a href="{{ route('posts.show', $blog) }}" class="font-weight-bold">{{ $blog->title }}</a>
                                <div class="small text-muted">{{ $blog->published_at?->format('M d, Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No popular posts this month.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Recent Activities</h6>
                </div>
                <div class="card-body">
                    @forelse($recent_activities as $activity)
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-3">
                                <div class="icon-circle bg-info text-white">
                                    <i class="fas fa-history"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $activity->created_at->format('M d, Y H:i') }}</div>
                                <div class="font-weight-bold">{{ $activity->description }}</div>
                                @if($activity->user)
                                    <div class="small text-muted">by {{ $activity->user->name }}</div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No recent activities.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle {
    height: 2rem;
    width: 2rem;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-secondary {
    border-left: 0.25rem solid #858796 !important;
}

.border-left-dark {
    border-left: 0.25rem solid #5a5c69 !important;
}
</style>
@endsection