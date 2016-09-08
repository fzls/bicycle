<?php

namespace App\Http\Middleware;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Closure;
use GuzzleHttp\Tests\Psr7\Str;
use Illuminate\Support\Facades\Log;

class LogMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next) {
        \Log::notice(sprintf('ip : %s visited %s', $request->ip(), $request->fullUrl()));
        /*if come from outside, report bug*/
        if (preg_match('/rands|www/',$request->fullUrl())) {
            Bugsnag::notifyError('Strange url', $request->fullUrl());
        }
        return $next($request);
    }
}
