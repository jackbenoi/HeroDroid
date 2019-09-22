<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(InitTableSeeder::class);
        $this->call(ConfigurationSeeder::class);
        $this->call(UpdateOnePointOneSeeder::class);
        $this->call(UpdateOnePointTwoSeeder::class);
        $this->call(UpdateOnePointThreeSeeder::class);
    }
}
