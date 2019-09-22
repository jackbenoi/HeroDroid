<?php

namespace App\Http\Controllers\Frontend;

/**
 * App\Http\Controllers\Frontend\SubmitAppController
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category SubmitAppController
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Lib\Repositories\AppMarketRepositoryEloquent;
use Lib\Repositories\CategoryRepositoryEloquent;
use Lib\Repositories\ParentCategoryRepositoryEloquent;
use Lib\Repositories\GooglePlayRepository;
use Exception;
use Mail;
use Sentinel;
use Lib\Traits\ResponseTrait;

class SubmitAppController extends Controller
{

    use ResponseTrait;
 	/**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    */
    public function __construct(
                                Request $request,
                                GooglePlayRepository $googlePlay,
                                AppMarketRepositoryEloquent $appMarket,
                                CategoryRepositoryEloquent $category
                            )
    {

        $this->middleware('xssprotection');

        $this->request    = $request;
        $this->googlePlay = $googlePlay;
        $this->appMarket  = $appMarket;
        $this->category   = $category;
    }

    /**
    * getIndex()
    * Main Frontend page
    *
    * @return void
    * @access  public
    */
    public function getIndex()
    {
        $is_create = 1;
        $hashId    = 0;
        
        $categories = $this->category->categories(false,true);
        return view('frontend.submitapps.index')->with(compact('hashId','is_create','categories'));
    }

    /**
    * getLists()
    * Main Frontend page
    *
    * @return void
    * @access  public
    */
    public function getLists()
    {

        $user = Sentinel::getUser();
        if(!$user)
            abor(404);

        
        $itemLists = $this->appMarket->submittedItemLists($user->id);
        return view('frontend.submitapps.list')->with(compact('itemLists'));
    }


    /**
    * getDetail()
    * Main Frontend page
    *
    * @return void
    * @access  public
    */
    public function getDetail($id=null)
    {

        $is_create = ($id == '') ? 1 : 0;
        

        $appModel = $this->appMarket->byAppId($id);
        if(!$appModel)
            abort(404);

        $hashId = $appModel->id;
        
        $categories = $this->category->categories(false,true);
        return view('frontend.submitapps.index')->with(compact('hashId','is_create','categories'));
    }

    /**
    * postDetailInfo()
    * 
    *
    * @return void
    * @access  public
    */
    public function postDetailInfo()
    {

        try {

            if(!request()->has('app_id'))
                throw new Exception("AppID not found", 1);

            $config = systemConfig();
            $data = $this->googlePlay
                        ->setOptions([
                            'lang'    => isset($config['set_your_locale']) ? $config['set_your_locale'] : 'en',
                            'country' => isset($config['your_country_code']) ? $config['your_country_code'] : 'us'
                        ])
                        ->details(request()
                        ->get('app_id'),[],true);

            return $this->cmsResponse($data);

        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }
}