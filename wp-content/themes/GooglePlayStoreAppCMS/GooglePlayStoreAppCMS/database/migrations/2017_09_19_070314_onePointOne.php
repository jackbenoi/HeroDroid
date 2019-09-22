<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OnePointOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('app_markets'))
        {
            Schema::table('app_markets', function($table)
            {
                $table->string('required_android')->after('developer_link');
                $table->string('installs')->after('required_android');
                $table->longText('custom')->after('installs');
            });
        }

        if(Schema::hasTable('categories'))
        {
            Schema::table('categories', function($table)
            {
                $table->string('icon')->after('is_featured');
            });
        }

        if(Schema::hasTable('users'))
        {
            Schema::table('users', function($table)
            {
                $table->string('social_id')->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        if(Schema::hasTable('app_markets'))
        {
            Schema::table('app_markets', function($table)
            {
                $table->dropColumn('required_android');
                $table->dropColumn('installs');
                $table->dropColumn('custom');
            });
        }

        if(Schema::hasTable('categories'))
        {
            Schema::table('categories', function($table)
            {
                $table->dropColumn('icon');
            });
        }

        if(Schema::hasTable('users'))
        {
            Schema::table('users', function($table)
            {
                $table->dropColumn('social_id');
            });
        }
    }
}
