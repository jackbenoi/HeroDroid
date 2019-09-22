<?php

namespace App\Http\Controllers\Backend\Resources;


/**
 * User Class
 *
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category User
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Lib\Traits\ResponseTrait;
use Lib\Exceptions\SystemError;

use Lib\Repositories\UserRepositoryEloquent;
use Exception;
use Sentinel;

class User extends Controller { 

    // Lib\Traits\ResponseTrait
    use ResponseTrait;

    private $userRepository;
    private $request;

    /**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    **/
    public function __construct(UserRepositoryEloquent $userRepository,
                                Request $request)
    {
        $this->request        = $request;
        $this->userRepository = $userRepository;
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

            $dataArray = $this->userRepository->itemLists();
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
     * Display the specific data.
     *
     * @param  string  $hashId
     * @return JSON
     */
    public function show($hashId)
    {
        try {

            $dataArray = $this->userRepository->with(['roles'])->find($hashId);

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

            $this->validate($this->request, [
                'first_name' => 'required',
                'last_name'  => 'required',
                'username'   => 'required|min:3|unique:users,Username,'.$this->request->get('username'),
                'email'      => 'required|unique:users,Email,'.$this->request->get('email'),
                'password'   => 'required'
            ]);

            $credentials = [
                'email'      => $this->request->get('email'),
                'first_name' => $this->request->get('first_name'),
                'last_name'  => $this->request->get('last_name'),
                'username'   => $this->request->get('username'),
                'password'   =>$this->request->get('password')
            ];

            $user = Sentinel::registerAndActivate($credentials);


            if( $this->request->has('roles') )
            {
                $selectedRoles = array_pluck( $this->request->get('roles'),'id');
                $user->roles()->attach($selectedRoles);
            }
            return $this->cmsResponse($user);
            

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
            
            $isUpdated = $this->userRepository->updateDetails($this->request->all());
            if($isUpdated)
                return $this->cmsResponse('User was successfully updated!');
            
            return $this->cmsResponse('Something went wrong, while updating your details',400);
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

            $modelObj = $this->userRepository->find($id);
            if($modelObj)
            {
                $dataObj = $modelObj;
                $destroyed = $modelObj->delete();
                if($destroyed)
                    return $this->cmsResponse( sprintf('Successfully deleted user named (%s).',$dataObj->full_name));
            }
            return $this->cmsResponse('Failed to delete user.',400);

        } catch (SystemError $e) {
            return $this->cmsResponse($e->getMessage(),400);
        } catch (\Exception $e) {
            return $this->cmsResponse($e->getMessage(),400);
        }
    }

}