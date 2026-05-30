<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

// 全 Blade ビューに $settings を共有する。
// nav と footer のパーシャルがこれを参照する。
class ShareSiteSettings
{
    public function handle(Request $request, Closure $next): Response
    {
        View::share('settings', SiteSetting::current());

        return $next($request);
    }
}
