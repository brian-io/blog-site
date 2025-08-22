<nav class="fixed z-50 w-full mx-auto" x-data="mainNav()">
    <div class="floating-nav shadow-sm shadow-black/5">
        <div class="max-w-5xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo/Brand -->
                <div class="flex items-center">
                    <a href="{{ route('blogs.index') }}" class="flex items-center">
                        <h1 class="text-xl font-light text-gray-900 serif tracking-wide">ReadItt</h1>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-12">
                    <div class="nav-item relative flex flex-col items-center">
                        <a href="{{ route('blogs.index') }}" class="nav-link serif text-gray-600 hover:text-gray-900 font-medium tracking-wide transition-colors duration-300 {{ request()->routeIs('blogs.*') ? 'text-gray-900' : '' }}">
                            Writing
                        </a>
                        @if(request()->routeIs('blogs.*'))
                            <div class="w-1 h-1 bg-gray-900 rounded-full mt-2"></div>
                        @endif
                    </div>

                    <div class="nav-item relative flex flex-col items-center">
                        <a href="#" class="nav-link serif text-gray-600 hover:text-gray-900 font-medium tracking-wide transition-colors duration-300">
                            Projects
                        </a>
                    </div>

                    <div class="nav-item relative flex flex-col items-center">
                        <a href="#" class="nav-link serif text-gray-600 hover:text-gray-900 font-medium tracking-wide transition-colors duration-300">
                            About
                        </a>
                    </div>

                    <!-- Separator -->
                    <div class="w-px h-8 bg-gray-200"></div>

                    <!-- Auth Section -->
                    <div class="flex items-center space-x-6">
                        @auth
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" 
                                        class="flex items-center text-gray-600 hover:text-gray-900 font-medium serif tracking-wide transition-colors duration-300 focus:outline-none">
                                    {{ auth()->user()->initials }}
                                    <svg class="w-4 h-4 ml-2 transition-transform duration-200" 
                                         :class="{ 'rotate-180': open }" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-95"
                                     class="absolute left-0 mt-2 w-32 bg-white shadow-lg border border-gray-100 rounded-md origin-top-left">
                                    <div class="py-2">
                                        <!-- Profile -->
                                        <a href="#" 
                                            class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                            <!-- User Icon -->
                                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"  stroke="currentColor" stroke-width="2"  class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6 20c0-3.31 2.69-6 6-6s6 2.69 6 6" />
                                            </svg>
                                            <span class="text-sm">Profile</span>
                                        </a>

                                        <!-- Settings -->
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"> 
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

                                        <!-- Divider -->
                                        <div class="border-t border-gray-100 my-2"></div>

                                        <!-- Sign out -->
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
                        @endauth
                        @guest
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 serif font-medium tracking-wide transition-colors duration-300">
                                Sign In
                            </a>
                        @endguest
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="text-gray-600 hover:text-gray-900 focus:outline-none transition-colors duration-300">
                        <svg class="w-6 h-6 transition-transform duration-200" 
                             :class="{ 'rotate-90': mobileMenuOpen }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  x-show="!mobileMenuOpen"
                                  d="M4 6h16M4 12h16M4 18h16"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  x-show="mobileMenuOpen"
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Backdrop Blur Overlay -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/20 backdrop-blur-sm lg:hidden z-40"
         @click="mobileMenuOpen = false">
    </div>

    <!-- Mobile Sidebar Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="transform translate-x-full"
         x-transition:enter-end="transform translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="transform translate-x-0"
         x-transition:leave-end="transform translate-x-full"
         class="fixed right-0 top-0 h-full w-80 max-w-sm bg-white shadow-xl lg:hidden z-50 overflow-y-auto">
        
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h2 class="text-xl font-light text-gray-900 serif tracking-wide">GT</h2>
            <button @click="mobileMenuOpen = false" 
                    class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <div class="px-6 py-8 space-y-8">
            <div class="space-y-6">
                <a href="{{ route('blogs.index') }}" 
                   @click="mobileMenuOpen = false"
                   class="flex items-center text-gray-700 hover:text-gray-900 font-medium text-lg serif tracking-wide transition-colors duration-300 {{ request()->routeIs('blogs.*') ? 'text-gray-900' : '' }}">
                    <span>Writing</span>
                    @if(request()->routeIs('blogs.*'))
                        <div class="w-2 h-2 bg-gray-900 rounded-full ml-3"></div>
                    @endif
                </a>
                <a href="#" 
                   @click="mobileMenuOpen = false"
                   class="block text-gray-700 hover:text-gray-900 font-medium text-lg serif tracking-wide transition-colors duration-300">
                    Projects
                </a>
                <a href="#" 
                   @click="mobileMenuOpen = false"
                   class="block text-gray-700 hover:text-gray-900 font-medium text-lg serif tracking-wide transition-colors duration-300">
                    About
                </a>
            </div>
            
            <!-- Auth Section -->
            <div class="border-t border-gray-200 pt-8 space-y-6">
                @auth
                    <div class="space-y-4">
                         <!-- User Actions -->
                    <div class="space-y-3">
                        <a href="#" 
                           @click="mobileMenuOpen = false"
                           class="flex items-center space-x-3 px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"  stroke="currentColor" stroke-width="2"  class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6 20c0-3.31 2.69-6 6-6s6 2.69 6 6" />
                            </svg>
                            <span>Profile</span>
                        </a>
                        <a href="#" 
                           @click="mobileMenuOpen = false"
                           class="flex items-center space-x-3 px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"> 
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path> 
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path> 
                            </svg>
                            <span>Settings</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center space-x-3 w-full px-3 py-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"> 
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg> 
                                <span>Sign out</span>
                            </button>
                        </form>
                    </div>
                        <!-- User Info -->
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-gray-600 font-medium">{{ auth()->user()->initials }}</span>
                            </div>
                            <div>
                                <p class="text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('blogs.create') }}" 
                           @click="mobileMenuOpen = false"
                           class="block w-full text-center relative gradient-border bg-white text-gray-800 px-6 py-3 rounded-full font-medium hover:shadow-md transition-all duration-300">
                            + Post
                        </a>
                    </div>
                    @endauth
                    
                   @guest
                    <div class="text-center">
                        <a href="{{ route('login') }}" 
                           @click="mobileMenuOpen = false"
                           class="inline-block w-full text-center bg-gray-900 text-white px-6 py-3 rounded-full font-medium serif tracking-wide hover:bg-gray-800 transition-colors duration-300">
                            Sign In
                        </a>
                    </div>
                    @endguest
            </div>
        </div>
    </div>
</nav>

<script>
function mainNav() {
    return {
        mobileMenuOpen: false,
        
        init() {
            // Close mobile menu on window resize to desktop
            this.$nextTick(() => {
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        this.mobileMenuOpen = false;
                    }
                });
            });

            // Prevent body scroll when mobile menu is open
            this.$watch('mobileMenuOpen', (value) => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = 'auto';
                }
            });

            // Close mobile menu on route changes (if using Turbo/Livewire)
            document.addEventListener('turbo:visit', () => {
                this.mobileMenuOpen = false;
            });
            
            document.addEventListener('livewire:navigated', () => {
                this.mobileMenuOpen = false;
            });
        }
    }
}
</script>