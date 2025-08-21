@props(['dashboardData'])

<div class="relative z-50" x-data="adminNav()">
    <aside class="hidden fixed h-screen min-h-screen w-64 bg-white/90 backdrop-blur-sm border-r border-gray-100 lg:flex flex-col space-y-4">
        <!-- Logo / Title -->
        <div class="h-20 flex items-center justify-center border-b border-gray-100">
            <a href="{{ route('admin.dashboard') }}"
                class="text-gray-900 serif font-light text-2xl tracking-wide hover:text-gray-700 transition-colors">
                Admin
            </a>
        </div>

        <!-- Nav Links -->
        <nav class="flex-1 p-4 space-y-12">
            <a href="{{ route('admin.dashboard') }}"
                class="group flex items-center space-x-3 text-gray-600 hover:text-gray-900 text-sm font-medium tracking-wide transition {{ request()->routeIs('admin.dashboard') ? 'text-gray-900' : '' }}">
                <svg class="w-4 h-4 opacity-60 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.blogs.index') }}"
                class="group flex items-center space-x-3 text-gray-600 hover:text-gray-900 text-sm font-medium tracking-wide transition {{ request()->routeIs('admin.blogs.*') ? 'text-gray-900' : '' }}">
                <svg class="w-4 h-4 opacity-60 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Posts</span>
            </a>

            <a href="{{ route('admin.comments.index') }}"
                class="group flex items-center justify-between text-gray-600 hover:text-gray-900 text-sm font-medium tracking-wide transition {{ request()->routeIs('admin.comments.*') ? 'text-gray-900' : '' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-4 h-4 opacity-60 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.681L3 21l2.975-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"/>
                    </svg>
                    <span>Comments</span>
                </div>
                @if($dashboardData['pendingComments'] > 0)
                    <span class="inline-flex items-center justify-center w-6 h-5 text-xs font-medium text-white bg-red-500 rounded-full">
                        {{ $dashboardData['pendingComments'] }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="group flex items-center space-x-3 text-gray-600 hover:text-gray-900 text-sm font-medium tracking-wide transition {{ request()->routeIs('admin.categories.*') ? 'text-gray-900' : '' }}">
                <svg class="w-4 h-4 opacity-60 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span>Categories</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="group flex items-center space-x-3 text-gray-600 hover:text-gray-900 text-sm font-medium tracking-wide transition {{ request()->routeIs('admin.users.*') ? 'text-gray-900' : '' }}">
                <svg class="w-4 h-4 opacity-60 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                <span>Users</span>
            </a>
        </nav>

        <!-- Footer / User menu -->
        <div class="p-4 border-t border-gray-100">
            <a href="{{ route('blogs.index') }}" class="flex items-center justify-center gradient-border bg-white text-gray-700 px-4 py-2 rounded-full text-sm font-medium hover:text-gray-900 hover:shadow-md transition-all">
                <span class="mr-4">View Site</span>
                <svg class="w-4 h-4 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"> 
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                    </path> 
                </svg>
            </a>
            <div class="mt-4">
                <!-- User dropdown -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <div 
                        class="flex items-center space-x-3 cursor-pointer hover:text-gray-900 font-medium overflow-auto" 
                        @click="open = !open">
                        @if(auth()->user()->avatar ?? false)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                        @else
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-xs font-medium text-gray-700">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-300" 
                             :class="{ 'rotate-180': open }" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <!-- Dropdown -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute left-0 bottom-full mb-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50">
                        <a href="{{ route('admin.settings.index') ?? '#' }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"> 
                            <div class="flex items-center space-x-2"> 
                                <svg class="w-4 h-4 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"> 
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path> 
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                    </path> 
                                </svg>
                                <span class="tracking-wide">Settings</span> 
                            </div> 
                        </a>
                        <div class="border-t border-gray-100 my-2"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200"> 
                                <div class="flex items-center space-x-2"> 
                                    <svg class="w-4 h-4 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"> 
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg> 
                                    <span class="tracking-wide">Sign out</span> 
                                </div> 
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile Admin Navigation -->
    <nav class="bg-white/80 backdrop-blur-sm border-b border-gray-100 lg:hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-20">

                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-900 serif font-light text-2xl tracking-wide hover:text-gray-700 transition-colors duration-300">
                        Admin
                    </a>
                </div>

                <!-- Right side: View Site & User Menu -->
                <div class="flex items-center space-x-4">

                    <!-- View Site Button -->
                    <a href="{{ route('blogs.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-full hover:text-gray-900 hover:shadow-md transition-all duration-300">
                        <svg class="w-4 h-4 mr-2 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        View Site
                    </a>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            @if(auth()->user()->avatar ?? false)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-medium text-gray-700">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" 
                                 :class="{ 'rotate-180': open }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50">
                            <a href="{{ route('admin.settings.index') ?? '#' }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <button type="button" 
                            class="bg-white p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-50 relative z-[60]"
                            @click="mobileMenuOpen = !mobileMenuOpen">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5 transition-transform duration-300" 
                             :class="{ 'rotate-90': mobileMenuOpen }"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/20 backdrop-blur-sm z-[51] lg:hidden"
         @click="mobileMenuOpen = false">
    </div>

    <!-- Mobile Sidebar -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transform transition ease-in-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed right-0 top-0 bottom-0 w-80 max-w-[85vw] bg-white shadow-2xl z-[52] lg:hidden flex flex-col">
        
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <h2 class="text-lg text-center serif text-gray-900">Admin</h2>
            <button @click="mobileMenuOpen = false" 
                    class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="flex-1 p-6 space-y-6 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" 
               @click="mobileMenuOpen = false"
               class="flex items-center space-x-4 text-gray-700 hover:text-gray-900 hover:bg-gray-50 p-3 rounded-lg transition-all font-medium {{ request()->routeIs('admin.dashboard') ? 'text-gray-900 bg-gray-50' : '' }}">
                <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.blogs.index') }}" 
               @click="mobileMenuOpen = false"
               class="flex items-center space-x-4 text-gray-700 hover:text-gray-900 hover:bg-gray-50 p-3 rounded-lg transition-all font-medium {{ request()->routeIs('admin.blogs.*') ? 'text-gray-900 bg-gray-50' : '' }}">
                <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Posts</span>
            </a>

            <a href="{{ route('admin.comments.index') }}" 
               @click="mobileMenuOpen = false"
               class="flex items-center justify-between text-gray-700 hover:text-gray-900 hover:bg-gray-50 p-3 rounded-lg transition-all font-medium {{ request()->routeIs('admin.comments.*') ? 'text-gray-900 bg-gray-50' : '' }}">
                <div class="flex items-center space-x-4">
                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.681L3 21l2.975-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"/>
                    </svg>
                    <span>Comments</span>
                </div>
                @if($dashboardData['pendingComments'] > 0)
                    <span class="inline-flex items-center justify-center w-6 h-5 text-xs font-medium text-white bg-red-500 rounded-full">
                        {{ $dashboardData['pendingComments'] }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.categories.index') }}" 
               @click="mobileMenuOpen = false"
               class="flex items-center space-x-4 text-gray-700 hover:text-gray-900 hover:bg-gray-50 p-3 rounded-lg transition-all font-medium {{ request()->routeIs('admin.categories.*') ? 'text-gray-900 bg-gray-50' : '' }}">
                <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span>Categories</span>
            </a>

            <a href="{{ route('admin.users.index') }}" 
               @click="mobileMenuOpen = false"
               class="flex items-center space-x-4 text-gray-700 hover:text-gray-900 hover:bg-gray-50 p-3 rounded-lg transition-all font-medium {{ request()->routeIs('admin.users.*') ? 'text-gray-900 bg-gray-50' : '' }}">
                <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                <span>Users</span>
            </a>
        </nav>

    </div>
</div>

<script>
function adminNav() {
    return {
        mobileMenuOpen: false,
        
        init() {
        
            // Prevent body scroll when mobile menu is open
            this.$watch('mobileMenuOpen', (value) => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = 'auto';
                }
            });

            // Close mobile menu on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.mobileMenuOpen) {
                    this.mobileMenuOpen = false;
                }
            });
        },

        // Clean up when component is destroyed
        destroy() {
            document.body.style.overflow = 'auto';
        }
    }
}
</script>