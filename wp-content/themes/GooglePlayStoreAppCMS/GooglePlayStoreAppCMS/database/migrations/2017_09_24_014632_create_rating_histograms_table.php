<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingHistogramsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('rating_histograms'))
        {
			Schema::create('rating_histograms', function(Blueprint $table) {
	            $table->increments('id');
	            $table->integer('app_market_id')->unsigned();
	            $table->integer('num');
	            $table->string('bar_length');
	            $table->string('bar_number');

	            $table->timestamps();
	            $table->foreign('app_market_id')->references('id')->on('app_markets');
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

		if (Schema::hasTable('rating_histograms'))
        {
            Schema::table('rating_histograms', function(Blueprint $table)
            {
                $table->dropForeign('rating_histograms_app_market_id_foreign');
            });
            Schema::dropIfExists('rating_histograms');
        }
	}

}
