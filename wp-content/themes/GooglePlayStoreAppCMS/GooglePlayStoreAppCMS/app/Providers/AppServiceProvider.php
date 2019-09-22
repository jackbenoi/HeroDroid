<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if(\DB::connection()->getDatabaseName())
        {
            if( isset($config['enable_https'] ) && $config['enable_https'] != 0)
                \URL::forceSchema('https');


            Validator::extend(
                  'recaptcha',
                  'Lib\\Validators\\ReCaptcha@validate'
           );
        }
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
