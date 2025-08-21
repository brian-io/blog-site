<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class MobileDetection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isMobile = $this->isMobileDevice($request);
        $isTablet = $this->isTabletDevice($request);

        // Add device info to request for use in views
        $request->merge([
            'is_mobile' => $isMobile,
            'is_tablet' => $isTablet,
            'is_desktop' => !$isMobile && !$isTablet,
        ]);
        
        // Set device type in session for persistent detection
        session(['device_type' => $isMobile ? 'mobile' : ($isTablet ? 'tablet' : 'desktop')]);

        $response = $next($request);

        // Add device detection headers 
        $response->headers->set('X-Device-Type', session('device_type')); // response is an instanceof SymfonyResponse as opposed to an Illuminate response where it would be $response->header($key, $value); https://stackoverflow.com/questions/43593351/call-to-undefined-method-symfony-component-httpfoundation-responseheader

        // Optionally redirect mobile users to AMP or mobile-specific routes
        if ($isMobile && $this->shouldRedirectToAmp($request)) {
            $ampUrl = $this->getAmpUrl($request);
            if($ampUrl) {
                return redirect($ampUrl);
            }
        }

        return $response;
    }

    /**
     * Detect if the request is from a mobile device
     */
    private function isMobileDevice(Request $request) {
        $userAgent = $request->userAgent();

        $mobilePatterns = [
            'Mobile', 'Android', 'iPhone', 'iPod', 'BlackBerry', 
            'Windows Phone', 'Opera Mini', 'IEMobile', 'Mobile Safari'
        ];

        foreach ($mobilePatterns as $pattern) {
            if (stripos($userAgent, $pattern) !== false) {
                return true;
            }
        }

        return false;

    }

    /**
     * Detect if the request is from a tablet device
     */
    private function isTabletDevice(Request $request)
    {
        $userAgent = $request->userAgent();
        
        // Check for iPad
        if (stripos($userAgent, 'iPad') !== false) {
            return true;
        }
        
        // Check for Android tablets (Android without Mobile)
        if (stripos($userAgent, 'Android') !== false && stripos($userAgent, 'Mobile') === false) {
            return true;
        }
        
        // Check for other tablet patterns
        $tabletPatterns = ['Tablet', 'PlayBook', 'Kindle', 'Silk'];
        
        foreach ($tabletPatterns as $pattern) {
            if (stripos($userAgent, $pattern) !== false) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Determine if mobile users should be redirected to AMP
     */
    private function shouldRedirectToAmp(Request $request)
    {
        // Only redirect for blog post pages
        $route = $request->route();
        if (!$route || $route->getName() !== 'blog.show') {
            return false;
        }
        
        // Don't redirect if user has explicitly chosen non-AMP
        if ($request->has('no_amp')) {
            return false;
        }
        
        // Don't redirect if coming from search engines (they handle AMP themselves)
        $referer = $request->header('referer', '');
        $searchEngines = ['google.com', 'bing.com', 'yahoo.com', 'duckduckgo.com'];
        
        foreach ($searchEngines as $engine) {
            if (stripos($referer, $engine) !== false) {
                return false;
            }
        }
        
        return true;
    }
    /**
     * Generate AMP URL for the current request
     */
    private function getAmpUrl(Request $request)
    {
        $currentUrl = $request->url();
        
        // Simple AMP URL generation - adjust based on your routing
        if (str_contains($currentUrl, '/blog/')) {
            return str_replace('/blog/', '/amp/blog/', $currentUrl);
        }
        
        return null;
    }
}
