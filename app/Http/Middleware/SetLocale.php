<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Set English as default for dashboard routes
        if ($request->is('dashboard*') || $request->is('admin*')) {
            App::setLocale('en');
            return $next($request);
        }

        // For other routes, use session locale or default
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        
        return $next($request);
    }
} 