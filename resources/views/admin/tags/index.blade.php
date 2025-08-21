{{-- resources/views/admin/tags/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manage Tags')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tags</h1>
        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> New Tag
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Tags</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Posts Count</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tags ?? [] as $tag)
                            <tr>
                                <td>
                                    <span class="badge badge-secondary">{{ $tag->name }}</span>
                                </td>
                                <td><code>{{ $tag->slug }}</code></td>
                                <td>
                                    <span class="badge badge-info">{{ $tag->posts_count ?? 0 }}</span>
                                </td>
                                <td>
                                    @if($tag->description)
                                        <small class="text-muted">{{ Str::limit($tag->description, 50) }}</small>
                                    @else
<span class="text-muted font-italic">No description</span>
                                   @endif
                               </td>
                               <td>
                                   <small class="text-muted">{{ $tag->created_at->format('M d, Y') }}</small>
                               </td>
                               <td>
                                   <div class="btn-group" role="group">
                                       <a href="{{ route('admin.tags.show', $tag) }}" class="btn btn-info btn-sm" title="View">
                                           <i class="fas fa-eye"></i>
                                       </a>
                                       <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-warning btn-sm" title="Edit">
                                           <i class="fas fa-edit"></i>
                                       </a>
                                       <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this tag?')">
                                           @csrf
                                           @method('DELETE')
                                           <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                               <i class="fas fa-trash"></i>
                                           </button>
                                       </form>
                                   </div>
                               </td>
                           </tr>
                       @empty
                           <tr>
                               <td colspan="6" class="text-center text-muted py-4">
                                   <i class="fas fa-tags fa-3x mb-3 text-gray-300"></i>
                                   <h5>No tags found</h5>
                                   <p>Get started by creating your first tag.</p>
                                   <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
                                       <i class="fas fa-plus"></i> Create Tag
                                   </a>
                               </td>
                           </tr>
                       @endforelse
                   </tbody>
               </table>
           </div>
           
           @if(isset($tags) && method_exists($tags, 'links'))
               <div class="d-flex justify-content-center mt-4">
                   {{ $tags->links() }}
               </div>
           @endif
       </div>
   </div>
</div>
@endsection

@push('scripts')
<script>
   // Auto-hide alerts after 5 seconds
   setTimeout(function() {
       $('.alert').fadeOut('slow');
   }, 5000);
</script>
@endpush