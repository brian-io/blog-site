<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SettingsController extends Controller implements HasMiddleware {

    public static function middleware()
    {
        return [
            'auth'
        ];
    }

    
    public function index (Request $request) {
        return [];
    }
}