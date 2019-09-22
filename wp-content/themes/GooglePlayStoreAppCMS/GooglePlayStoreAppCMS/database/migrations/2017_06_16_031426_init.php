<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->string('username')->after('id');
        });

        if(!Schema::hasTable('configurations'))
        {
            Schema::create('configurations', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('group_slug');
                $table->string('key');
                $table->longText('value');
                $table->string('description');
                $table->timestamps();
                
                $table->index('key');
                $table->engine = 'InnoDB';
            });
        }

        if(!Schema::hasTable('statuses'))
        {
            Schema::create('statuses', function($table)
            {
                $table->increments('id');
                $table->string('identifier');
                $table->string('name');
                $table->integer('type');
                $table->engine = 'InnoDB';

                $table->index('identifier');
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('pages'))
        {
            Schema::create('pages', function($table){
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->integer('status_id')->unsigned();
                $table->integer('parent_page_id');
                $table->string('slug');
                $table->string('title');
                $table->longText('content');

                $table->string('seo_title');
                $table->string('seo_keywords');
                $table->string('seo_descriptions');


                $table->integer('position')->default(0);
                $table->integer('is_enabled')->default(1);
                $table->integer('is_demo')->default(0);
                $table->timestamps();

                $table->softDeletes();

                $table->index('slug');
                $table->foreign('user_id')->references('id')->on('users');
                $table->engine = 'InnoDB';
            });
        }

        if(!Schema::hasTable('parent_categories'))
        {
            Schema::create('parent_categories', function($table){
                $table->increments('id');
                $table->string('identifier');
                $table->string('title');
                $table->text('description');

                $table->string('seo_title');
                $table->string('seo_keywords');
                $table->string('seo_descriptions');

                $table->integer('is_enabled')->default(1);
                $table->string('icon');
                $table->integer('is_demo')->default(0);
                
                $table->timestamps();
                $table->index('identifier');
                $table->engine = 'InnoDB';
            });
        }


        if(!Schema::hasTable('categories'))
        {
            Schema::create('categories', function($table){
                $table->increments('id');
                $table->integer('parent_category_id')->unsigned();
                $table->string('identifier');
                $table->string('title');
                $table->text('description');

                $table->string('seo_title');
                $table->string('seo_keywords');
                $table->string('seo_descriptions');

                $table->integer('is_enabled')->default(1);
                $table->integer('is_featured')->default(0);
                $table->bigInteger('views')->default(0);
                $table->integer('is_demo')->default(0);
                
                $table->timestamps();
                $table->index('parent_category_id');
                $table->index('identifier');
                $table->engine = 'InnoDB';
            });
        }

        if(!Schema::hasTable('categoreables'))
        {
            Schema::create('categoreables', function($table)
            {
                $table->integer('category_id');
                $table->integer('categoreable_id');
                $table->string('categoreable_type');
                $table->engine = 'InnoDB';
            });
        }

        if(!Schema::hasTable('tags'))
        {
            Schema::create('tags', function($table){
                $table->increments('id');
                $table->string('identifier');                       
                $table->string('name');                     
                $table->integer('position')->default(0);
                $table->integer('is_enabled')->default(1);
                $table->integer('is_demo')->default(0);
                
                $table->timestamps();
                $table->index('identifier');
                $table->engine = 'InnoDB';
            });
        }

        if(!Schema::hasTable('taggables'))
        {
            Schema::create('taggables', function($table)
            {
                $table->integer('tag_id');
                $table->integer('taggable_id');
                $table->string('taggable_type');
                $table->engine = 'InnoDB';
            });
        }

        if(!Schema::hasTable('uploads'))
        {
            Schema::create('uploads', function($table)
            {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->default(0);
                $table->integer('uploadable_id');
                $table->string('uploadable_type');
                $table->integer('position')->default(0);
                $table->string('file_path');
                $table->string('image_url');
                $table->double('size', 255, 2);
                $table->string('original_name');
                $table->string('upload_type');
                $table->timestamps();
                $table->engine = 'InnoDB';
            });
        }


        if(!Schema::hasTable('advertisement_blocks'))
        {
            Schema::create('advertisement_blocks', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('identifier');
                $table->string('title');
                $table->text('code');
                $table->integer('is_demo')->default(0)->comment="1 means its in demo,  0 if its in live mode";
                
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent();
                $table->engine = 'InnoDB';
            });
        }

        if(!Schema::hasTable('app_markets'))
        {
            Schema::create('app_markets', function($table)
            {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->default(0);

                $table->string('app_id');
                $table->string('title');
                $table->longText('description');
                $table->string('link');
                $table->text('image_url');
                $table->string('ratings');

                $table->string('developer_name');
                $table->string('developer_link');

                $table->string('seo_title');
                $table->string('seo_keywords');
                $table->string('seo_descriptions');

                $table->integer('is_enabled')->default(1);
                $table->integer('is_featured')->default(0);
                $table->integer('is_submitted_app')->default(0);
                $table->integer('is_demo')->default(0);
                
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users');
                $table->engine = 'InnoDB';
            });
        }

        if(!Schema::hasTable('app_market_versions'))
        {
            Schema::create('app_market_versions', function($table)
            {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->default(0);
                $table->integer('app_market_id')->unsigned()->default(0);

                $table->string('app_version');
                $table->string('signature');
                $table->string('sha_1');
                $table->text('description');

                $table->string('file_path');
                $table->double('size', 255, 2);
                $table->string('original_name');

                $table->string('app_link')->nullable();
                $table->integer('is_link')->default(0);

                $table->integer('position')->default(0);
                
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('app_market_id')->references('id')->on('app_markets');
                
                $table->index('app_version');
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
        if (Schema::hasTable('pages'))
        {
            Schema::table('pages', function(Blueprint $table)
            {
                $table->dropForeign('pages_user_id_foreign');
            });
            Schema::dropIfExists('pages');
        }


        if (Schema::hasTable('app_market_versions'))
        {
            Schema::table('app_market_versions', function(Blueprint $table)
            {
                $table->dropForeign('app_market_versions_user_id_foreign');
                $table->dropForeign('app_market_versions_app_market_id_foreign');
            });
            Schema::dropIfExists('app_market_versions');
        }

        if (Schema::hasTable('app_markets'))
        {
            Schema::table('app_markets', function(Blueprint $table)
            {
                $table->dropForeign('app_markets_user_id_foreign');
            });
            Schema::dropIfExists('app_markets');
        }

        Schema::dropIfExists('configurations');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('parent_categories');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('categoreables');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('uploads');
    }
}
