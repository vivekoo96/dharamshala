<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class SeoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Fetch global settings
        $siteName = Setting::get('site_name', 'Dharamshala Connect');
        $siteDesc = Setting::get('site_description', 'Affordable and comfortable stays for pilgrims and travelers.');

        // Determine page title based on route name (fallback logic)
        $route = $request->route()?->getName();
        $pageTitle = $siteName;

        switch ($route) {
            case 'home':
                $pageTitle = "Home | $siteName";
                break;
            case 'booking.online':
                $pageTitle = "Book Your Stay | $siteName";
                break;
            case 'login':
                $pageTitle = "Staff Login | $siteName";
                break;
            default:
                $pageTitle = $siteName;
        }

        // Share data with all views
        View::share('seo_title', $pageTitle);
        View::share('seo_description', $siteDesc);
        View::share('seo_site_name', $siteName);

        return $next($request);
    }
}
