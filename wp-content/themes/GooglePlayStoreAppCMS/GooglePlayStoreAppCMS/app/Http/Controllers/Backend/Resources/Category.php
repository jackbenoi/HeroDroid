<?php

namespace App\Http\Controllers\Backend\Resources;

/**
 * App\Http\Controllers\Backend\Resources\Category
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category Category
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Exception;
use Lib\Traits\ResponseTrait;
use Lib\Repositories\CategoryRepositoryEloquent;
use Lib\Repositories\ParentCategoryRepositoryEloquent;

class Category extends Controller
{

    // Lib\Traits\ResponseTrait
    use ResponseTrait;

    private $request;
    private $parentCategory;
    private $category;

    /**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    **/
    public function __construct(Request $request,CategoryRepositoryEloquent $category,ParentCategoryRepositoryEloquent $parentCategory)
    {
        $this->request        = $request;
        $this->category       = $category;
        $this->parentCategory = $parentCategory;
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

            $dataArray = $this->category->itemLists();
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

            $dataArray = $this->category->find($hashId);

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

            $dataInput = array_only($input,['title','description','user_id','is_enabled','is_featured','seo_title','seo_descriptions','seo_keywords','parent_category_id','icon']);

            if(!isset($input['parent_category_id']))
                throw new Exception("parent_category_id is missing from the request.", 1);
                
           
            if(!isset($dataInput['identifier']))
                $dataInput['identifier'] = str_slug($dataInput['title']);

            $slugExists = $this->category->findWhere(['identifier' => $dataInput['identifier']] )->first();
            
            if(!$slugExists)
            {

                if(isset($dataInput['seo_keywords']) && !empty($dataInput['seo_keywords']))
                    $dataInput['seo_keywords'] = arrayKeywordsToCommaString( $dataInput['seo_keywords'] );

                $model = $this->category->create($dataInput);
                if($model)
                    return $this->cmsResponse( $model );
            }
            else
            {
               throw new SystemError(sprintf("Page Slug exists (%s), try different identifier name ",$dataInput['identifier']), 400); 
            }
            

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

            $isUpdated = $this->category->updateDetails($this->request->all());
            if($isUpdated)
                return $this->cmsResponse(sprintf('Details for %s was successfully updated!',$this->request->input('title')));
            
            return $this->cmsResponse('Something went wrong, while updating your details',400 );

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

            $modelObj = $this->category->find($id);
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
}