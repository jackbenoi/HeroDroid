<?php

namespace App\Http\Controllers\Frontend;

/**
 * App\Http\Controllers\Frontend\IndexController
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
use Lib\Repositories\AppMarketRepositoryEloquent;
use Lib\Repositories\CategoryRepositoryEloquent;
use Lib\Repositories\ParentCategoryRepositoryEloquent;
use Lib\Repositories\PageRepositoryEloquent;
use Exception;
use Mail;
use Event;
use Storage;
use Carbon\Carbon;

use Lib\Traits\RatingsTrait;
use Lib\Traits\DownloadTrait;

class IndexController extends Controller
{

    use RatingsTrait,DownloadTrait;

 	/**
    * __construct()
    * Initialize our Class Here for Dependecy Injection
    *
    * @return void
    * @access  public
    */
    public function __construct(
                                Request $request,
                                AppMarketRepositoryEloquent $appMarket,
                                ParentCategoryRepositoryEloquent $parentCategory,
                                CategoryRepositoryEloquent $category,
                                PageRepositoryEloquent $page
                            )
    {

        $this->middleware('xssprotection');

        $this->request        = $request;
        $this->appMarket      = $appMarket;
        $this->category       = $category;
        $this->parentCategory = $parentCategory;
        $this->page           = $page;
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
        
        $newestItemLists         = $this->appMarket->newestItemLists();
        $newestSubmittedAppLists = $this->appMarket->newestItemLists(15,true);
        
        return view('frontend.index.index')->with(compact('newestItemLists','newestSubmittedAppLists'));
    }


    /**
    * getEditorsPick()
    * Main Frontend page
    *
    * @return void
    * @access  public
    */
    public function getEditorsPick()
    {
        
        $featuredItems = $this->appMarket->featuredItemLists();
        $isViewAll = true;
        return view('frontend.index.editors-pick')->with(compact('featuredItems','isViewAll'));
    }


    /**
    * getNewestApp()
    * Show newest app
    *
    * @return void
    * @access  public
    */
    public function getNewestApp()
    {
        $newestItemLists = $this->appMarket->itemLists();
        $isViewAll       = true;
        return view('frontend.index.newest-app-added')->with(compact('isViewAll','newestItemLists'));
    }


    /**
    * getDetail()
    * Detail Information
    *
    * @return void
    * @access  public
    */
    public function getDetail($slug)
    {

        try {
            if(!request()->has('id'))
                return redirect()->route('frontend.index.index');

            $appId  = request()->get('id');
            $detail = $this->appMarket->byAppIdWithDetails(htmlentities($appId));

            // pre($detail);exit;
            $detail->load(['categories.apps' => function ($q) use ( &$relatedApps, $detail) {
                $relatedApps = $q->where('id', '<>', $detail->id)->isEnabled()->get()->take(5)->unique();
            }]);
                
            // track views
            Event::fire(new \App\Events\TrackVisitor($detail));

            return view('frontend.index.detail')->with(compact('appId','detail','relatedApps'));

        } catch (Exception $e) {
            return redirect()->route('frontend.index.index');
        }
    }


    /**
    * postDownloadAppApi()
    * Download Page
    *
    * @return void
    * @access  public
    */
    public function postDownloadAppApi()
    {

        try {

            if(!request()->has('app_id') or !request()->has('token') or !request()->has('app_url'))
                throw new Exception("Required fields not found.", 1);
                
            $appUrl    = request()->get('app_url');
            $appId     = decrypt(request()->get('app_id'));
            $versionId = decrypt(request()->get('token'));
            $detail    = $this->appMarket->byAppId(htmlentities($appId));
            
            if($versionId == 'api')
            {
                $config = systemConfig();
                if(@$config['purchase_code'] && @$config['buyer_username'] )
                {
                    $appUrl = ($detail->link != '') ? $detail->link : $appUrl;
                    return $this->downloadAPK($detail->app_id,$appUrl);
                }
            }
            throw new Exception("Error.", 1);
            

        } catch (Exception $e) {
            \Log::error('Errr: '. print_r($e->getMessage(),true));
            return redirect()->route('frontend.index.index');
        }
    }

    /**
    * getDownloadApp()
    * Download Page
    *
    * @return void
    * @access  public
    */
    public function getDownloadApp($slug)
    {

        try {

            $appId     = request()->get('app_id');
            $versionId = decrypt(request()->get('token'));
            $detail    = $this->appMarket->byAppId(htmlentities($appId));

            $detail->load(['categories.apps' => function ($q) use ( &$relatedApps, $detail) {
                $relatedApps = $q->where('id', '<>', $detail->id)->get()->take(5)->unique();
            }]);


            if($versionId == 'api')
            {
                $dlURL  = '#';
                return view('frontend.index.download-detail')->with(compact('appId','detail','dlURL','relatedApps','versionId'));
            }
            else
            {
                if(env('DEMO_MODE_ON'))
                {
                    $token = encrypt(request()->get('token'));
                }
                else
                {
                    if(!request()->has('app_id') && !request()->has('token'))
                        return redirect()->route('frontend.index.index');

                    $appMarketVersion = app('Lib\Repositories\AppMarketVersionRepositoryEloquent');

                    $versionObj = $appMarketVersion->find($versionId);
                    if(!$versionObj)
                        throw new Exception("No version found!..", 1);
                    
                    if($versionObj->is_link != 1)
                    {
                        $filePath = $detail->id.'/apk/'.$versionObj->app_version.'/'.$versionObj->file_path;
                        if(!Storage::disk('uploads')->exists( $filePath ))
                            throw new Exception("Apk file is missing...", 1);
                    }
                    
                    $token = encrypt($versionId);
                }


                $dlURL = route('frontend.force.download',[$appId,$token]);

                return view('frontend.index.download-detail')->with(compact('appId','detail','dlURL','relatedApps','versionId'));
            }
            throw new Exception("Problem generating download link.", 1);
            
        } catch (Exception $e) {
            return redirect()->route('frontend.index.index');
        }
    }

    /**
    * getDownloadLink()
    * Download Page
    *
    * @return void
    * @access  public
    */
    public function getDownloadLink($appId,$token)
    {

        try {

            if(env('DEMO_MODE_ON'))
            {
                
                $filePath = public_path('sample/example.apk');
                $detail = $this->appMarket->byAppId(htmlentities($appId));
                $data   = generateFileNameFromUrl($filePath);
                
                if(isset($data['extension']))
                {
                    $name = str_slug($detail->title).'-1.1.'.$data['extension'];

                    header("Content-Description: File Transfer");
                    header("Content-Type: application/octet-stream");
                    header('Content-Disposition: attachment; filename="'.basename($name).'"');
                    readfile($filePath);
                    exit;
                }
            }
            else
            {
                $versionId        = decrypt($token);
                $detail           = $this->appMarket->byAppId(htmlentities($appId));
                $appMarketVersion = app('Lib\Repositories\AppMarketVersionRepositoryEloquent');

                $versionObj = $appMarketVersion->find($versionId);
                if(!$versionObj)
                    throw new Exception("No version found!..", 1);
                

                if($versionObj->is_link == 1)
                {
                    return redirect()->to($versionObj->app_link);
                }    
                else
                {
                    $filePath = $detail->id.'/apk/'.$versionObj->app_version.'/'.$versionObj->file_path;

                    if(Storage::disk('uploads')->exists( $filePath ))
                    {
                        $data = generateFileNameFromUrl($filePath);
                        if(isset($data['extension']))
                        {
                            $name = str_slug($detail->title).'-'.$versionObj->app_version.'.'.$data['extension'];
                            $pathToFile = public_path('uploads/'.$filePath);

                            header("Content-Description: File Transfer");
                            header("Content-Type: application/octet-stream");
                            header('Content-Disposition: attachment; filename="'.basename($name).'"');
                            readfile($pathToFile);
                            exit;
                        }
                    }
                }
                
               throw new Exception("Download Problem..", 1);  
            }
       
        } catch (Exception $e) {
            return redirect()->route('frontend.index.index');
        }
    }


    /**
    * getCategory()
    * Display Each Market Parent.. ex. App, Games, Themes etc.
    *
    * @return void
    * @access  public
    */
    public function getCategory($identifier)
    {

        $detail = $this->parentCategory->findByIdentifier($identifier);
        if(!$detail)
            abort(404);

        $categories = $detail->categories()->paginate(30);
        return view('frontend.index.parent-category')->with(compact('detail','categories'));
    }

    /**
    * getAndroidCategory()
    * Get Category details and connected apps/games etc.
    *
    * @return void
    * @access  public
    */
    public function getAndroidCategory($identifier = null)
    {

        if($identifier == null)
            return redirect()->route('frontend.index.parent.category','app');

        $obj = $this->category->appsByCategoryIdentifier($identifier);

        $detail = $obj['detail'];
        $apps   = $obj['apps'];

        // track views for category
        Event::fire(new \App\Events\TrackVisitor($detail));

        return view('frontend.index.category')->with(compact('detail','apps'));
    }


    /**
    * getPage()
    *
    * @return void
    * @access  public
    */
    public function getPage($slug)
    {
        
        $detail = $this->page->findBySlug($slug);
        return view('frontend.index.page')->with(compact('detail'));
    }


    /**
    * getReportApp()
    * Detail Information
    *
    * @return void
    * @access  public
    */
    public function getReportApp($app_id = null)
    {
        $detail = collect([]);
        // find $app_id
        if($app_id)
            $detail = $this->appMarket->byAppId(htmlentities($app_id));
        
        return view('frontend.index.report')->with(compact('app_id','detail'));
    }

    /**
    * postReportApp()
    *
    * @return void
    * @access  public
    */
    public function postReportApp()
    {
        $this->validate($this->request, [

            'content_name'       => 'required',
            'name'               => 'required',
            'email_address'      => 'required',
            'report_reason'      => 'required'
        ]);

        $input = $this->request->all();
        
        $config = systemConfig();
        $data = [

            'cms_name'      => $config['cms_name'],
            'message'       => isset($input['message']) ? $input['message'] : '',
            'content_name'  => $input['content_name'],
            'report_reason' => $input['report_reason']
        ];

        Mail::send('emails.report-template', ['data' => $data], function ($message) use ($config,$input) {
            $message->from($input['email_address'], trans('frontend.report_title'));
            $message->subject(trans('frontend.report_title') . ' -  ' . $input['content_name']);
            $message->to($config['contact_email']);
        });

        return redirect()->route('frontend.index.report-app')->with('report-message',trans('frontend.report_mail.success_message'));
    }


    /**
    * getContactUs()
    * Contact us
    *
    * @return void
    * @access  public
    */
    public function getContactUs()
    {
        return view('frontend.index.contact');
    }


    /**
     *
     * getRandomManga()
     *
     * @return template
     * @access  public
     **/
    public function postContactUs()
    {
            
        $this->validate($this->request, [
            'name'    => 'required|min:2',
            'email'   => 'required|email',
            'message' => 'required|min:5'
        ]);
        $input = $this->request->all();

        $config = systemConfig();
        Mail::send('emails.contactus', ['data' => $input], function ($message) use ($config,$input) {

            $email = 'demo-only101@mailinator.com';
            if($config['contact_email'] != '')
                $email = $config['contact_email'];

            $message->from($input['email'], $input['name'])
                    ->to($email, $config['cms_name'])
                    ->subject('Contact Us Form - '.$config['cms_name']);
        });
        session()->flash('success', 'Successfully sent message to us.. We will get back to you!');
        return redirect()->route('frontend.contact');

       
    }

    /**
    *
    * getSearch()
    *
    * @return template
    * @access  public
    **/
    public function getSearch($q = null)
    {   
        $query = request()->has('q') ? request()->get('q') : $q;
        

        $searchItems = $this->appMarket->search($query);

        if(request()->headers->has('X-FROM-AJAX'))
            return $searchItems;
        
        if ( !$searchItems) 
            return redirect()->route('frontend.index.index');
        
        
        return view('frontend.index.search')->with(compact('query','searchItems'));
    }


    /**
     *
     * getRss()
     *
     * @return template
     * @access  public
     **/
    public function getRss()
    {
        
        $feed    = app('Lib\RSSWriter\Feed');
        $channel = app('Lib\RSSWriter\Channel');
        $now     = Carbon::now();
        $config  = systemConfig();

        $channel
            ->title($config['cms_name'])
            ->description($config['cms_description'])
            ->url(url('/'))
            ->language('en-US')
            ->copyright('Copyright '.$now->format('Y').', '.$config['site_author'])
            ->pubDate(strtotime($now->toRssString()) )
            ->lastBuildDate(strtotime($now->toRssString()) )
            ->ttl(60)
            ->pubsubhubbub(url('rss.xml'), 'http://pubsubhubbub.appspot.com')
            ->appendTo($feed);

        
        $appMarket = app('Lib\Repositories\AppMarketRepositoryEloquent');
        $apps      = $appMarket->generateSitemap()->get()->take(100);
           
        if($apps->isEmpty())
            return response($feed)->header('Content-Type', 'application/rss+xml');
        
        foreach ($apps as $key => $list) {

            $item = app('Lib\RSSWriter\Item');
            $item
                ->title($list->title)
                ->description('<div>'.truncate(e($list->description),250).'</div>')
                ->contentEncoded('<div>'.truncate(e($list->description),250) . '</div>')
                ->url($list->detail_url)
                ->author($list->user->email .'('.$list->user->full_name.')')
                ->image(isset($list->appImage) ? $list->appImage->image_link : $list->image_url,100,100)
                ->pubDate(strtotime($list->created_at))
                ->guid($list->detail_url, true)
                ->preferCdata(true) // By this, title and description become CDATA wrapped HTML.
                ->appendTo($channel);
        }
        return response($feed)->header('Content-Type', 'application/rss+xml');
       
    }

    /**
    * getTranslate()
    *
    * @return void
    * @access  public
    */
    public function getTranslate($locale = 'en')
    {

        $locale = htmlentities($locale);
        session()->put('locale',$locale);
        return redirect()->back();
    }
}