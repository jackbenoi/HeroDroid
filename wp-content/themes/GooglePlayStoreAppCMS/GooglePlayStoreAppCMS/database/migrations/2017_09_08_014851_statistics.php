<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Statistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('statistics'))
        {
            Schema::create('statistics', function($table){
                $table->increments('id');
                $table->integer('statisticable_id');
                $table->string('statisticable_type');
                $table->double('views');
                $table->timestamps();

                $table->engine = 'InnoDB';
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
        Schema::dropIfExists('statistics');
    }
}
