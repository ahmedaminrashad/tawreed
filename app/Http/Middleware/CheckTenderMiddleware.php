<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTenderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tender = $request->route('tender');

        if ($tender) {
            if ($request->route()->getName() != 'tenders.show') {
                if (auth()->id() != $tender->user_id)
                    abort(403);
                if ($tender->isPublished())
                    abort(403);
            }
        }

        return $next($request);
    }
}
