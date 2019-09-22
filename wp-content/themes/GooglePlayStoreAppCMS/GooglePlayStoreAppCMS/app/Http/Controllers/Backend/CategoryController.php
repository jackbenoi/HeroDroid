<?php

namespace App\Http\Controllers\Backend;

/**
 * App\Http\Controllers\Backend\CategoryController
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category CategoryController
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use App\Http\Controllers\Controller;
use Lib\Repositories\CategoryRepositoryEloquent;

class CategoryController extends Controller
{

    // Lib\Repositories\CategoryRepositoryEloquent
    private $category;

    /**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    */
    public function __construct(CategoryRepositoryEloquent $category)
    {
        $this->category = $category;
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
        return view('backend.category.index');
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
        
        return view('backend.category.detail')->with(compact('hashId','is_create'));
    }


    /**
    * getSubCategory()
    * 
    *
    * @return void
    * @access  public
    */
    public function getSubCategory($parentCatId)
    {
        return view('backend.category.subcat-index')->with(compact('parentCatId'));
    }

    /**
    * getSubCategoryDetail()
    * 
    *
    * @return void
    * @access  public
    */
    public function getSubCategoryDetail($parentCatId,$id = null)
    {
        $is_create = ($id == '') ? 1 : 0;
        $hashId    = $id;
        
        return view('backend.category.subcat-detail')->with(compact('parentCatId','hashId','is_create'));
    }
}