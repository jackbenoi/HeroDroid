<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAppmarketsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(Schema::hasTable('app_markets'))
        {
            Schema::table('app_markets', function($table)
            {
                $table->string('ratings_total')->after('ratings');
                $table->string('published_date')->after('is_demo');
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
                $table->dropColumn('ratings_total');
                $table->dropColumn('published_date');
            });
        }
    }
}
