<?php

/**
 * App\Http\Middleware\TrackVisitor
 *
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category TrackVisitor
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */


namespace App\Http\Middleware;

use Closure;
use Event;

class TrackVisitor
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
        Event::fire('view.throttle');
        return $next($request);
    }
}
