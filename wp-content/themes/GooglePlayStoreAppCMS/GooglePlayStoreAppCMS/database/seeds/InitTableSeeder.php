<?php

/**
 * InitTableSeeder
 *
 * @package APPMARKETCMS
 * @category InitTableSeeder
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use Illuminate\Database\Seeder;

class InitTableSeeder extends Seeder
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
            
            $parentCategory = app('Lib\Repositories\ParentCategoryRepositoryEloquent');
            $category       = app('Lib\Repositories\CategoryRepositoryEloquent');

            $parentCategoriesArr = [
                'App',
                'Game',
                'Theme'
            ];
            foreach ($parentCategoriesArr as $key => $cat) {
                $identifier = str_slug($cat);
                $arr = $this->defaultArr($identifier,$cat);

                $parentModel = $parentCategory->updateOrCreate(['identifier' => $identifier],$arr);


                
                if($identifier == 'app')
                {   
                    $app   = $this->appCategory();
                    $this->loopCategory($app,$category,$parentModel);
                }

                else if($identifier == 'game')
                {   
                    $game  = $this->gameCategory();
                    $this->loopCategory($game,$category,$parentModel);
                }

                else if($identifier == 'theme')
                {   
                    $theme = $this->themeCategory();
                    $this->loopCategory($theme,$category,$parentModel);
                }

            }


            $this->loadDefaultAds();

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
        });
    }

    private function gameCategory()
    {
        return [
            'Action',
            'Adventure',
            'Arcade',
            'Board',
            'Card',
            'Casino',
            'Casual',
            'Educational',
            'Music',
            'Puzzle',
            'Racing',
            'Role Playing',
            'Simulation',
            'Sports',
            'Strategy',
            'Trivia',
            'Word',
            'Family'
        ];
    }

    private function appCategory()
    {
        return [
            'Business',
            'Comics',
            'Communication',
            'Dating',
            'Education',
            'Entertainment',
            'Events',
            'Finance',
            'Food & Drink',
            'Health & Fitness',
            'House & Home',
            'Libraries & Demo',
            'Lifestyle',
            'Maps & Navigation',
            'Medical',
            'Music & Audio',
            'News & Magazines',
            'Parenting',
            'Personalization',
            'Photography',
            'Productivity',
            'Shopping',
            'Social',
            'Sports',
            'Tools',
            'Travel & Local',
            'Video Players & Editors',
            'Weather',
        ];
        
    }

    private function themeCategory()
    {
        return [
            'Live Wallpaper',
            'Go Theme',
            '360 Theme',
            'MI Theme'
        ];
    }

    private function defaultArr($identifier,$cat)
    {
        return [
            'identifier'       => $identifier,
            'title'            => $cat,
            'description'      => $cat,
            'seo_title'        => $cat,
            'seo_keywords'     => $identifier,
            'seo_descriptions' => $cat,
            'is_enabled'       => 1
        ];
    }

    private function loopCategory($data,$categoryModel,$parentModel)
    {
        foreach ($data as $key => $cat) {

            $identifier = str_slug($cat);
            $arr        = $this->defaultArr($identifier,$cat);
            $arr['parent_category_id'] = $parentModel->id;

            $categoryModel->updateOrCreate(['identifier' => $identifier],$arr);
        }
    }


    private function loadDefaultAds()
    {

        $ads = app('Lib\Entities\AdvertisementBlock');

        $data = [
            'sidebar'     => 'Sidebar Ads',
            'leaderboard' => 'LeaderBoard in All Pages',
            'ads_content' => 'Ads Between Contents',
            'footer_ads'  => 'Footer Ads Index Page Only',
        ];

        foreach ($data as $key => $item) {

            $itemArr = [

                'identifier' => $key,
                'title'      => $item,
                'code'       => 'insert code here',
            ];
            $ads->updateOrCreate(['identifier' => $key],$itemArr);
        }
    }

}