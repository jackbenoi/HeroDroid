<?php

namespace App\Http\Controllers\Backend;

/**
 * App\Http\Controllers\Backend\SitemapsController
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category SitemapsController
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use App\Http\Controllers\Controller;
use Exception;
use Lib\Exceptions\SystemError;
use Lib\Traits\ResponseTrait;
use Storage;
use File;
use Carbon\Carbon;


class SitemapsController extends Controller
{

    use ResponseTrait;

 	/**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    */
    public function __construct()
    {
        
    }

 	/**
    * getIndex()
    * 
    *
    * @return void
    * @access  public
    */
    public function getIndex()
    {

        if(!File::exists('sitemap'))
             Storage::disk('sitemap')->makeDirectory('sitemap');

        $files = File::directories('sitemap');

        $sitemapArray = [];
        if(count($files) > 0)
        {
            foreach ($files as $key => $item) {
               
               
                list($index,$name) = explode('/', $item);

                if(!isset($sitemapArray[$name]))
                    $sitemapArray[$name] = [];

                $sitemapArray[$name] = [
                    'url' => url($item.'.xml'),
                    'sitemaps' => []
                ];
                $subSitemaps = File::allFiles('sitemap/'.$name);
                foreach ($subSitemaps as $key => $item) {
                    $sitemapArray[$name]['sitemaps'][] = url($item->getPathname());
                    sort($sitemapArray[$name]['sitemaps'],SORT_NATURAL | SORT_FLAG_CASE);
                }
            }
        }

        return view('backend.settings.sitemap.index')->with(['is_settings' => true,'sitemapArray' => $sitemapArray]);
    }


    /**
    * postSitemapAppCollections()
    * 
    *
    * @return void
    * @access  public
    */
    public function postSitemapAppCollections()
    {
        // create sitemap
        $apps = app("sitemap");

        // // set cache
        $apps->setCache('appmarketcms.sitemap-apps', 3600);

        $appMarket = app('Lib\Repositories\AppMarketRepositoryEloquent');


        $counter        = 0;
        $sitemapCounter = 0;

        Storage::disk('sitemap')->makeDirectory('sitemap/apps');

        $collections = $appMarket->generateSitemap()->get();
        foreach ($collections as $m) {

            $sitemapName = 'sitemap/apps/index-'.$sitemapCounter;
            if ($counter == 100) 
            {
                // generate new sitemap file
                $apps->store('xml',$sitemapName);
                // add the file to the sitemaps array
                $apps->addSitemap(url($sitemapName.'.xml'));
                // reset items array (clear memory)
                $apps->model->resetItems();
                // reset the counter
                $counter = 0;
                // count generated sitemap
                $sitemapCounter++;
            }
            

            $images = [];
            if($m->image_url)
                $images[] = [
                    'url'   => isset($m->appImage) ? $m->appImage->image_link : $m->image_url,
                    'title' => $m->title,
                    'caption' => truncate($m->description,80)
                ];

            // add product to items array
            $createdAt = $m->updated_at->format(\DateTime::W3C);
            $apps->add(
                $m->detail_url, 
                $createdAt, 
                '0.8',
                'daily',
                $images,
                $m->title
            ); 
            // count number of elements
            $counter++;
        }

        $hasItems = $apps->model->getItems();
        // you need to check for unused items
        if (!empty($hasItems))
        {
            // generate sitemap with last items
            $apps->store('xml',$sitemapName);
            // add sitemap to sitemaps array
            $apps->addSitemap(url($sitemapName.'.xml'));
            // reset items array
            $apps->model->resetItems();
        }
        // generate new sitemapindex that will contain all generated sitemaps above
        $apps->store('sitemapindex','sitemap/apps');
        
        $this->sitemapIndex();      
        
        // $appMarket->generateSitemap()
        //         ->chunk(2,function ($model) use($counter,$sitemapCounter,$apps) {
        //             foreach ($model as $m) {

        //                 $sitemapName = 'sitemap/apps/index-'.$sitemapCounter;
        //                 if ($counter == 5) 
        //                 {
        //                     // generate new sitemap file
        //                     $apps->store('xml',$sitemapName);
        //                     // add the file to the sitemaps array
        //                     $apps->addSitemap(url($sitemapName.'.xml'));
        //                     // reset items array (clear memory)
        //                     $apps->model->resetItems();
        //                     // reset the counter
        //                     $counter = 0;
        //                     // count generated sitemap
        //                     $sitemapCounter++;
        //                 }
                        

        //                 $images = [];
        //                 if($m->image_url)
        //                     $images[] = [
        //                         'url'   => isset($m->appImage) ? $m->appImage->image_link : $m->image_url,
        //                         'title' => $m->title,
        //                         'caption' => truncate($m->description,80)
        //                     ];

        //                 // add product to items array
        //                 $createdAt = $m->updated_at->format(\DateTime::W3C);
        //                 $apps->add(
        //                     $m->detail_url, 
        //                     $createdAt, 
        //                     '0.8',
        //                     'daily',
        //                     $images,
        //                     $m->title
        //                 ); 
        //                 // count number of elements
        //                 $counter++;
        //             }

        //             $hasItems = $apps->model->getItems();
        //             // you need to check for unused items
        //             if (!empty($hasItems))
        //             {
        //                // generate sitemap with last items
        //                $apps->store('xml',$sitemapName);
        //                // add sitemap to sitemaps array
        //                $apps->addSitemap(url($sitemapName.'.xml'));
        //                // reset items array
        //                $apps->model->resetItems();
        //             }
        //             // generate new sitemapindex that will contain all generated sitemaps above
        //             $apps->store('sitemapindex','sitemap/apps');
        //         });
        
        
        $this->sitemapIndex();        
        return redirect()->route('backend.sitemap.index');

    }


    /**
    * postSitemapCategoriesCollections()
    * 
    *
    * @return void
    * @access  public
    */
    public function postSitemapCategoriesCollections()
    {
        // create sitemap
        $apps = app("sitemap");

        // set cache
        $apps->setCache('appmarketcms.sitemap-category', 3600);

        $categoryModel = app('Lib\Repositories\CategoryRepositoryEloquent');

        $counter        = 0;
        $sitemapCounter = 0;

        Storage::disk('sitemap')->makeDirectory('sitemap/categories');

        $categoryModel->generateSitemap()
                ->chunk(500,function ($model) use($counter,$sitemapCounter,$apps) {
                    foreach ($model as $m) {

                        $sitemapName = 'sitemap/categories/index-'.$sitemapCounter;
                        if ($counter == 1000) 
                        {
                            // generate new sitemap file
                            $apps->store('xml',$sitemapName);
                            // add the file to the sitemaps array
                            $apps->addSitemap(url($sitemapName.'.xml'));
                            // reset items array (clear memory)
                            $apps->model->resetItems();
                            // reset the counter
                            $counter = 0;
                            // count generated sitemap
                            $sitemapCounter++;
                        }

                        // add product to items array
                        $createdAt = $m->updated_at->format(\DateTime::W3C);
                        $apps->add(
                            $m->detail_url, 
                            $createdAt, 
                            '0.8',
                            'daily',
                            [],
                            $m->title
                        ); 
                        // count number of elements
                        $counter++;
                    }

                    $hasItems = $apps->model->getItems();
                    // you need to check for unused items
                    if (!empty($hasItems))
                    {
                       // generate sitemap with last items
                       $apps->store('xml',$sitemapName);
                       // add sitemap to sitemaps array
                       $apps->addSitemap(url($sitemapName.'.xml'));
                       // reset items array
                       $apps->model->resetItems();
                    }
                    // generate new sitemapindex that will contain all generated sitemaps above
                    $apps->store('sitemapindex','sitemap/category');
                });

        
        $this->sitemapIndex();
        return redirect()->route('backend.sitemap.index');
    }
    

    /**
    * sitemapIndex()
    * 
    *
    * @return void
    * @access  private
    */
    private function sitemapIndex()
    {
        // create sitemap index
        $sitemap = app("sitemap");
        $files = File::files('sitemap');

        if(count($files) > 0)
        {
            foreach ($files as $key => $item) {


                if(!str_contains($item,'sitemap.xml'))
                {
                    $time = Storage::disk('sitemap')->lastModified($item);
                    $updated_at = Carbon::createFromTimestamp($time)->format(\DateTime::W3C);
                    $sitemap->addSitemap(url($item),$updated_at);
                }
            }
            // create file sitemap.xml in your public folder (format, filename)
            $sitemap->store('sitemapindex','sitemap/sitemap');
        }
    }


    /**
    * postSitemapClear()
    * 
    *
    * @return void
    * @access  public
    */
    public function postSitemapClear()
    {
        Storage::disk('sitemap')->deleteDirectory('sitemap');
        return redirect()->route('backend.sitemap.index');
    }
}