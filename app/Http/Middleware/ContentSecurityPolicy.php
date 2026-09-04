<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $csp = "default-src 'self'; " .
               "script-src 'self' https://cdn.jsdelivr.net; " .
               "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; " .
               "font-src 'self' https://cdn.jsdelivr.net; " .
               "img-src 'self' data:; " .
               "connect-src 'self'; " .
               "frame-ancestors 'self'; " .
               "form-action 'self'; " .
               "base-uri 'self';";

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        return $response;
    }
}