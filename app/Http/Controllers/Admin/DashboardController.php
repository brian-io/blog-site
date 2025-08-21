<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\User;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\Category;
use App\Models\PageView;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array 
    {
        return [
            'auth', 
            new Middleware('can:access-admin'),
        ];
    }

    public function index(?Request $request) 
    {
        // Cache the dashboard data for 5 minutes to improve performance
        $dashboardData = Cache::remember('admin_dashboard_data', 300, function () {
            return $this->getDashboardData();
        });

        return view('admin.dashboard', $dashboardData);
    }

    /**
     * Get all dashboard data
     */
    public function getDashboardData(): array
    {
        return [
            // Basic stats
            'totalBlogs' => $this->getBlogStats()['total'],
            'blogsThisMonth' => $this->getBlogStats()['this_month'],
            'activeUsers' => $this->getUserStats()['active'],
            'totalUsers' => $this->getUserStats()['total'],
            'totalComments' => $this->getCommentStats()['total'],
            'pendingComments' => $this->getCommentStats()['pending'],
            'totalCategories' => Category::count(),
            'totalTags' => Tag::count(),
            
            // Recent content
            'recentBlogs' => $this->getRecentBlogs(),
            
            // Chart data
            'monthlyPosts' => $this->getMonthlyPostsData(),
            'popularCategories' => $this->getPopularCategories(),
            
            // System info
            'storageUsed' => $this->getStorageUsage(),
            'databaseSize' => $this->getDatabaseSize(),
            
            // Additional useful data
            'recentActivities' => $this->getRecentActivities(),
            'popularBlogs' => $this->getPopularBlogs(),
            'pendingCommentsData' => $this->getPendingComments(),
            // 'popularTags' => $this->getPopularTags(),
            'categoryStats' => $this->getCategoryStats(),
        ];
    }

    /**
     * Get blog statistics
     */
    private function getBlogStats(): array
    {
        return [
            'total' => Blog::count(),
            'published' => Blog::where('status', 'published')->count(),
            'draft' => Blog::where('status', 'draft')->count(),
            'this_month' => Blog::whereMonth('created_at', now())->count(),
            'this_week' => Blog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];
    }

    /**
     * Get user statistics
     */
    private function getUserStats(): array
    {
        return [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'new_this_month' => User::whereMonth('created_at', now())->count(),
            'admin_count' => User::where('role', 'admin')->count(),
        ];
    }

    /**
     * Get comment statistics
     */
    private function getCommentStats(): array
    {
        return [
            'total' => Comment::count(),
            'pending' => Comment::where('status', 'pending')->count(),
            'approved' => Comment::where('status', 'approved')->count(),
            'rejected' => Comment::where('status', 'rejected')->count(),
        ];
    }

    /**
     * Get recent blogs with relationships
     */
    private function getRecentBlogs()
    {
        return Blog::with(['author:id,name', 'categories:id,name', 'tags:id,name'])
            ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'status', 'created_at', 'user_id')
            ->latest()
            ->take(5)
            ->get();
    }

    /**
     * Get monthly posts data for the last 6 months
     */
    private function getMonthlyPostsData(): array
    {
        $monthlyData = Blog::selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at)'), DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->orderBy(DB::raw('EXTRACT(YEAR FROM created_at)'))
            ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->get();


        // Fill in missing months with 0
        $result = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $found = $monthlyData->first(function ($item) use ($month, $year) {
                return $item->month == $month && $item->year == $year;
            });
            
            $result[] = $found ? $found->count : 0;
        }

        return $result;
    }

    /**
     * Get popular categories with post counts
     */
    private function getPopularCategories(): array
    {
        

        $categories = Category::select('id', 'name')
            ->withCount('publishedblogs as blogs_count')
            ->get()
            ->where('blogs_count', '>', 0)
            ->sortByDesc('blogs_count')
            ->take(5)
            ->values(); // Re-index the collection

        if ($categories->isEmpty()) {
            return [];
        }

        $maxCount = $categories->first()->blogs_count;

        return $categories->map(function ($category) use ($maxCount) {
            return [
                'name' => $category->name,
                'count' => $category->blogs_count,
                'percentage' => $maxCount > 0 ? round(($category->blogs_count / $maxCount) * 100) : 0,
            ];
        })->toArray();
    }

    /**
     * Get storage usage (placeholder - implement based on your needs)
     */
    private function getStorageUsage(): string
    {
        // This is a simplified version - you might want to implement actual storage calculation
        try {
            $uploadsPath = storage_path('app/public/uploads');
            if (is_dir($uploadsPath)) {
                $size = $this->getFolderSize($uploadsPath);
                return $this->formatBytes($size);
            }
        } catch (\Exception $e) {
            // Log error if needed
        }
        
        return '0 MB';
    }

    /**
     * Get database size (placeholder - implement based on your needs)
     */
    private function getDatabaseSize(): string
    {
        try {
            $databaseName = config('database.connections.mysql.database');
            $result = DB::select("
                SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS 'db_size'
                FROM information_schema.tables
                WHERE table_schema = ?
            ", [$databaseName]);
            
            return ($result[0]->db_size ?? 0) . ' MB';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    /**
     * Get recent user activities
     */
    private function getRecentActivities()
    {
        return UserActivity::with('user:id,name')
            ->latest()
            ->take(10)
            ->get();
    }

    /**
     * Get popular blogs based on views this month
     */
    private function getPopularBlogs()
    {
        return Blog::select('id', 'title', 'slug', 'created_at')
            ->withCount(['pageViews' => function ($query) {
                $query->whereMonth('created_at', now()->month);
            }])
            ->get()
            ->where('page_views_count', '>', 0)
            ->sortByDesc('page_views_count')
            ->take(5)
            ->values();
    }

    /**
     * Get pending comments with related data
     */
    private function getPendingComments()
    {
        return Comment::with(['blog:id,title,slug', 'user:id,name'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();
    }

    /**
     * Helper method to calculate folder size
     */
    private function getFolderSize(string $path): int
    {
        $size = 0;
        $files = glob($path . '/*');
        
        foreach ($files as $file) {
            if (is_file($file)) {
                $size += filesize($file);
            } elseif (is_dir($file)) {
                $size += $this->getFolderSize($file);
            }
        }
        
        return $size;
    }

    /**
     * Helper method to format bytes
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Get detailed category statistics
     */
    private function getCategoryStats(): array
    {
        $totalCategories = Category::count();
        $categoriesWithPosts = Category::has('blogs')->count();
        $averagePostsPerCategory = $totalCategories > 0 
            ? round(Blog::count() / $totalCategories, 1) 
            : 0;

        return [
            'total' => $totalCategories,
            'with_posts' => $categoriesWithPosts,
            'empty' => $totalCategories - $categoriesWithPosts,
            'average_posts' => $averagePostsPerCategory,
        ];
    }
}