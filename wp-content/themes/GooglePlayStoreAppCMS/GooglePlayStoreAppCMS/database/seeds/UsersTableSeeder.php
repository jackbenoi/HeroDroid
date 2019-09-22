<?php

/**
 * UsersTableSeeder
 *
 * @package APPMARKETCMS
 * @category UsersTableSeeder
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
            $this->command->info('Starting to seed users table');
	        DB::table('users')->truncate();
		    DB::table('role_users')->truncate();
		    DB::table('roles')->truncate();
			$createGroup = [
		                        ['name' => 'elite',
		                        'slug'	=> 'elite',
		                        'permissions' => ['superadmin' => true,'admin' => true,'can_login_admin' => true]
		                        ],
		                        ['name' => 'administrator',
		                        'slug'	=> 'administrator',
		                        'permissions' => ['admin' => true,'can_login_admin' => true]
		                        ],
		                        ['name' => 'moderator',
		                        'slug'	=> 'moderator',
		                        'permissions' => ['can_login_admin' => true]
		                        ],
		                        ['name' => 'normal',
		                        'slug'	=> 'normal',
		                        'permissions' => ['can_login_admin' => false]
		                        ],
		                        ['name' 	  => 'developers',
		                        'slug'		  => 'developers',
		                        'permissions' => ['can_login_admin' => false,'is_developer' => true]
		                        ],
		                        ['name' => 'guest',
		                        'slug'	=> 'guest'
		                        ]
		                ];

		    foreach ($createGroup as $key => $groupname) {
		        Sentinel::getRoleRepository()->createModel()->create( $groupname );
		    }

		    $createDefaultUser = [
			                        ['email'    => 'admin@demo.com',
			                        'username'  => 'admin',
			                        'password'  => 'admin',
			                        'first_name'=> 'Admin',
			                        'last_name' => 'Account',
			                        'permissions' => ['can_login_admin' => true]
			                        ],
			                        ['elite_user' => ['email'   => 'elite@demo.com',
			                                        'password'  => 'elite',
			                                        'first_name'=> 'Elite',
			                                        'last_name' => 'Account',
			                                        'username'	=> 'elite',
			                                        'permissions' =>['can_login_admin' => true,'superadmin' => true]
			                                        ]
			                        ],
			                        ['developer' => ['email'   => 'developer@demo.com',
			                                        'password'  => 'developer',
			                                        'first_name'=> 'Developer',
			                                        'last_name' => 'Account',
			                                        'username'	=> 'developer',
			                                        'permissions' =>['can_login_admin' => false,'is_developer' => true]
			                                        ]
			                        ],
			                        ['normal' =>['email'    => 'normal@demo.com',
			                                    'password'  => 'normal',
			                                    'first_name'=> 'Normal',
			                                    'last_name' => 'Account',
			                                    'username'	=> 'normal',
			                                    'permissions' =>['can_login_admin' => false]
			                                    ]
			                        ]
			                ];
		    $defaultGroupID = 2;
	        foreach ($createDefaultUser as $key => $credentials) {
	                if( isset($credentials['elite_user']) )
	                {
	                        // an elite user is set to 1.
	                        $defaultGroupID = 1;
	                        $credentials = $credentials['elite_user'];
	                }
	                else if( isset($credentials['normal']) )
	                {
	                        $defaultGroupID = 4;
	                        $credentials = $credentials['normal'];
	                }
	                else if( isset($credentials['developer']) )
	                {
	                        // developer
	                        $defaultGroupID = 5;
	                        $credentials = $credentials['developer'];
	                }

	                $user = Sentinel::registerAndActivate($credentials);

	                $role = Sentinel::findRoleById( $defaultGroupID );
					$role->users()->attach($user);
	        }

	        $this->command->info('Users Table Seeded!');

	        DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
		});
        
    }
}