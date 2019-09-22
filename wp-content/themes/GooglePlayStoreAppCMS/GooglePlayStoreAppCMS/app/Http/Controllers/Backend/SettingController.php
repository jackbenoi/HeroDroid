<?php

namespace App\Http\Controllers\Backend;

/**
 * App\Http\Controllers\Backend\SettingController
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category SettingController
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use App\Http\Controllers\Controller;
use Exception;
use Lib\Exceptions\SystemError;

use Lib\Traits\ResponseTrait;
use Lib\Repositories\ConfigurationRepositoryEloquent;

class SettingController extends Controller
{

    use ResponseTrait;
 	/**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    */
    public function __construct(ConfigurationRepositoryEloquent $configuration)
    {
        $this->configuration = $configuration;
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
        return view('backend.settings.general.index')->with(['is_settings' => true]);
    }


   /**
    *
    * postUploadLogo()
    *
    * @return template
    * @access  public
    **/
    public function postUploadLogo()
    {  
        try {
            

            if(request()->has('key'))
            {
                $result = $this->configuration->removeLogo( request()->get('key') );
                return $this->cmsResponse('Successfully upload site logo');
            }
            else
            {
                if(!request()->has('file') )
                    throw new Exception("No selected image to upload", 1);

                if(!request()->has('image_key') )
                    throw new Exception("Image key not found!", 1);

                $result = $this->configuration->uploadLogo( request()->all() );
                return $this->cmsResponse('Successfully upload site logo');
            }
            

        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

   /**
    *
    * getAdsManagement()
    *
    * @return template
    * @access  public
    **/
    public function getAdsManagement()
    {  
        return view('backend.settings.ads.index')->with(['is_settings' => true]);
    }


   /**
    *
    * getFeaturedApp()
    *
    * @return template
    * @access  public
    **/
    public function getFeaturedApp()
    {   

        $appMarket = app('Lib\Repositories\AppMarketRepositoryEloquent');
        $featuredItems = $appMarket->featuredItemLists();
        return view('backend.settings.featured_app.index')->with(['is_settings' => true,'featuredItems' => $featuredItems]);
    }


   /**
    *
    * getUserManagement()
    *
    * @return template
    * @access  public
    **/
    public function getUserManagement()
    {   
        return view('backend.settings.usermgt.index')->with(['is_settings' => true]);
    }


   /**
    *
    * getUserDetail()
    *
    * @return template
    * @access  public
    **/
    public function getUserDetail($id = null)
    {   

        $is_create = ($id == '') ? 1 : 0;
        $hashId    = $id;

        $roles = app('Cartalyst\Sentinel\Roles\EloquentRole');
        $userRoles = $roles->get();

        return view('backend.settings.usermgt.detail')
                ->with(['is_settings' => true,
                    'hashId' => $hashId,
                    'is_create' => $is_create,
                    'userRoles' => $userRoles
                ]);
    }

   /**
    *
    * postAddToFeaturedItem()
    *
    * @return template
    * @access  public
    **/
    public function postAddToFeaturedItem()
    {   
        
        try {
            
            if(!request()->has('items'))
                throw new Exception("No featured Item was selected", 1);
                
            $appMarket = app('Lib\Repositories\AppMarketRepositoryEloquent');

            $appMarket->setFeaturedItems( request()->get('items') );
            return $this->cmsResponse('Successfully set featured items');

        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

   /**
    *
    * postRemoveFeaturedItem()
    *
    * @return template
    * @access  public
    **/
    public function postRemoveFeaturedItem()
    {  
         try {
            
            if(!request()->has('id'))
                throw new Exception("No featured id was selected", 1);
                
            $appMarket = app('Lib\Repositories\AppMarketRepositoryEloquent');

            $appMarket->setFeaturedItems( [request()->get('id')],0 );
            return $this->cmsResponse('Successfully featured item removed.');

        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }
}