<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BlogController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        // Only allow authenticated admins
        return [
            'auth', 
            'can:manage-blogs'
        ];
    }

    /**
     * Display a listing of the blogs.
     */
    public function index(Request $request)
    {
        $query = Blog::with(['author', 'categories', 'tags'])
            ->published()
            ->orderBy('published_at', 'desc');

        if($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request){
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        $blogs = $query->paginate(10);

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog.
     */
    // public function create()
    // {
    //     return view('admin.blogs.create');
    // }

    /**
     * Store a newly created blog in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'required|in:draft,published',
        ]);

        $blog = Blog::create([
            'title'   => $validated['title'],
            'content' => $validated['content'],
            'status'  => $validated['status'],
            'user_id' => Auth::id(),
        ]);

        UserActivity::log(
            UserActivity::ACTION_BLOG_CREATED,
            "Created blog: {$blog->title}",
            $blog
        );

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog created successfully!');
    }

    /**
     * Display the specified blog.
     */
    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified blog.
     */
    // public function edit(Blog $blog)
    // {
    //     return view('admin.blogs.edit', compact('blog'));
    // }

    /**
     * Update the specified blog in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'required|in:draft,published',
        ]);

        $blog->update($validated);

        UserActivity::log(
            UserActivity::ACTION_BLOG_UPDATED,
            "Updated blog: {$blog->title}",
            $blog
        );

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully!');
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog)
    {
        Gate::authorize('delete', $blog);

        $blog->delete();

        UserActivity::log(
            UserActivity::ACTION_BLOG_DELETED,
            "Deleted blog: {$blog->title}",
            $blog
        );

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully!');
    }

    /**
     * Publish a blog.
     */
    public function publish(Blog $blog)
    {
        $blog->update(['status' => 'published']);

        UserActivity::log(
            UserActivity::ACTION_BLOG_PUBLISHED,
            "Published blog: {$blog->title}",
            $blog
        );

        return back()->with('success', 'Blog published successfully!');
    }

    /**
     * Unpublish a blog.
     */
    public function unpublish(Blog $blog)
    {
        $blog->update(['status' => 'draft']);

        UserActivity::log(
            UserActivity::ACTION_BLOG_UNPUBLISHED,
            "Unpublished blog: {$blog->title}",
            $blog
        );

        return back()->with('success', 'Blog unpublished successfully!');
    }
}
