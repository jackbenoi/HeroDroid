<?php

namespace App\Http\Controllers\Backend;

/**
 * App\Http\Controllers\Backend\SubmittedAppsController
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category SubmittedAppsController
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use App\Http\Controllers\Controller;

use Lib\Exceptions\SystemError;
use Lib\Traits\ResponseTrait;
use Exception;

class SubmittedAppsController extends Controller
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
        return view('backend.submitted_apps.index');
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
        
        return view('backend.submitted_apps.detail')->with(compact('hashId','is_create'));
    }
}