@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Users</h1>

        <!-- Search Form -->
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search users..."
                   class="border rounded px-3 py-1.5 text-sm">
            <button type="submit"
                    class="bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700 text-sm">
                Search
            </button>
        </form>
    </div>

    <!-- Tabs -->
    <div class="flex space-x-6 border-b mb-4 text-sm">
        <a href="{{ route('admin.users.index') }}"
           class="pb-2 {{ request()->missing(['role','status']) ? 'border-b-2 border-blue-600 font-semibold' : '' }}">
            All {{ $counts['total'] }}
        </a>
        <a href="{{ route('admin.users.index', ['status' => 'active']) }}"
           class="pb-2 {{ request('status') === 'active' ? 'border-b-2 border-blue-600 font-semibold' : '' }}">
            Active ({{ $counts['active'] }})
        </a>
        <a href="{{ route('admin.users.index', ['status' => 'inactive']) }}"
           class="pb-2 {{ request('status') === 'inactive' ? 'border-b-2 border-blue-600 font-semibold' : '' }}">
            Inactive ({{ $counts['inactive'] }})
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}"
           class="pb-2 {{ request('role') === 'admin' ? 'border-b-2 border-blue-600 font-semibold' : '' }}">
            Admins ({{ $counts['admins'] }})
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'author']) }}"
           class="pb-2 {{ request('role') === 'author' ? 'border-b-2 border-blue-600 font-semibold' : '' }}">
            Authors ({{ $counts['authors'] }})
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'user']) }}"
           class="pb-2 {{ request('role') === 'user' ? 'border-b-2 border-blue-600 font-semibold' : '' }}">
            Users ({{ $counts['users'] }})
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Joined</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $user->id }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                        <td class="px-4 py-2">
                            @if($user->is_active)
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-700">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-700">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <!-- Show -->
                            <a href="{{ route('admin.users.show', $user) }}"
                               class="text-blue-600 hover:underline">View</a>

                            <!-- Activate/Deactivate -->
                            @if($user->is_active)
                                <form action="{{ route('admin.users.deactivate', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-yellow-600 hover:underline">Deactivate</button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:underline">Activate</button>
                                </form>
                            @endif

                            <!-- Delete -->
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-16">
        {{ $users->withQueryString()->links() }}
    </div>
@endsection
