<?php

/**
 * App\Http\Middleware\SentinelAdminCheck
 * 
 * Middleware for checking the current user login
 *
 * @package APPMARKETCMS
 * @category SentinelAdminCheck
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */


namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelAdminCheck
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
        $user = Sentinel::getUser();
        if ($user) 
        {   
            if ( $user->hasAccess('can_login_admin') )
                return $next($request);
        }
        $url = route('backend.login').'?return-url=' . $request->url();
        $request->session()->flash('error-message', 'Unauthorized user login.');
        return redirect( $url );
    }
}
