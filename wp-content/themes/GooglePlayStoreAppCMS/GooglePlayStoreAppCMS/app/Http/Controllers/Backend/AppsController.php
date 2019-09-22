<?php

namespace App\Http\Controllers\Backend;

/**
 * App\Http\Controllers\Backend\AppsController
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category AppsController
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use App\Http\Controllers\Controller;
use Lib\Repositories\GooglePlayRepository;
use Lib\Repositories\AppMarketRepositoryEloquent;
use Lib\Repositories\CategoryRepositoryEloquent;

use Lib\Traits\ResponseTrait;
use Exception;
use Lib\Exceptions\SystemError;
class AppsController extends Controller
{

    use ResponseTrait;

    // Lib\Repositories\CategoryRepositoryEloquent
    private $category;

    // Lib\Repositories\GooglePlayRepository
    private $googlePlay;


    // Lib\Repositories\AppMarketRepositoryEloquent
    private $appMarket;


    /**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    */
    public function __construct(CategoryRepositoryEloquent $category,
                            GooglePlayRepository $googlePlay,
                            AppMarketRepositoryEloquent $appMarket)
    {
        $this->category   = $category;
        $this->googlePlay = $googlePlay;
        $this->appMarket  = $appMarket;
        $this->config     = systemConfig();
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
        return view('backend.apps.index');
    }

    /**
    * getDetail()
    * 
    *
    * @return void
    * @access  public
    */
    public function getDetail($id = null)
    {
        $is_create = ($id == '') ? 1 : 0;
        $hashId    = $id;
        
        $categories = $this->category->categories(false);
        return view('backend.apps.detail')->with(compact('hashId','is_create','categories'));
    }

    /**
    * getAppMarket()
    * 
    *
    * @return void
    * @access  public
    */
    public function getAppMarket()
    {
        $is_create      = 1;
        $is_google_play = 1;

        $categories = $this->category->categories(false);
        return view('backend.apps.app')->with(compact('is_create','is_google_play','categories'));
    }



    /**
    * postGooglePlayDetail()
    * 
    *
    * @return void
    * @access  public
    */
    public function postGooglePlayDetail()
    {

        try {

            if(!request()->has('app_id'))
                throw new Exception("AppID not found", 1);
            
            $data = $this->googlePlay
                        ->setOptions([
                            'lang'    => @$this->config['set_your_locale'],
                            'country' => @$this->config['your_country_code']
                        ])
                        ->details(request()
                        ->get('app_id'));


            if(request()->has('is_save'))
            {

                $parsed = parse_url($data['cover_image']);
                if (empty($parsed['scheme'])) {
                    $data['cover_image'] = 'https://' . ltrim($data['cover_image'], '/');
                }

                $data['is_enabled']       = 1;
                $data['link']             = $data['app_link'];
                $data['developer_name']   = $data['developer']['name'];
                $data['developer_link']   = $data['developer']['link'];
                $data['image_url']        = $data['cover_image'];

                $data['seo_title']        = $data['title'];
                $data['seo_descriptions'] = truncate(e($data['description']),150);


                $data['ratings']        = $data['rate_score'];
                $data['ratings_total'] = $data['ratings_total'];
                $data['published_date'] = $data['published_date'];
                
                // save details.
                $this->appMarket->updateDetails($data);
                return $this->cmsResponse('Successfully Update');
            }
            else
                return $this->cmsResponse($data);

        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }


    /**
    * postSearchGooglePlay()
    * 
    *
    * @return void
    * @access  public
    */
    public function postSearchGooglePlay()
    {

        try {

            if(!request()->has('search'))
                throw new Exception("Search keyword not found", 1);
                
            $data = $this->googlePlay
                        ->setOptions([
                            'lang'    => @$this->config['set_your_locale'],
                            'country' => @$this->config['your_country_code']
                        ])
                        ->search(request()
                        ->get('search'));
            return $this->cmsResponse($data);

        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

    /**
     * Import Search App/Game in our System
     *
     * @param  int  $id
     * @return Response
     */
    public function postImportApp()
    {
        try {

            $input = request()->all();
            
            if(isset($input['data']))
            {
                $result = $this->appMarket->importApp($input);
                return $this->cmsResponse($result);
            }

            return $this->cmsResponse('Failed to import apps',400);

        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

    /**
     * Remove Upload By Id
     *
     * @param  int  $id
     * @return Response
     */
    public function postRemoveUpload($id)
    {
        try {

            $data = app('Lib\Repositories\UploadRepositoryEloquent');
            return $this->cmsResponse( $data->removeById($id) );

        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

    /**
     * Remove Upload By Id
     *
     * @param  int  $id
     * @return Response
     */
    public function postRemoveApk($id)
    {
        try {

            $data = app('Lib\Repositories\AppMarketVersionRepositoryEloquent');
            return $this->cmsResponse( $data->removeById($id) );

        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }
}