<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale is in session
        if ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
        } else {
            // Default to English
            $locale = 'en';
        }

        // Set application locale
        app()->setLocale($locale);

        return $next($request);
    }
}
