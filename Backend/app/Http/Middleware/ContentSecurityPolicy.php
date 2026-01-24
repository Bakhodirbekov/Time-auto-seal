<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Define CSP policy
        // We avoid 'unsafe-eval' as recommended.
        // We allow 'unsafe-inline' for styles because many libraries and the admin panel use them.
        // We allow common CDNs used in the project.
        $policy = "default-src 'self'; " .
                  "script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com; " .
                  "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; " .
                  "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; " .
                  "img-src 'self' data: https://picsum.photos https://images.unsplash.com; " .
                  "connect-src 'self' " . env('APP_URL', 'http://127.0.0.1:8000') . ";";

        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}
