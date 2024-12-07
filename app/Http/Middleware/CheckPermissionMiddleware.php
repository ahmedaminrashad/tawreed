<?php

namespace App\Http\Middleware;

use Closure;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeSegement = $request->segments()[0];
        $actionSegement = 'list';

        if (isset($request->segments()[1])) {
            $routeSegement = $request->segments()[1];
        }

        if (isset($request->segments()[2])) {
            if (!is_numeric($request->segments()[2])) {
                $actionSegement = $request->segments()[2];
            } else {
                if ($request->method() == 'PUT') {
                    $actionSegement = 'edit';
                } else if ($request->method() == 'GET') {
                    $actionSegement = 'show';
                } else if ($request->method() == 'DELETE') {
                    $actionSegement = 'delete';
                } else {
                    $actionSegement = $request->segments()[3];
                }
            }
        }

        if (!auth()->user()->hasPermissionTo($actionSegement . '-' . $routeSegement)) {
            abort(401);
        }

        return $next($request);
    }
}
