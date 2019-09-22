<?php

namespace App\Http\Controllers\Frontend\Resources;

/**
 * App\Http\Controllers\Frontend\Resources\AppMarket
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category AppMarket
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Exception;
use Lib\Traits\ResponseTrait;
use Lib\Repositories\AppMarketRepositoryEloquent;
use Lib\Exceptions\SystemError;


class AppMarket extends Controller
{

    // Lib\Traits\ResponseTrait
    use ResponseTrait;

    private $request;
    private $parentCategory;
    private $appmarket;

    /**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    **/
    public function __construct(Request $request,AppMarketRepositoryEloquent $appmarket)
    {
        $this->request   = $request;
        $this->appmarket = $appmarket;
    }

    /**
    *
    * index()
    *
    * @return JSON
    * @access  public
    **/
    public function index()
    {
        try {

            $dataArray = $this->appmarket->itemLists();
            return $this->cmsResponse($dataArray);

        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

    /**
     * Display the specific data.
     *
     * @param  string  $hashId
     * @return JSON
     */
    public function show($hashId)
    {
        try {

            $dataArray = $this->appmarket
                            ->with(['categories',
                                    'tags',
                                    'screenshots',
                                    'appImage',
                                    'versions'])
                            ->find($hashId);

            if($dataArray->seo_keywords != '')
                $dataArray->seo_keywords = commaStringToArrayKeywords( $dataArray->seo_keywords );

            return $this->cmsResponse($dataArray);

        } catch (\ModelNotFoundException $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (HttpNotFound $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (\Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

    /**
    *
    * store()
    *
    * @return template
    * @access  public
    **/
    public function store()
    {
        try {

            $input = $this->request->all();

            if(!isset($input['app_id']))
                throw new Exception("app_id is missing from the request.", 1);
            
            // is_submitted and disabled by default
            $input['is_submitted_app'] = 1;
            $input['is_enabled']       = 0;

            if(!isset($input['title']))
                throw new Exception("title is missing from the request.", 1);

            $modelObj = $this->appmarket->byAppId($input['app_id']);
            if($modelObj)
                throw new SystemError("AppID is exists already in the system.", 400);

            if(!$modelObj)
            {
                $model = $this->appmarket->createDetails($input);
                if($model)
                    return $this->cmsResponse( $model );
            }
            throw new SystemError('Problem in creation new app data.', 400); 
            

        } catch (\Exception $e) {
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

            $modelObj = $this->appmarket->find($id);
            if($modelObj)
            {
                $dataObj = $modelObj;
                $destroyed = $modelObj->delete();
                if($destroyed)
                    return $this->cmsResponse( sprintf('Successfully deleted category (%s).',$dataObj->title));
            }
            return $this->cmsResponse('Failed to delete category.',400);

        } catch (\Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

    /**
     * Update app details
     *
     * @param  int  $id
     * @return Response
     */
    public function customUpdate()
    {
        try {

            $isUpdated = $this->appmarket->updateDetails($this->request->all());
            if($isUpdated)
                return $this->cmsResponse($isUpdated);
            
            return $this->cmsResponse('Something went wrong, while updating your details',400 );

        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }


    /**
     * Update app details
     *
     * @param  int  $id
     * @return Response
     */
    public function apkVersionUpdate()
    {
        try {


            $isUpdated = $this->appmarket->updateVersionDetails($this->request->all());
            if($isUpdated)
                return $this->cmsResponse(sprintf('App version %s was successfully updated!',$this->request->input('app_version')));
            
            return $this->cmsResponse('Something went wrong, while updating your details',400 );

        } catch (Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }
}