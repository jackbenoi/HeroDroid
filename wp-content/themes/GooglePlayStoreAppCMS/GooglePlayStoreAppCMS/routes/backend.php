<?php

/**
 * Backend Routes
 * 
 * @package   Routes
 * @author    Anthony Pillos <dev.anthonypillos@gmail.com>
 * @license   commercial http://anthonypillos.com
 * @link      http://anthonypillos.com
 * @copyright Copyright (c) 2017 Anthony Pillos.
 * @version   v1
 */


Route::group(array('prefix' => 'appmarket-admin','namespace' => 'Backend'), function() {

    Route::group( ['middleware' => ['xssprotection']], function() {
        Route::controller( '/admin-accounts', 'UserController',
            [
                'getIndex'          => 'backend.login',
                'postAuthenticate'  => 'backend.authenticate',
                'getLogout'         => 'backend.logout',
                'getProfile'        => 'backend.profile',
                'postUpdateProfile' => 'backend.profile.update',
            ]
        );
    });
        
    Route::group( ['middleware' => ['sentineladmin']], function() {

        // All Resources
        Route::group(array('prefix' => '/resource','namespace' => 'Resources'), function() {
            Route::resource('user', 'User');
            Route::resource('configuration', 'Configuration');
            Route::resource('page', 'Page');
            Route::resource('category', 'Category');
            Route::resource('parent-category', 'ParentCategory');
            Route::resource('appmarket', 'AppMarket');
            Route::resource('appmarket-update', 'AppMarket@customUpdate');
            Route::resource('appmarket-apk-update', 'AppMarket@apkVersionUpdate');
            
            Route::resource('ads', 'AdsManagement');
            Route::resource('ads-save', 'AdsManagement@saveAdsPlacement');
            Route::resource('page-bulk-deletion', 'Page@destroyMultiplePages');
            Route::resource('validate-download-api', 'Configuration@validateApi');
            
        });

        Route::controller('translations', 'TranslateController',[
                'getIndex'  => 'backend.translation'
        ]);

         
         
        Route::group( ['middleware' => ['xssprotection']], function() {


            Route::controller( '/general', 'SettingController',
                [
                    'getIndex'              => 'backend.settings.general',
                    'getAdsManagement'      => 'backend.setting.adsmgt',
                    'getFeaturedApp'        => 'backend.setting.featuredApp',
                    'getUserManagement'     => 'backend.setting.usermgt',
                    'getUserDetail'         => 'backend.setting.usermgt.detail',


                    'postAddToFeaturedItem'  => 'backend.setting.addToFeaturedItem',
                    'postRemoveFeaturedItem' => 'backend.setting.remove.featured.item',
                    'postUploadLogo'         => 'backend.setting.upload.logo',
                ]
            ); 

            

            Route::controller( '/generate-sitemap', 'SitemapsController',
                [
                    'getIndex'                         => 'backend.sitemap.index',
                    'postSitemapAppCollections'        => 'backend.sitemap.apps',
                    'postSitemapCategoriesCollections' => 'backend.sitemap.category',
                    'postSitemapClear'                 => 'backend.sitemap.clear',
                ]
            );

            Route::controller( '/pages', 'PageController',
                [
                    'getIndex'  => 'backend.pages.index',
                    'getDetail'  => 'backend.pages.detail'
                ]
            );

            Route::controller( '/apps', 'AppsController',
                [
                    'getIndex'              => 'backend.apps.index',
                    'getDetail'             => 'backend.apps.detail',
                    'getAppMarket'          => 'backend.apps.market',
                    'postSearchGooglePlay'  => 'backend.apps.search',
                    'postImportApp'         => 'backend.apps.import',
                    'postGooglePlayDetail'  => 'backend.apps.android.detail',
                    'postRemoveUpload'      => 'backend.apps.remove.upload',
                    'postRemoveApk'         => 'backend.apps.remove.apk',
                ]
            ); 
            
            Route::controller( '/category', 'CategoryController',
                [
                    'getIndex'             => 'backend.category.index',
                    'getDetail'            => 'backend.category.detail',
                    'getSubCategory'       => 'backend.sub.category.index',
                    'getSubCategoryDetail' => 'backend.sub.category.detail'
                ]
            );

            Route::controller( '/submitted-apps', 'SubmittedAppsController',
                [
                    'getIndex'             => 'backend.submitted-apps.index'
                ]
            );

            
            Route::controller( '/', 'IndexController',
                [
                    'getIndex'  => 'backend.index.index',
                    'getClearCache'  => 'backend.index.cache-clear',
                    'getClearLogs'  => 'backend.index.clear-logs',
                    'getClearViews'  => 'backend.index.clear-views',
                    'getClearAllSessions'  => 'backend.index.clear-session',
                    'getTranslationReset'  => 'backend.index.translation-reset',
                ]
            );
        });
    });
});