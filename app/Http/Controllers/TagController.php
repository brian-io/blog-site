<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TagController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index', 'show']),
            new Middleware('can:manage-tags', except: ['index', 'show']),
        ];
    }

    public function index()
    {
        $tags = Tag::withCount('publishedBlogs')
            ->orderBy('name')
            ->get();

        return view('tags.index', compact('tags'));
    }

    public function show(Tag $tag)
    {
        $blogs = $tag->publishedBlogs()
            ->with(['author', 'categories'])
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('tags.show', compact('tag', 'blogs'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'slug' => 'nullable|string|max:255|unique:tags,slug',
            'description' => 'nullable|string|max:500'
        ]);

        $tag = Tag::create($validated);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag created successfully!');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'slug' => 'nullable|string|max:255|unique:tags,slug,' . $tag->id,
            'description' => 'nullable|string|max:500'
        ]);

        $tag->update($validated);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag updated successfully!');
    }

    public function destroy(Tag $tag)
    {
        if ($tag->posts()->exists()) {
            return back()->with('error', 'Cannot delete tag with associated posts!');
        }

        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully!');
    }
}
