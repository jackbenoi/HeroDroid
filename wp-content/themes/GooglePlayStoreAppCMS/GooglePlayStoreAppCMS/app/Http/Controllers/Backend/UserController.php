<?php

namespace App\Http\Controllers\Backend;

/**
 * App\Http\Controllers\Backend\UserController
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category UserController
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
        
use Sentinel;
use Exception;

class UserController extends Controller
{

    /**
     * Request Input
     *
     * @var Illuminate\Http\Request
     */
    private $request;

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('guest', ['except' => 'logout']);
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
        $url = route('backend.authenticate');
        if($this->request->input('return-url'))
            $url .= '?return-url='.$this->request->input('return-url');

        return view('backend.user.login')->with(['url' => $url,'is_login' => true]);
    }

    /**
    * postAuthenticate()
    * 
    *
    * @return void
    * @access  public
    */
    public function postAuthenticate()
    {
        $this->validate($this->request, [
            'login'         => 'required',
            'password'      => 'required',
        ]);

        $credentials =  array_only($this->request->all(), ['login', 'password']);

        $users = Sentinel::authenticate($credentials);

        if(!$users)
            return redirect()->back()->withInput()->withErrors(['Wrong Username/Password']);

        return redirect( route('backend.index.index') );
    }

    /**
    * getLogout()
    * 
    *
    * @return void
    * @access  public
    */
    public function getLogout()
    {
        Sentinel::logout();
        return redirect( route('backend.login') )->with(['success' => 'Successfully Logout!']);
    }

    /**
    * getProfile()
    * 
    *
    * @return void
    * @access  public
    */
    public function getProfile()
    {
        return view('backend.user.profile');
    }

    /**
     *
     * postUpdateProfile()
     *
     * @return void
     * @access  public
     **/
    public function postUpdateProfile()
    {
        $this->validate($this->request, [
            'username'   => 'required|min:3|unique:users,Username,'.$this->request->input('token_id'),
            'email'      => 'required|unique:users,Email,'.$this->request->input('token_id'),
            'first_name' => 'required|min:3',
            'last_name'  => 'required|min:3',
        ]);
        try {

            $this->updateUser();
            return redirect( route('backend.profile') )->with(['success' => 'Successfully Update MyProfile!']);
            
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     *
     * updateUser()
     *
     * @return void
     * @access  private
     **/
    private function updateUser()
    {
        $input = $this->request->all();

        if(!isset($input['token_id']))
            throw new Exception("Token ID is missing,please try to refresh your page.", 1);
            
        $user = $this->findById($input['token_id']);

        $userModel = app('Lib\Entities\User');
        $userExists = $userModel->where('username',$data['username'])
                            ->orWhere('email',$data['email'])->first();
        if ($userExists) {
            if ($userExists->id != $user->id) {
                throw new Exception("Email address already exist, please use other email.");
            }
        }
        $user = Sentinel::update($user, $input);
        return $user;
    }

    /**
     *
     * findById()
     *
     * @return void
     * @access  private
     **/
    private function findById($id)
    {
        return Sentinel::findById($id);
    }

}