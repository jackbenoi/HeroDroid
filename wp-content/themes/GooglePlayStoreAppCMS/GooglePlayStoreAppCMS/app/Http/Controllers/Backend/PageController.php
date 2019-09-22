<?php

namespace App\Http\Controllers\Backend;

/**
 * App\Http\Controllers\Backend\PageController
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category PageController
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use App\Http\Controllers\Controller;
use Lib\Repositories\PageRepositoryEloquent;

class PageController extends Controller
{

    // Lib\Repositories\PageRepositoryEloquent
    private $page;

    /**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    */
    public function __construct(PageRepositoryEloquent $page)
    {
        $this->page = $page;
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
        return view('backend.page.index');
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
        $pageLists = $this->page->listPages();
        
        return view('backend.page.detail')->with(compact('hashId','is_create','pageLists'));
    }


}