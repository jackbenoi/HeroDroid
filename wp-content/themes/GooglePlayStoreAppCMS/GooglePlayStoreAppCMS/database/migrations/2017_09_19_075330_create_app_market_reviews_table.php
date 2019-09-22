<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppMarketReviewsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		if(!Schema::hasTable('app_market_reviews'))
        {
			Schema::create('app_market_reviews', function(Blueprint $table) {
	            $table->increments('id');

	            $table->integer('user_id')->unsigned();
	            $table->integer('app_market_id')->unsigned();
	            $table->string('author_name');
	            $table->string('published_at');
	            $table->longText('comments');
	            $table->text('image_url');
	            $table->integer('is_google_play')->default(1);

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
		Schema::dropIfExists('app_market_reviews');
	}

}
