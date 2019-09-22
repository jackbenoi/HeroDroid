<?php

namespace App\Http\Controllers\Backend;

/**
 * App\Http\Controllers\Backend\IndexController
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category IndexController
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Artisan;
use Storage;

class IndexController extends Controller
{


 	/**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    */
    public function __construct(Request $request)
    {
       $this->request = $request;
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
       return view('backend.index.index');
    }


    /**
    * getClearCache()
    * Main Frontend page
    *
    * @return void
    * @access  public
    */
    public function getClearCache()
    {
        Artisan::call('cache:clear');
        sleep(5);
        return redirect()->back();
    }


    /**
    * getClearLogs()
    * Main Frontend page
    *
    * @return void
    * @access  public
    */
    public function getClearLogs()
    {   
        $fileSystem = app('Illuminate\Filesystem\Filesystem');
        $files = $fileSystem->files(storage_path('logs'));
        
        foreach ($files as $file)
        {
            if (time() - filemtime($file) >= 60 * 60 * 24 * 1) // 2 days
                $fileSystem->delete($file);
        }
        sleep(5);
        return redirect()->back();
    }


    /**
    * getClearViews()
    * Main Frontend page
    *
    * @return void
    * @access  public
    */
    public function getClearViews()
    {   
        Artisan::call('view:clear');
        sleep(5);
        return redirect()->back();
    }


    /**
    * getClearAllSessions()
    * Main Frontend page
    *
    * @return void
    * @access  public
    */
    public function getClearAllSessions()
    {   
        session()->flush();
        sleep(5);
        return redirect()->back();
    }

    /**
    * getTranslationReset()
    * Main Frontend page
    *
    * @return void
    * @access  public
    */
    public function getTranslationReset()
    {   
        Artisan::call('translations:reset');
        Artisan::call('translations:import');
        sleep(5);
        return redirect()->back();
    }
}