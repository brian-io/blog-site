<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $cacheType = 'default'): Response
    {
        $response = $next($request);

        // Set cache headers based on content type
        switch ($cacheType) {
            case 'blog_post':
                // Cache blog post for 1 hour
                $response->headers->set('Cache-control', 'public, max-age=360');
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s G\M\T', time() + 3600));
                break;

            case 'static':
                // Cache static assets for 1 week
                $response->headers->set('Cache-Control', 'public, max-age=604800');
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 604800));
                break;
                
            case 'no_cache':
                // Don't cache admin pages or dynamic content
                $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
                $response->headers->set('Pragma', 'no-cache');
                $response->headers->set('Expires', '0');
                break;
                
            case 'short':
                // Cache for 5 minutes (home page, blog index)
                $response->headers->set('Cache-Control', 'public, max-age=300');
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 300));
                break;
                
            default:
                // Default cache for 30 minutes
                $response->headers->set('Cache-Control', 'public, max-age=1800');
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 1800));
        }
        
        // Add ETag for better caching
        $etag = md5($response->getContent());
        $response->headers->set('ETag', $etag);
        
        // Check if client has cached version
        if ($request->header('If-None-Match') === $etag) {
            return response('', 304);
        }

        return $response;
    }

    
}
