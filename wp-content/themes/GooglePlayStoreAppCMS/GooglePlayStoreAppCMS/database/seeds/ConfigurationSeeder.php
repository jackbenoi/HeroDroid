<?php

/**
 * ConfigurationSeeder
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

class ConfigurationSeeder extends Seeder
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
              'key'           => 'cms_name',
              'value'         => 'Google Play Store Apps By Anthony Pillos',
              'group_slug'  => 'general_informations',
            ],
            [
              'key'           => 'cms_description',
              'value'         => 'Welcome to my script,download it via codecanyon.',
              'group_slug'  => 'general_informations',
            ],
            [
              'key'           => 'set_your_locale',
              'value'         => 'en',
              'description'  => 'Ex. "en" for english language',
              'group_slug'  => 'general_informations',
            ],
            [
              'key'           => 'your_country_code',
              'value'         => 'us',
              'description'  => 'Ex. "us" for United States',
              'group_slug'    => 'general_informations',
            ],
            [
              'key'           => 'contact_email',
              'value'         => 'appmarketcms@gmail.com',
              'group_slug'  => 'general_informations',
            ],

            [
              'key'           => 'enable_submit_apps',
              'value'         => '1',
              'description'  => '1 = Enable Submit Apps from users, 0 = Disable submit apps',
              'group_slug'  => 'general_informations',
            ],
            [
              'key'           => 'enable_https',
              'value'         => 0,
              'group_slug'  => 'general_informations',
              'description'  => '1 = Enable HTTPS, 0 = Disable HTTPS',
             ],
             [
              'key'           => 'disqus_short_name',
              'value'         => 'google-play-store-apps',
              'group_slug'    => 'general_informations',
             ],
            [
              'key'           => 'addthis_code',
              'value'         => 'ra-59b1ff7b9a536c37',
              'group_slug'    => 'general_informations',
             ],  

            [
              'key'     => 'site_title',
              'value'   => 'Google Play Store Apps By Anthony Pillos',
              'group_slug'  => 'seo_configurations',
            ],
            [
              'key'     => 'site_description',
              'value'   => 'Google Play Store Apps By Anthony Pillos',
              'group_slug'  => 'seo_configurations',
            ],
            [
              'key'           => 'site_keywords',
              'value'         => 'google,play,store,apps,by,anthony pillos',
              'group_slug'  => 'seo_configurations',
             ],
             [
              'key'           => 'site_author',
              'value'         => 'Anthony Pillos',
              'group_slug'  => 'seo_configurations',
             ],
            [
              'key'           => 'site_author_link',
              'value'         => 'http://anthonypillos.com',
              'group_slug'  => 'seo_configurations',
             ],
             
             [
              'key'           => 'facebook',
              'value'         => '#',
              'group_slug'  => 'social_networks',
             ],
             [
              'key'           => 'twitter',
              'value'         => '#',
              'group_slug'  => 'social_networks',
             ],
             [
              'key'           => 'instagram',
              'value'         => '#',
              'group_slug'  => 'social_networks',
             ],
             [
              'key'           => 'pinterest',
              'value'         => '#',
              'group_slug'  => 'social_networks',
             ],
             [
              'key'           => 'google',
              'value'         => '#',
              'group_slug'  => 'social_networks',
             ],


             [
              'key'           => 'site_analytics',
              'value'         => '',
              'group_slug'  => 'google_webmaster_tools',
             ],

            [
              'key'           => 'site_verification',
              'value'         => '',
              'group_slug'  => 'google_webmaster_tools',
             ],
             
	        ];
	        foreach ($configArray as $key => $config) {

	        	$configuraton->updateOrCreate( ['key' => $config['key'] ], $config);
	        }
	        $this->command->info('Configuration Data Seeded!');

	        $status = app('Lib\Repositories\StatusRepositoryEloquent');
	        $statArray = [

	        	[
	        		'name' 			=> 'Pending',
	        		'identifier' 	=> 'pending',
	        		'type' 			=> 1,
	        	],
	        	[
	        		'name' 			=> 'Draft',
	        		'identifier' 	=> 'draft',
	        		'type' 			=> 1,
	        	],
	        	[
	        		'name' 			=> 'Published',
	        		'identifier' 	=> 'published',
	        		'type' 			=> 1,
	        	],
	        	[
	        		'name' 			=> 'Inactive',
	        		'identifier' 	=> 'inactive',
	        		'type' 			=> 1,
	        	]
	        ];
	        foreach ($statArray as $key => $stat) {

	        	$status->updateOrCreate( ['identifier' => $stat['identifier'] ], $stat);
	        }

	        
	        DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
		});
        
    }
}