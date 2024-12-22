<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RequestsLogMiddleware
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
        // Calculate start time
        $startTime = microtime(true);

        // Proceed the request
        $response = $next($request);

        // Calculate end time
        $endTime = microtime(true);

        // Calculate response time in seconds
        $responseTime = round($endTime - $startTime, 4);

        // Log details
        $logData = [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'payload' => $request->all(),
            'responseTime' => $responseTime,
        ];

        Log::channel('logrequests')->info('Request', $logData);

        return $response;
    }
}
