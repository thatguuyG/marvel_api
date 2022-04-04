<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CachedResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Cache::has($this->cacheKey($request))) {
            return response (Cache::get($this->cacheKey($request)));
        }
        return $next($request);
    }


    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {

        if (Cache::has($this->cacheKey($request))) {
            return;
        }

        Cache::put($this->cacheKey($request), $response->getContent(), 100);
    }

    private function cacheKey($request): string
    {
        return md5($request->fullUrl());
    }
}
