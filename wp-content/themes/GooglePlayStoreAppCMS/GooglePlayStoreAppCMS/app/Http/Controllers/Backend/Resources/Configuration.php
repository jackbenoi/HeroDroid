<?php

namespace App\Http\Controllers\Backend\Resources;


/**
 * Configuration Class
 *
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category Configuration
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Lib\Traits\ResponseTrait;
use Lib\Traits\DownloadTrait;
use Lib\Exceptions\SystemError;

use Lib\Repositories\ConfigurationRepositoryEloquent;

class Configuration extends Controller { 

    // Lib\Traits\ResponseTrait
    use ResponseTrait;
    use DownloadTrait;

    private $configurationRepository;
    private $request;

    /**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    **/
    public function __construct(ConfigurationRepositoryEloquent $configurationRepository,
                                Request $request)
    {
        $this->request                  = $request;
        $this->configurationRepository  = $configurationRepository;
    }

    /**
    *
    * getIndex()
    *
    * @return template
    * @access  public
    **/
    public function index()
    {
        try {

            $dataArray = $this->configurationRepository->generalLists();
            return $this->cmsResponse($dataArray);

        } catch (\ModelNotFound $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (\Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

    /**
     * Update the specified manga info
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        try {
            
            $isUpdated = $this->configurationRepository->updateDetails($this->request->all());
            if($isUpdated)
                return $this->cmsResponse('Configuration was successfully updated!');
            
            return $this->cmsResponse('Something went wrong, while updating your details',400);
        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

    /**
     * Validate PurchaseCode and Username to get api url.
     *
     * @return Response
     */
    public function validateApi()
    {
        try {
            $input = $this->request->all();
            
            if(isset($input['purchase_code']) && isset($input['buyer_username']))
            {
                $this->configurationRepository->updateDetails($input);
                $result = $this->validatePurchaseCode($input['purchase_code'],$input['buyer_username']);
                return $this->cmsResponse($result);
            }
            return $this->cmsResponse('Purchase code or Buyer username not found.',400);

        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (\Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }
}