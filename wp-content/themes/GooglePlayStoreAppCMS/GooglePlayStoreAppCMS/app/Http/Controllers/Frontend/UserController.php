<?php

namespace App\Http\Controllers\Frontend;

/**
 * App\Http\Controllers\Frontend\UserController
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
        
use OAuth;
use Sentinel;
use Activation;
use Reminder;
use Exception;
use Mail;

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
        // $this->middleware('guest', ['except' => ['logout']]);
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
        $url = route('frontend.authenticate');
        if($this->request->input('return-url'))
            $url .= '?return-url='.$this->request->input('return-url');

        return view('frontend.user.login')->with(['url' => $url,'is_login' => true]);
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


        $validArr =  [
            'login'         => 'required',
            'password'      => 'required',
            
        ];
        $config = systemConfig();
        if($config['enable_recaptcha'] == 'yes')
            $validArr['g-recaptcha-response'] = 'required|recaptcha';

        $this->validate($this->request,$validArr);

            
        try {    
            $credentials =  array_only($this->request->all(), ['login', 'password']);

            $users = Sentinel::authenticate($credentials);

            if(!$users)
                return redirect()->back()->withInput()->withErrors(['Wrong Username/Password']);

            return redirect( route('frontend.index.index') );

        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            return redirect()->back()->withInput()->withErrors();
        }
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
        return redirect( route('frontend.index.index') );
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
        return view('frontend.user.profile')->with(['url' => route('frontend.profile.update')]);
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
            if($this->request->has('password'))
            {
                Sentinel::logout();
                return redirect( route('frontend.login') )->with(['success' => 'Please Re-login using your new password.']);
            }
            return redirect( route('frontend.profile') )->with(['success' => 'Successfully Update MyProfile!']);
            
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    /**
    * getRegistration()
    * 
    *
    * @return void
    * @access  public
    */
    public function getRegistration()
    {
        return view('frontend.user.profile')->with(['is_register'=>true,'url' => route('frontend.register.create')]);
    }

   /**
    * postRegistration()
    * 
    *
    * @return void
    * @access  public
    */
    public function postRegistration()
    {
        

        $validArr =  [
            'first_name'           => 'required',
            'last_name'            => 'required',
            'username'             => 'required|min:3|unique:users,Username,'.$this->request->get('username'),
            'email'                => 'required|unique:users,Email,'.$this->request->get('email'),
            'password'             => 'required',
            
        ];
        $config = systemConfig();
        if($config['enable_recaptcha'] == 'yes')
            $validArr['g-recaptcha-response'] = 'required|recaptcha';

        $this->validate($this->request,$validArr);

        try {    
            $credentials = [
                'email'      => $this->request->get('email'),
                'first_name' => $this->request->get('first_name'),
                'last_name'  => $this->request->get('last_name'),
                'username'   => $this->request->get('username'),
                'password'   => $this->request->get('password')
            ];

            $config = systemConfig();
            if(isset($config['auto_activate_user_registration']) && $config['auto_activate_user_registration'] == 'no')
            {
                $user = Sentinel::register($credentials);
                $role = Sentinel::findRoleBySlug('normal');
                $role->users()->attach($user);

                $this->_sendMailActivation($user,$credentials,$config);
                
                session()->flash('success', 'Please check your email ('.$credentials['email'].') to activate your account.');
                return redirect()->route('frontend.login');
            }
            else
            {
                $user = Sentinel::registerAndActivate($credentials);

                $role = Sentinel::findRoleBySlug('normal');
                $role->users()->attach($user);
                
                $credentials =  array_only($this->request->all(), ['email', 'password']);

                $users = Sentinel::authenticate($credentials);
                if(!$users)
                    return redirect()->back()->withInput()->withErrors(['message' => 'Wrong Username/Password']);

                return redirect( route('frontend.index.index') );
            }

        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
    *
    * getFacebook()
    *
    * @return template
    * @access  public
    **/
    public function getFacebook()
    {
        return $this->socialAuthenticate('Facebook');
    }


    /**
    *
    * getTwitter()
    *
    * @return template
    * @access  public
    **/
    public function getTwitter()
    {
        return $this->socialAuthenticate('Twitter');
    }

    /**
    *
    * getGooglePlus()
    *
    * @return template
    * @access  public
    **/
    public function getGooglePlus()
    {
        return $this->socialAuthenticate('Google');
    }


    /**
    *
    * getActivationAccount()
    *
    * @return template
    * @access  public
    **/
    public function getActivationAccount($userId,$code)
    {
        $user = Sentinel::findById($userId);

        if (Activation::complete($user, $code))
        {
            $type = 'success';
            $message  = 'Your account was successfully activated. Please login your account.';
        }
        else
        {
            $type = 'error';
            $message  = 'Your account is not activated yet, please check your email to activate account.';
        }
        session()->flash($type, $message);
        return redirect()->route('frontend.login');
    }

    /**
    *
    * getForgotPassword()
    *
    * @return template
    * @access  public
    **/
    public function getForgotPassword()
    {
       return view('frontend.user.forgot')->with(['url' => route('frontend.forgot.resend')]);
    }

    /**
    *
    * postForgotPassword()
    *
    * @return template
    * @access  public
    **/
    public function postForgotPassword()
    {
        
        try {
            
            $userRepo = app('Lib\Repositories\UserRepositoryEloquent');
            $userDetail = '';
            if($this->request->has('email'))
                $userDetail = $userRepo->findUserByEmailorUsername( $this->request->get('email') );

            if(!$userDetail)
            {
                if($this->request->has('login'))
                    $userDetail = $userRepo->findUserByEmailorUsername( $this->request->get('login') );
            }

            if($userDetail)
            {
                $this->_sendMailReminder($userDetail);
                session()->flash('success', 'We sent a reset password link in your email ('.$userDetail->email.')');
                return redirect()->route('frontend.forgot.password');
            }

            throw new Exception("Email or Username doesnt exists in our system", 1);
            

        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    /**
    *
    * getResetPassword()
    *
    * @return template
    * @access  public
    **/
    public function getResetPassword($userId,$code)
    {

        try {
            
            $user = Sentinel::findById($userId);

            $reminderExists = Reminder::exists($user);
            if(!$reminderExists)
                throw new Exception("Reset code is not exists", 1);
            
            return view('frontend.user.reset-password')->with(['url' => route('frontend.reset.change'),'code' => $code,'userid' => $userId]);

        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
    *
    * postResetPassword()
    *
    * @return template
    * @access  public
    **/
    public function postResetPassword()
    {

        try {
            $this->validate($this->request, [
                'password'  => 'required',
                'code'      => 'required',
                'user_id'   => 'required'
            ]);

            $userId   = $this->request->get('user_id');
            $code     = $this->request->get('code');
            $password = $this->request->get('password');

            $user = Sentinel::findById($userId);

            $reminderExists = Reminder::exists($user);
            if(!$reminderExists)
                throw new Exception("Reset code is not exists", 1);

            if ($reminder = Reminder::complete($user, $code, $password))
            {
                $type    = 'success';
                $message = 'Your password was successfully reset. Please login your account with your new password.';
            }
            else
            {
                $type    = 'error';
                $message = 'Reset password failed, please try again and forgot your password.';
            }
            session()->flash($type, $message);
            return redirect()->route('frontend.login');

        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
    /**
    *
    * socialAuthenticate()
    *
    * @return template
    * @access  private
    **/
    private function socialAuthenticate($socialTag)
    {

        $oauth   = OAuth::consumer( $socialTag );
        $userArr = [];

        if($socialTag == 'Twitter')
        {
            if ( request()->has('oauth_token') && request()->has('oauth_verifier') )
            {

                $token = request()->get('oauth_token');
                $verify = request()->get('oauth_verifier');

                $token = $oauth->requestAccessToken( $token, $verify );

               // Send a request with it
                $result = json_decode( $oauth->request( 'account/verify_credentials.json' ), true );

                if(!isset($result['screen_name']))
                    throw new Exception("No screen_name found", 1);
                

                $userArr['first_name'] = $result['name'];
                $userArr['last_name']  = '';
                $userArr['username']   = $userArr['password']   = $result['id'];

                $email = str_slug($result['screen_name'],'_') .'@twitterapp.com';

            }
            else
            {
                $reqToken = $oauth->requestRequestToken();

                // get Authorization Uri sending the request token
                $url = $oauth->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

                // return to twitter login url
                return redirect()->to( (string)$url );
            }
        }
        else if(in_array($socialTag, ['Facebook','Google']))
        {

            if ( request()->has('code') )
            {
                $code  = request()->get('code');
                $token = $oauth->requestAccessToken( $code );

                if($socialTag == 'Facebook')
                {
                    // Send a request with it
                    $result = json_decode( $oauth->request( '/me?fields=id,name,first_name,last_name,email,picture' ), true );

                    $userArr['first_name'] = $result['first_name'];
                    $userArr['last_name']  = $result['last_name'];
                    $userArr['username']   = $userArr['password']   = $result['id'];

                }
                else if($socialTag == 'Google')
                {
                    // Send a request with it
                    $result = json_decode( $oauth->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

                    $userArr['first_name'] = $result['given_name'];
                    $userArr['last_name']  = $result['family_name'];
                    $userArr['username']   = $userArr['password']   = $result['id'];
                }

                $email = $result['email'];
            }
            else
            {
                $url = $oauth->getAuthorizationUri();
                return redirect()->to( (string)$url );
            }
        }
        
        $userArr['email'] = $email;
        
        $userExists = Sentinel::findByCredentials( ['login' => $email ] );
        if (!$userExists)
        {

            $credentials = $userArr;

            $user = Sentinel::registerAndActivate($credentials);

            $role = Sentinel::findRoleBySlug('normal');
            $role->users()->attach($user);
        }

        $credentials = array_only($userArr, ['email', 'password']);
        $users = Sentinel::authenticate($credentials);
        if(!$users)
            return redirect()->back()->withInput()->withErrors(['message' => 'Wrong Username/Password']);

        return redirect( route('frontend.index.index') );
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

        $userExists = Sentinel::findByCredentials( ['login' => $input['email'] ] );
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

    /**
    *
    * _sendMailReminder()
    *
    * @return []
    * @access  private
    **/
    private function _sendMailReminder($user)
    {

        $config = systemConfig();

        $userDetails = $user->toArray();
        $reminder = Reminder::create($user);
        $reminderCode = $reminder->code;
        $userDetails['reminder_code'] = $reminderCode;

        $userDetails['reminder_link'] = route('frontend.reset.password',[$userDetails['id'], $reminderCode ]);
        Mail::send('emails.forgot-password', ['data' => $userDetails], function ($message) use ($config,$userDetails) {

            $email = 'buymyscript@codecanyon-sample-email.net';
            if($config['contact_email'] != '')
                $email = $config['contact_email'];

            $userEmail = $userDetails['email'];
            // $userEmail = 'activation10101@mailinator.com';

            $message->from($email, $config['cms_name'])
                    ->to($userEmail, $userDetails['first_name'].' '.$userDetails['last_name'])
                    ->subject('Reset Account Password from '.$config['cms_name']);
        });
    }

    /**
    *
    * _sendMailActivation()
    *
    * @return []
    * @access  private
    **/
    private function _sendMailActivation($user,$credentials,$config)
    {

        $activation = Activation::create($user);
        $credentials['activation_link'] = route('frontend.activation',[$user->id,$activation->code]);
        Mail::send('emails.registration', ['data' => $credentials], function ($message) use ($config,$credentials) {

            $email = 'buymyscript@codecanyon-sample-email.net';
            if($config['contact_email'] != '')
                $email = $config['contact_email'];

            $userEmail = $credentials['email'];
            // $userEmail = 'activation10101@mailinator.com';

            $message->from($email, $config['cms_name'])
                    ->to($userEmail, $credentials['first_name'].' '.$credentials['last_name'])
                    ->subject('Account Activation from '.$config['cms_name']);
        });
    }
}