 <footer class="bg-white/50 backdrop-blur-sm border-t border-gray-200/50 mt-24">
        <div class="max-w-5xl mx-auto py-12 px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Newsletter -->
                <div>
                    <h3 class="text-lg font-light text-gray-900 serif tracking-wide mb-6">Stay Updated</h3>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="email" 
                               name="email" 
                               placeholder="Your email address" 
                               required 
                               class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-300 text-sm">
                        <button type="submit" 
                                class="w-full bg-gray-900 text-white px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors duration-300 text-sm font-medium tracking-wide">
                            Subscribe
                        </button>
                    </form>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-light text-gray-900 serif tracking-wide mb-6">Explore</h3>
                    <ul class="space-y-4">
                        <li>
                            <a href="{{ route('blogs.index') }}" 
                               class="text-gray-600 hover:text-gray-900 transition-colors duration-300 font-medium tracking-wide">
                                All Stories
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('categories.index') }}" 
                               class="text-gray-600 hover:text-gray-900 transition-colors duration-300 font-medium tracking-wide">
                                Categories
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tags.index') }}" 
                               class="text-gray-600 hover:text-gray-900 transition-colors duration-300 font-medium tracking-wide">
                                Tags
                            </a>
                        </li>
                        <li>
                            <a href="#" 
                               class="text-gray-600 hover:text-gray-900 transition-colors duration-300 font-medium tracking-wide">
                                About
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Brand -->
                <div class="md:text-right">
                    <div class="mb-6">
                        <h4 class="text-xl font-light text-gray-900 serif tracking-wide mb-2">Blog</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Thoughts, stories, and insights on technology, design, and creativity.
                        </p>
                    </div>
                    <p class="text-gray-500 text-sm tracking-wide">
                        &copy; {{ date('Y') }} ReadItt. All rights reserved.
                    </p>
                </div>
            </div>
            
            <!-- Bottom Section -->
            <div class="border-t border-gray-200/50 mt-12 pt-8">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <div class="flex space-x-8">
                        <a href="#" class="text-gray-500 hover:text-gray-700 transition-colors duration-300 text-sm">
                            Privacy
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-700 transition-colors duration-300 text-sm">
                            Terms
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-700 transition-colors duration-300 text-sm">
                            RSS
                        </a>
                    </div>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-500 hover:text-gray-700 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-700 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-700 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>