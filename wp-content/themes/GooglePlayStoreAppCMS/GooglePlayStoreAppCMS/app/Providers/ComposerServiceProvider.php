<?php

namespace App\Providers;

/**
 * App\Providers\ComposerServiceProvider
 * 
 * _View Composer, that handle common views objects that we set.
 *
 * @package APPMARKETCMS
 * @category ComposerServiceProvider
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
       
        // common for all views
        view()->composer(
            '*', 'Lib\ViewComposers\Common'
        );

        view()->composer(
            'backend.*', 'Lib\ViewComposers\Backend'
        );

        view()->composer(
            'frontend.*', 'Lib\ViewComposers\Frontend'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}