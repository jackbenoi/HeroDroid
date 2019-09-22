<?php

/**
 * UpdateOnePointOneSeeder
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

class UpdateOnePointOneSeeder extends Seeder
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
                  'key'           => 'cms_upload_logo',
                  'value'         => '',
                  'group_slug'  => 'general_informations',
                ],
                [
                  'key'           => 'enable_rtl_support',
                  'value'         => 'no',
                  'description'  => 'Ex. "yes" to enable, no = disable',
                  'group_slug'  => 'general_informations',
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