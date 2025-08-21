<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IpBlockController;
use App\Http\Controllers\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home route (redirect to blogs)
Route::get('/', function () {
    return redirect()->route('blogs.index');
});

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/

// Blogs - Public routes (index and show)
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog:slug}', [BlogController::class, 'show'])->name('blogs.show');

// Categories - Public routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Tags - Public routes
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/tags/{tag:slug}', [TagController::class, 'show'])->name('tags.show');

// Comments - Public store route (for guest comments)
Route::post('/blogs/{blog}/comments', [CommentController::class, 'store'])->name('comments.store');

// Newsletter - Public routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard route (requires email verification)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Blogs - Authenticated routes
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');

    // Comments - Authenticated routes
    // Route::put('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    // Route::put('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    // Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // // Users - Profile routes (accessible to own profile or authorized users)
    // Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    // Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
   
    // User Management
    Route::middleware(['can:manage-users'])->group(function () {
        Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [Admin\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [Admin\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [Admin\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [Admin\UserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/activate', [Admin\UserController::class, 'activate'])->name('users.activate');
        Route::patch('/users/{user}/deactivate', [Admin\UserController::class, 'deactivate'])->name('users.deactivate');
        Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');
    });

    // Blog Management
    Route::middleware(['can:manage-blogs'])->group(function () {
        Route::get('/blogs', [Admin\BlogController::class, 'index'])->name('blogs.index');
        Route::get('/blogs/create', [Admin\BlogController::class, 'create'])->name('blogs.create');
        Route::post('/blogs', [Admin\BlogController::class, 'store'])->name('blogs.store');
        Route::get('/blogs/{blog}', [Admin\BlogController::class, 'show'])->name('blogs.show');
        Route::get('/blogs/{blog}/edit', [Admin\BlogController::class, 'edit'])->name('blogs.edit');
        Route::put('/blogs/{blog}', [Admin\BlogController::class, 'update'])->name('blogs.update');
        Route::patch('/blogs/{blog}/publish', [Admin\BlogController::class, 'publish'])->name('blogs.publish');
        Route::patch('/blogs/{blog}/unpublish', [Admin\BlogController::class, 'unpublish'])->name('blogs.unpublish');
        Route::delete('/blogs/{blog}', [Admin\BlogController::class, 'destroy'])->name('blogs.destroy');
    });

    // Comment Management
    Route::middleware(['can:manage-comments'])->group(function () {
        Route::get('/comments', [Admin\CommentController::class, 'index'])->name('comments.index');
        Route::get('/comments/{comment}', [Admin\CommentController::class, 'show'])->name('comments.show');
        Route::patch('/comments/{comment}/approve', [Admin\CommentController::class, 'approve'])->name('comments.approve');
        Route::patch('/comments/{comment}/reject', [Admin\CommentController::class, 'reject'])->name('comments.reject');
        Route::delete('/comments/{comment}', [Admin\CommentController::class, 'destroy'])->name('comments.destroy');
    });

    // Category Management
    Route::middleware(['can:manage-categories'])->group(function () {
        Route::get('/categories', [Admin\CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [Admin\CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}', [Admin\CategoryController::class, 'show'])->name('categories.show');
        Route::get('/categories/{category}/edit', [Admin\CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [Admin\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    // Tag Management  
    Route::middleware(['can:manage-tags'])->group(function () {
        Route::get('/tags', [Admin\TagController::class, 'index'])->name('tags.index');
        Route::get('/tags/create', [Admin\TagController::class, 'create'])->name('tags.create');
        Route::post('/tags', [Admin\TagController::class, 'store'])->name('tags.store');
        Route::get('/tags/{tag}', [Admin\TagController::class, 'show'])->name('tags.show');
        Route::get('/tags/{tag}/edit', [Admin\TagController::class, 'edit'])->name('tags.edit');
        Route::put('/tags/{tag}', [Admin\TagController::class, 'update'])->name('tags.update');
        Route::delete('/tags/{tag}', [Admin\TagController::class, 'destroy'])->name('tags.destroy');
    });

    // IP Block Management
    Route::middleware(['can:manage-security'])->group(function () {
        Route::get('/ip-blocks', [Admin\IpBlockController::class, 'index'])->name('ip-blocks.index');
        Route::get('/ip-blocks/create', [Admin\IpBlockController::class, 'create'])->name('ip-blocks.create');
        Route::post('/ip-blocks', [Admin\IpBlockController::class, 'store'])->name('ip-blocks.store');
        Route::get('/ip-blocks/{ipBlock}', [Admin\IpBlockController::class, 'show'])->name('ip-blocks.show');
        Route::get('/ip-blocks/{ipBlock}/edit', [Admin\IpBlockController::class, 'edit'])->name('ip-blocks.edit');
        Route::put('/ip-blocks/{ipBlock}', [Admin\IpBlockController::class, 'update'])->name('ip-blocks.update');
        Route::delete('/ip-blocks/{ipBlock}', [Admin\IpBlockController::class, 'destroy'])->name('ip-blocks.destroy');
    });

    // Settings Management (commonly needed in admin panels)
    Route::middleware(['can:manage-settings'])->group(function () {
        Route::get('/settings', [Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [Admin\SettingsController::class, 'update'])->name('settings.update');
    });

    // Analytics/Reports (optional but common)
    Route::middleware(['can:view-analytics'])->group(function () {
        Route::get('/analytics', [Admin\AnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    });
});

/*
|--------------------------------------------------------------------------
| API Routes (Optional - for AJAX requests)
|--------------------------------------------------------------------------
*/

Route::prefix('api')->name('api.')->middleware(['auth'])->group(function () {
    // You can add API endpoints here for AJAX functionality
    // For example:
    // Route::get('/blogs/{blog}/stats', [BlogController::class, 'getStats'])->name('blogs.stats');
    // Route::post('/blogs/{blog}/like', [BlogController::class, 'toggleLike'])->name('blogs.like');
});

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/

// 404 fallback
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

require __DIR__.'/auth.php';
