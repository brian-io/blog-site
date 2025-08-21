<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;


class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array 
    {
        return [
            new Middleware('auth', except: ['index', 'show']),
            new Middleware('can:manage-categories', except: ['index', 'show']),
        ];
    }

    public function index()
    {
        $categories = Category::active()
            ->withCount('publishedBlogs')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));

    }

    public function show(Category $category)
    {
        $blogs = $category->publishedblogs()
            ->with(['author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('categories.show', compact('categories', 'blogs'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean'
        ]);

        $category = Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean'
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->exists()) {
            return back()->with('error', 'Cannot delete category with associated posts!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
