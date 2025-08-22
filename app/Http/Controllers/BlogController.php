<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\UserActivity;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class BlogController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index', 'show']),
            new Middleware('can:create' . Blog::class, only: ['create', 'store']),
            new Middleware('can:update, blog', only:['edit', 'update']),
            new Middleware('can:delete, blog', only: ['destroy'])
        ];
    }
    //
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

        return view('blogs.index', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        if (!$blog->canBeViewedBy(Auth::user())){
            abort(404);
        }

        $blog->load(['author', 'categories', 'tags']);
        $blog->incrementViewCount();

        $comments = $blog->approvedComments()
                    ->with(['user', 'replies.user', 'votes'])
                    ->whereNull('parent_id')
                    ->withCount(['upvotes', 'downvotes'])
                    ->get();

        // Log page view
        $blog->pageViews()->create([
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referer' => request()->header('referer'),
            'is_unique' => !$blog->pageViews()
                ->where('ip_address', request()->ip())
                ->whereDate('created_at', today())
                ->exists()
        ]);

        // dd($comments);

        return view('blogs.show', compact('blog', 'comments'));

    }

    public function create()
    {
        $categories = Category::active()->get();
        $tags = Tag::all();

        return view('blogs.create', compact(['categories', 'tags']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:' . Blog::STATUS_DRAFT . ',' . Blog::STATUS_PUBLISHED . ',' . Blog::STATUS_SCHEDULED,
            'published_at' => 'nullable|date|after_or_equal:now',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

         if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blogs/featured-images', 'public');
        }

        $validated['user_id'] = Auth::id();
        
        if ($validated['status'] === Blog::STATUS_PUBLISHED && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $blog = Blog::create($validated);

        if ($request->filled('categories')) {
            $blog->categories()->sync($request->categories);
        }

        if ($request->filled('tags')) {
            $blog->tags()->sync($request->tags);
        }

        UserActivity::log(
            UserActivity::ACTION_BLOG_CREATED,
            'Created blog: ' . $blog->title,
            $blog
        );

        return redirect()->route('blogs.show', $blog)
            ->with('success', 'Blogs created successfully!');
    }

    public function edit(Blog $blog)
    {
        $categories = Category::active()->get();
        $tags = Tag::all();
        
        return view('blogs.edit', compact('blog', 'categories', 'tags'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:' . Blog::STATUS_DRAFT . ',' . Blog::STATUS_PUBLISHED . ',' . Blog::STATUS_SCHEDULED,
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blogs/featured-images', 'public');
        }

        $wasPublished = $blog->isPublished();
        $blog->update($validated);

        if ($request->filled('categories')) {
            $blog->categories()->sync($request->categories);
        }

        if ($request->filled('tags')) {
            $blog->tags()->sync($request->tags);
        }

        if (!$wasPublished && $blog->isPublished()) {
            UserActivity::log(
                UserActivity::ACTION_BLOG_PUBLISHED,
                'Published blog: ' . $blog->title,
                $blog
            );
        } else {
            UserActivity::log(
                UserActivity::ACTION_BLOG_UPDATED,
                'Updated blog: ' . $blog->title,
                $blog
            );
        }

        return redirect()->route('blogs.show', $blog)
            ->with('success', 'Blog updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $title = $blog->title;
        $blog->delete();

        UserActivity::log(
            'blog_deleted',
            'Deleted blog: ' . $title,
            $blog
        );

        return redirect()->route('blogs.index')
            ->with('success', 'Blog deleted successfully!');
    }
}
