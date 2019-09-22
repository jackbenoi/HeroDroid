<?php

namespace Lib\Api;

/**
 * Lib\Api\ApkDownload
 * 
 * __DESCRIPTION__
 *
 * @package namespace Lib\Api;
 * @category ApkDownload
 * @author store Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use Cache;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;
use Campo\UserAgent;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Exception;

use Lib\Traits\ResponseTrait;

class ApkDownload
{

    use ResponseTrait;


    private $webClient;
    private $appId;

    /**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    **/
    public function __construct()
    {

        // add purchase code and username in the admin page...
        // it will automatically download codes from your site.
    }

    /**
    * download()
    * 
    * @return void
    * @access  public
    **/
    public function download($appId)
    {

        // add purchase code and username in the admin page...
        // it will automatically download codes from your site.
    }

    private function source()
    {

        // add purchase code and username in the admin page...
        // it will automatically download codes from your site.
 
    }
}