<?php

/**
 * UpdateOnePointTwoSeeder
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category IndexController
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use Illuminate\Database\Seeder;

class UpdateOnePointTwoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	DB::transaction(function()
        {


        	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $this->command->info('Starting to seed configuration data');
	        $configuraton = app('Lib\Repositories\ConfigurationRepositoryEloquent');
	        $configArray = [
	         
                [
                  'key'           => 'auto_activate_user_registration',
                  'value'         => 'yes',
                  'description'  => 'Ex. "yes" to auto activate, no = it will send email for activation before login.',
                  'group_slug'  => 'general_informations',
                ],
                [
                  'key'           => 'site_verification',
                  'value'         => '',
                  'description'  => 'Paste your verification code here.',
                  'group_slug'  => 'google_webmaster_tools',
                ],
                [
                  'key'           => 'site_analytics',
                  'value'         => '',
                  'description'  => 'Paste your tracker code here. Ex. UA-XXXXX-Y',
                  'group_slug'  => 'google_webmaster_tools',
                ],
                [
                  'key'           => 'custom_css',
                  'value'         => '',
                  'description'  => 'Paste your custom css here',
                  'group_slug'  => 'custom_css_and_js',
                ],
                [
                  'key'           => 'custom_js',
                  'value'         => '',
                  'description'  => 'Paste your custom js here',
                  'group_slug'  => 'custom_css_and_js',
                ],

                [
                  'key'           => 'recaptcha_site_key',
                  'value'         => '',
                  'description'  => 'Paste your site key here.',
                  'group_slug'  => 'recaptcha_api_key',
                ],
                [
                  'key'           => 'recaptcha_secret_key',
                  'value'         => '',
                  'description'  => 'Paste your secret key here.',
                  'group_slug'  => 'recaptcha_api_key',
                ],
                [
                  'key'           => 'enable_recaptcha',
                  'value'         => 'no',
                  'description'  => 'Ex. "no" to deactivate, "yes" = to enabled,please visit get your key: https://www.google.com/recaptcha/intro/android.html',
                  'group_slug'  => 'recaptcha_api_key',
                ],
                [
                  'key'           => 'purchase_code',
                  'value'         => '',
                  'description'  => 'Paste your purchase code here.',
                  'group_slug'  => 'apk_download_via_api',
                ]


                
             

	        ];
	        foreach ($configArray as $key => $config) {

	        	$configuraton->updateOrCreate( ['key' => $config['key'] ], $config);
	        }
	        $this->command->info('Configuration Data Seeded!');

	        
	        DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
		});
        
    }
}