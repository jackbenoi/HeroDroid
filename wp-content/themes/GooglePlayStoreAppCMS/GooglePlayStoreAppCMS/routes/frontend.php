<?php

/**
 * Frontend Routes
 * 
 * @package   Routes
 * @author    Anthony Pillos <dev.anthonypillos@gmail.com>
 * @license   commercial http://anthonypillos.com
 * @link      http://anthonypillos.com
 * @copyright Copyright (c) 2017 Anthony Pillos.
 * @version   v1
 */


// RUN TESTMODULE HERE, if necessary.
use Carbon\Carbon;

// Route::group(['domain' => '{developer}.appmarketcms.dev'], function () {

//     Route::get('/detail/{appid}', function ($developer,$appid) {
        
//         pre( $appid );
//         exit;
//     });

//     Route::get('/', function ($developer) {

//         pre( $developer );
//         exit;
//     });
// });


Route::get('demo-only', function () {

    // pre( formattedFileSize(file_upload_max_size()) );
    exit;
});

Route::group(['prefix' => '/','namespace' => 'Frontend','middleware' => 'xssprotection'], function() {

    Route::group(['prefix' => 'auth'], function() {

        Route::controller( '/', 'UserController',
            [
                'getFacebook'   => 'frontend.auth.fb',
                'getTwitter'    => 'frontend.auth.twitter',
                'getGooglePlus' => 'frontend.auth.gplus',
            ]
        );
    });


    // Route::get('setlocale/{locale}', function ($locale) {

    //   if (in_array($locale, \Config::get('app.locales'))) {
    //         Session::put('locale', $locale);
    //   }
    //   return redirect()->back();
    // });

    Route::controller( '/accounts', 'UserController',
        [
            'getIndex'             => 'frontend.login',
            'postAuthenticate'     => 'frontend.authenticate',
            'getLogout'            => 'frontend.logout',
            'getProfile'           => 'frontend.profile',
            'postUpdateProfile'    => 'frontend.profile.update',
            'getRegistration'      => 'frontend.register',
            'postRegistration'     => 'frontend.register.create',
            'getActivationAccount' => 'frontend.activation',

            'getForgotPassword'     => 'frontend.forgot.password',
            'postForgotPassword'    => 'frontend.forgot.resend',
            'getResetPassword'      => 'frontend.reset.password',
            'postResetPassword'      => 'frontend.reset.change',
        ]
    );


    Route::group( ['middleware' => ['sentinelfrontend']], function() {

        // All Resources
        Route::group(array('prefix' => '/resource','namespace' => 'Resources'), function() {
           
            Route::resource('appmarket', 'AppMarket');
            Route::resource('appmarket-update', 'AppMarket@customUpdate');
            Route::resource('appmarket-apk-update', 'AppMarket@apkVersionUpdate');
        });
        
        Route::controller( 'submit-your-apps', 'SubmitAppController',
            [
                'getIndex'       => 'frontend.submitapps.index',
                'getLists'       => 'frontend.submitapps.list',
                'getDetail'      => 'frontend.submitapps.detail',
                'postDetailInfo' => 'frontend.submitapps.details',
            ]
        );
    });

    Route::controller( '/', 'IndexController',
        [
            'getIndex'           => 'frontend.index.index',
            'getEditorsPick'     => 'frontend.index.editors-pick',
            'getNewestApp'       => 'frontend.index.newest-app',
            'getDetail'          => 'frontend.index.detail',
            'getReportApp'       => 'frontend.index.report-app',
            'getAndroidCategory' => 'frontend.index.category',
            'getPage'            => 'frontend.index.page',
            'getCategory'        => 'frontend.index.parent.category',
            'getContactUs'       => 'frontend.contact',
            'getSearch'          => 'frontend.search',
            'getDownloadApp'     => 'frontend.download',
            'getDownloadLink'    => 'frontend.force.download',
            'getRss'             => 'frontend.rss',
            'getTranslate'       => 'frontend.translate',


            'postContactUs'     => 'frontend.contact-post',
            'postReportApp'     => 'fd.report.app',
            'postDownloadAppApi' => 'frontend.download.api'

        ]
    );
});

