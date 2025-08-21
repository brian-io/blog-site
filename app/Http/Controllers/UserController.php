<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            'auth', 
            new Middleware('can:manage-users', except: ['show', 'edit', 'update']),
        ];
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::withCount(['blogs', 'comments'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:' . User::ROLE_ADMIN . ',' . User::ROLE_AUTHOR . ',' . User::ROLE_USER,
            'bio' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'avatar' => 'nullable|image|max:1024',
            'is_active' => 'boolean'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')
                                        ->store('avatars', 'public');
        }

        $user = User::create($validated);

        return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('view', $user);

        $blogs = $user->blogs()
            ->with(['categories', 'tags'])
            ->orderBy(['created_at', 'desc'])
            ->paginate(10);

        return view('users.show', compact('user', 'blogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);

        // Additional authorization for role changes
            if ($request->has('role') && $request->role !== $user->role) {
                Gate::authorize('changeRole', $user);
            }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:' . User::ROLE_ADMIN . ',' . User::ROLE_AUTHOR . ',' . User::ROLE_USER,
            'bio' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'avatar' => 'nullable|image|max:1024',
            'is_active' => 'boolean'
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')
                ->store('avatars', 'public');
        }

       $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->blogs()->exists()) {
            return back()->with('error', 'Cannot delete user with published blogs!');
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}
