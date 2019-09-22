<?php

namespace App\Http\Controllers\Backend\Resources;

/**
 * App\Http\Controllers\Backend\Resources\Page
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category Page
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Exception;
use Lib\Traits\ResponseTrait;

use Lib\Repositories\PageRepositoryEloquent;
use Lib\Repositories\StatusRepositoryEloquent;

class Page extends Controller
{

    // Lib\Traits\ResponseTrait
    use ResponseTrait;

    private $request;
    private $page;

    /**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    **/
    public function __construct(Request $request,
                        PageRepositoryEloquent $page,
                        StatusRepositoryEloquent $status)
    {
        $this->request = $request;
        $this->page    = $page;
        $this->status  = $status;
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

            $dataArray = $this->page->itemLists();
            return $this->cmsResponse($dataArray);

        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (\Exception $e) {
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

            $dataArray = $this->page->with('status')->find($hashId);
            
            if($dataArray->seo_keywords != '')
                $dataArray->seo_keywords = commaStringToArrayKeywords( $dataArray->seo_keywords );

            return $this->cmsResponse($dataArray);

        } catch (\ModelNotFoundException $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (HttpNotFound $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (SystemError $e) {
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

            $dataInput = array_only($input,['title','content','user_id','seo_title','seo_descriptions','seo_keywords']);

            if(!isset($dataInput['slug']))
               $dataInput['slug'] = str_slug($dataInput['title']);

            
            $slugExists = $this->page->findWhere(['slug' => $dataInput['slug']] )->first();

            if(!$slugExists)
            {

            
                if(@$input['is_draft'] == 1)
                    $status = $this->status->findByIdentifier(STAT_DRAFT);
                else
                    $status = $this->status->findByIdentifier(STAT_PUBLISHED);

                if($status)
                    $dataInput['status_id'] = $status->getId();

                if(isset($dataInput['seo_keywords']) && !empty($dataInput['seo_keywords']))
                    $dataInput['seo_keywords'] = arrayKeywordsToCommaString( $dataInput['seo_keywords'] );

                $model = $this->page->create($dataInput);
                if($model)
                    return $this->cmsResponse( $model );
            }
            else
            {
               throw new SystemError(sprintf("Page Slug exists (%s), try different slug name ",$dataInput['slug']), 400); 
            }
            

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

            $isUpdated = $this->page->updateDetails($this->request->all());
            if($isUpdated)
                return $this->cmsResponse(sprintf('Details for %s was successfully updated!',$this->request->input('title')));
            
            return $this->cmsResponse('Something went wrong, while updating your details',400 );

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

            $modelObj = $this->page->find($id);
            if($modelObj)
            {
                $dataObj = $modelObj;
                $destroyed = $modelObj->delete();
                if($destroyed)
                    return $this->cmsResponse( sprintf('Successfully deleted page (%s).',$dataObj->title));
            }
            return $this->cmsResponse('Failed to delete page.',400);

        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (\Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

    /**
     * Remove all pages in bulk actions
     *
     * @return Response
     */
    public function destroyMultiplePages()
    {

        try {
            $input = $this->request->all();

            if(isset($input['ids']))
            {

                $ids = array_filter($input['ids']);
                $this->page->bulkDeletions( $ids );
                return $this->cmsResponse('Successfully deleted all pages.');
            }
            return $this->cmsResponse('Failed to delete page(s).',400);

        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (\Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }
}