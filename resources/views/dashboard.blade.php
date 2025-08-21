<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writing - Thoughts, Stories, and Insights</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600&family=crimson-text:400,600&display=swap" rel="stylesheet" />
</head>
<body class="bg-white text-gray-900 font-sans antialiased">
    <!-- Navigation -->
    <x-nav />

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-light text-gray-900 serif tracking-wide mb-8 leading-tight">
                Stories That Matter,
                <br>
                <span class="text-gray-600">Thoughts Worth Sharing</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-12 leading-relaxed">
                A collection of thoughtful essays, personal reflections, and insights on creativity, growth, and the art of living well.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="#stories" class="relative gradient-border bg-white text-gray-800 px-8 py-3 rounded-full text-sm font-medium hover:shadow-md transition-all duration-300 tracking-wide inline-flex items-center group">
                    <span>Explore Stories</span>
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                <a href="#newsletter" class="text-gray-600 hover:text-gray-900 font-medium text-sm tracking-wide transition-colors duration-300 px-8 py-3">
                    Subscribe to Updates
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Stories -->
    <section id="stories" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-light text-gray-900 serif tracking-wide mb-4">Featured Stories</h2>
                <p class="text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Recent thoughts and insights that have resonated with our community
                </p>
            </div>

            <div class="space-y-16">
                <!-- Featured Story 1 -->
                <article class="group max-w-4xl mx-auto">
                    <div class="flex flex-col lg:flex-row gap-8 items-start">
                        <div class="lg:w-1/3">
                            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                                <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="lg:w-2/3 space-y-4">
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <time class="tracking-wide">March 15, 2025</time>
                                <span class="text-gray-600 font-medium">Reflection</span>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-light text-gray-900 serif tracking-wide leading-tight">
                                <a href="#" class="hover:text-gray-700 transition-colors duration-300">
                                    The Art of Slow Living in a Fast World
                                </a>
                            </h3>
                            <p class="text-gray-600 leading-relaxed text-lg">
                                In our relentless pursuit of productivity and achievement, we often forget the profound value of slowing down. This exploration into mindful living reveals how embracing a gentler pace can lead to deeper connections, creative breakthroughs, and genuine fulfillment.
                            </p>
                            <div class="flex items-center justify-between pt-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full mr-3 flex items-center justify-center text-xs font-medium text-gray-700">
                                        S
                                    </div>
                                    <span class="font-medium tracking-wide">Sarah Chen</span>
                                    <span class="mx-3 text-gray-400">·</span>
                                    <span class="text-gray-500">8 min read</span>
                                </div>
                                <a href="#" class="text-gray-600 hover:text-gray-900 font-medium text-sm tracking-wide transition-colors duration-300 group">
                                    Read story
                                    <span class="inline-block transition-transform duration-300 group-hover:translate-x-1 ml-1">→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="w-16 h-px bg-gray-200 mx-auto"></div>

                <!-- Featured Story 2 -->
                <article class="group max-w-4xl mx-auto">
                    <div class="flex flex-col lg:flex-row-reverse gap-8 items-start">
                        <div class="lg:w-1/3">
                            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                                <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="lg:w-2/3 space-y-4">
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <time class="tracking-wide">March 12, 2025</time>
                                <span class="text-gray-600 font-medium">Creativity</span>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-light text-gray-900 serif tracking-wide leading-tight">
                                <a href="#" class="hover:text-gray-700 transition-colors duration-300">
                                    Finding Inspiration in Everyday Moments
                                </a>
                            </h3>
                            <p class="text-gray-600 leading-relaxed text-lg">
                                Creativity doesn't require grand gestures or perfect conditions. Sometimes the most profound insights emerge from the quiet observations of daily life—the way light falls through a window, an overheard conversation, or the rhythm of morning routines.
                            </p>
                            <div class="flex items-center justify-between pt-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full mr-3 flex items-center justify-center text-xs font-medium text-gray-700">
                                        M
                                    </div>
                                    <span class="font-medium tracking-wide">Marcus Reid</span>
                                    <span class="mx-3 text-gray-400">·</span>
                                    <span class="text-gray-500">6 min read</span>
                                </div>
                                <a href="#" class="text-gray-600 hover:text-gray-900 font-medium text-sm tracking-wide transition-colors duration-300 group">
                                    Read story
                                    <span class="inline-block transition-transform duration-300 group-hover:translate-x-1 ml-1">→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="w-16 h-px bg-gray-200 mx-auto"></div>

                <!-- Featured Story 3 -->
                <article class="group max-w-4xl mx-auto">
                    <div class="flex flex-col lg:flex-row gap-8 items-start">
                        <div class="lg:w-1/3">
                            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                                <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="lg:w-2/3 space-y-4">
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <time class="tracking-wide">March 8, 2025</time>
                                <span class="text-gray-600 font-medium">Growth</span>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-light text-gray-900 serif tracking-wide leading-tight">
                                <a href="#" class="hover:text-gray-700 transition-colors duration-300">
                                    The Stories We Tell Ourselves
                                </a>
                            </h3>
                            <p class="text-gray-600 leading-relaxed text-lg">
                                Every day, we narrate our lives through internal dialogue and self-perception. These stories shape our reality more than we realize. Examining and consciously crafting these narratives can be a powerful tool for personal transformation and growth.
                            </p>
                            <div class="flex items-center justify-between pt-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full mr-3 flex items-center justify-center text-xs font-medium text-gray-700">
                                        L
                                    </div>
                                    <span class="font-medium tracking-wide">Luna Park</span>
                                    <span class="mx-3 text-gray-400">·</span>
                                    <span class="text-gray-500">7 min read</span>
                                </div>
                                <a href="#" class="text-gray-600 hover:text-gray-900 font-medium text-sm tracking-wide transition-colors duration-300 group">
                                    Read story
                                    <span class="inline-block transition-transform duration-300 group-hover:translate-x-1 ml-1">→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- View all stories link -->
            <div class="text-center mt-16">
                <a href="#" class="text-gray-600 hover:text-gray-900 font-medium text-sm tracking-wide transition-colors duration-300 group">
                    View all stories
                    <span class="inline-block transition-transform duration-300 group-hover:translate-x-1 ml-1">→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section id="newsletter" class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-3xl font-light text-gray-900 serif tracking-wide mb-4">
                Stay Connected
            </h2>
            <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                Receive thoughtful stories and insights directly in your inbox. No spam, just meaningful content when inspiration strikes.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input 
                    type="email" 
                    placeholder="Your email address"
                    class="flex-1 px-0 py-3 border-0 border-b border-gray-200 bg-transparent placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-gray-400 text-gray-900 transition-colors duration-300"
                >
                <button class="relative gradient-border bg-white text-gray-800 px-6 py-3 rounded-full text-sm font-medium hover:shadow-md transition-all duration-300 tracking-wide whitespace-nowrap">
                    Subscribe
                </button>
            </div>
            <p class="text-gray-500 text-sm mt-4 tracking-wide">
                Unsubscribe at any time. We respect your privacy.
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-16 px-4 sm:px-6 lg:px-8 bg-white border-t border-gray-100">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xl font-light serif tracking-wide text-gray-900">Writing</span>
                    </div>
                    <p class="text-gray-600 leading-relaxed max-w-md">
                        A space for thoughtful reflection, creative expression, and meaningful dialogue about the art of living well.
                    </p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 mb-4 tracking-wide">Categories</h4>
                    <ul class="space-y-3 text-gray-600">
                        <li><a href="#" class="hover:text-gray-900 transition-colors duration-300">Reflection</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors duration-300">Creativity</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors duration-300">Growth</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors duration-300">Life</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 mb-4 tracking-wide">Connect</h4>
                    <ul class="space-y-3 text-gray-600">
                        <li><a href="#" class="hover:text-gray-900 transition-colors duration-300">About</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors duration-300">Contact</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors duration-300">Privacy</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors duration-300">Terms</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-100 mt-12 pt-8 text-center">
                <p class="text-gray-500 text-sm tracking-wide">
                    &copy; 2025 Writing. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Styles -->
    <style>
        /* Serif font for headings */
        .serif {
            font-family: 'Crimson Text', Georgia, serif;
        }

        /* Gradient border utility */
        .gradient-border {
            position: relative;
        }
        
        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            padding: 1px;
            background: linear-gradient(135deg, #e5e7eb, #9ca3af);
            border-radius: inherit;
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: xor;
            -webkit-mask-composite: xor;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Focus states */
        *:focus {
            outline: none;
        }

        input:focus,
        button:focus,
        a:focus {
            box-shadow: 0 0 0 2px rgba(156, 163, 175, 0.2);
        }
    </style>

    <script>
        // Smooth scroll behavior and navbar effects
        document.addEventListener('DOMContentLoaded', function() {
            // Navbar hide/show on scroll
            let lastScrollTop = 0;
            const navbar = document.querySelector('nav');
            
            window.addEventListener('scroll', function() {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                }
                lastScrollTop = scrollTop;
            });
        });
    </script>
</body>
</html>