<?php

namespace App\Http\Controllers\Backend\Resources;

/**
 * AdsManagement Class
 *
 * __DESCRIPTION__
 *
 * @package AdsManagement
 * @author  Anthony Pillos <info@anthonypillos.com>
 * @copyright Copyright (c) 2017 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version v1
 */

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Lib\Traits\ResponseTrait;
use Lib\Repositories\AdvertisementBlockRepositoryEloquent;
use Lib\Exceptions\SystemError;

class AdsManagement extends Controller { 

    use ResponseTrait;

    private $adsBlockRepository;

    /**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    **/
    public function __construct(AdvertisementBlockRepositoryEloquent $adsBlockRepository,
                        Request $request)
    {
        $this->request = $request;

        $this->adsBlockRepository     = $adsBlockRepository;
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

            $returnQuery = $this->request->get('return') != '' ? true : false;

            $dataArray = $this->adsBlockRepository->blockLists($returnQuery);
            return $this->cmsResponse($dataArray);

        } catch (ModelNotFound $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {

            if(!$this->request->get('title') || !$this->request->get('code') || !$this->request->get('identifier'))
                throw new SystemError("Please fill up the required details for title and block content", 1);

            $blockContent = array_only($this->request->all(),['title','code','identifier']);


            $identifierObj = $this->adsBlockRepository->findByIdentifier($blockContent['identifier']);
            if($identifierObj)
                throw new SystemError("Ads Code is exists, Please try different code", 1);
                
            $adsModel     = $this->adsBlockRepository->create($blockContent);
            return $this->cmsResponse( $adsModel );


        } catch (SystemError $e) {
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

            $isUpdated = $this->adsBlockRepository->updateDetails($this->request->all());
            if($isUpdated)
                return $this->cmsResponse( 'Details for %s was successfully updated!' );
            
            return $this->cmsResponse('Something went wrong, while updating your details',400 );


            exit;
        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try {

            $modelObj = $this->adsBlockRepository->find($id);
            if($modelObj)
            {
                $dataObj = $modelObj;
                $destroyed = $modelObj->delete();
                if($destroyed)
                    return $this->cmsResponse(sprintf('Successfully deleted author name (%s).',$dataObj->title));
            }
            return $this->cmsResponse('Failed to delete author.');

        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

}