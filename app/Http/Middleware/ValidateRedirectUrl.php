<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateRedirectUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            $targetUrl = $response->getTargetUrl();
            $parsedUrl = parse_url($targetUrl);

            if (isset($parsedUrl['host']) && $parsedUrl['host'] !== $request->getHost()) {
                $allowedHosts = [
                    $request->getHost(),
                ];

                if (! in_array($parsedUrl['host'], $allowedHosts, true)) {
                    abort(400, 'Redirección a dominio externo no permitida.');
                }
            }
        }

        return $response;
    }
}