<?php

/**
 * App\Http\Middleware\Locale
 * 
 * Middleware for localization
 *
 * @package APPMARKETCMS
 * @category Locale
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

namespace App\Http\Middleware;

use Closure;
use Cache;
use Barryvdh\TranslationManager\Models\Translation;

class Locale
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
        
        $dbLocale = Cache::remember('locale_db', 1500, function()  {
            return Translation::groupBy('locale')->lists('locale')->toArray();
        });

        //Set the default locale as the first one.
        $locales = array_filter(array_merge(array(config('app.locale')), $dbLocale));
        $locales =  array_unique($locales);

        $raw_locale = session('locale');

        if (in_array($raw_locale,$locales)) {
           $locale = $raw_locale;
        }
        else 
            $locale = config('app.locale');

        app()->setLocale($locale);
        return $next($request);
    }
}
