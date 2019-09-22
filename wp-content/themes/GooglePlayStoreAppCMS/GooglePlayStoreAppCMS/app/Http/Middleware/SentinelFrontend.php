<?php

/**
 * App\Http\Middleware\SentinelFrontend
 * 
 * Middleware for checking the current user login
 *
 * @package APPMARKETCMS
 * @category SentinelFrontend
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelFrontend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Sentinel::getUser()) 
        {           
          return $next($request);           
        }
        $url = route('frontend.login').'?return-url=' . $request->url();
        return redirect( $url );
    }
}
