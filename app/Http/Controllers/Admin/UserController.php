<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users with optional filters.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(12);

        $counts = [
            'total'   => User::count(),
            'active'  => User::where('is_active', true)->count(),
            'inactive'=> User::where('is_active', false)->count(),
            'admins'  => User::where('role', User::ROLE_ADMIN)->count(),
            'authors' => User::where('role', User::ROLE_AUTHOR)->count(),
            'users'   => User::where('role', User::ROLE_USER)->count(),
        ];

        return view('admin.users.index', compact('users', 'counts'));
    }

    /**
     * Show a single user with details.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Update user role or status.
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);

        $validated = $request->validate([
            'role' => ['nullable', Rule::in([User::ROLE_ADMIN, User::ROLE_AUTHOR, User::ROLE_USER])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user->update($validated);

        UserActivity::log(
            UserActivity::ACTION_USER_UPDATED,
            "Updated user: {$user->name} ({$user->email})",
            $user
        );

        return back()->with('success', 'User updated successfully.');
    }

    /**
     * Deactivate user account.
     */
    public function deactivate(User $user)
    {
        Gate::authorize('update', $user);

        $user->update(['is_active' => false]);

        UserActivity::log(
            UserActivity::ACTION_USER_DEACTIVATED,
            "Deactivated user: {$user->name}",
            $user
        );

        return back()->with('success', 'User deactivated successfully.');
    }

    /**
     * Activate user account.
     */
    public function activate(User $user)
    {
        Gate::authorize('update', $user);

        $user->update(['is_active' => true]);

        UserActivity::log(
            UserActivity::ACTION_USER_ACTIVATED,
            "Activated user: {$user->name}",
            $user
        );

        return back()->with('success', 'User activated successfully.');
    }

    /**
     * Permanently delete a user account.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $userName = $user->name;
        $user->delete();

        UserActivity::log(
            UserActivity::ACTION_USER_DELETED,
            "Deleted user: {$userName}",
            $user
        );

        return back()->with('success', 'User deleted successfully.');
    }
}
