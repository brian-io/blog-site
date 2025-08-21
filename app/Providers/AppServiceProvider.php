<?php

namespace App\Providers;

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Policies\BlogPolicy;
use App\Policies\CommentPolicy;
use App\Policies\UserPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\TagPolicy;
use App\Policies\AdminPolicy;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;



class AppServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Blog::class => BlogPolicy::class,
        Comment::class => CommentPolicy::class,
        User::class => UserPolicy::class,
        Category::class => CategoryPolicy::class,
        Tag::class => TagPolicy::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();

        // Define gates for admin access control
        Gate::define('access-admin', [AdminPolicy::class, 'accessAdmin']);
        Gate::define('manage-security', [AdminPolicy::class, 'manageSecurity']);
        Gate::define('view-analytics', [AdminPolicy::class, 'viewAnalytics']);
        Gate::define('manage-settings', [AdminPolicy::class, 'manageSettings']);
        
        // Define gates for category and tag management
        Gate::define('manage-categories', [CategoryPolicy::class, 'manageCategories']);
        Gate::define('manage-tags', [TagPolicy::class, 'manageTags']);
        Gate::define('manage-users', [UserPolicy::class, 'manageUsers']);
        Gate::define('manage-comments', [CommentPolicy::class, 'manageComments']);
        Gate::define('manage-blogs', [BlogPolicy::class, 'manageBlogs']);

        // Super admin gate (for critical operations)
        Gate::define('super-admin', function (User $user) {
            return $user->isAdmin() && $user->email === config('app.super_admin_email');
        });

        // Author gate (for content creation)
        Gate::define('author-access', function (User $user) {
            return $user->isAuthor() || $user->isAdmin();
        });

        Blade::withoutDoubleEncoding();

        View::composer('layouts.admin', function ($view) {
            $dashboardData = Cache::remember('admin_dashboard_data', 300, function () {
                return app(DashboardController::class)->getDashboardData();
            });

            $view->with('dashboardData', $dashboardData);
        });
    }
}
