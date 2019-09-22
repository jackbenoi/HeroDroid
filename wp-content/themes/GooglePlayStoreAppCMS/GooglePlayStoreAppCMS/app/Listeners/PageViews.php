<?php

namespace App\Listeners;

use App\Events\TrackVisitor;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PageViews
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TrackVisitor  $event
     * @return void
     */
    public function handle(TrackVisitor $event)
    {

        $numberOfViews = session()->get($event->sessName, []);

        if(!array_key_exists($event->modelObj->id, $numberOfViews))
        {
            if($event->sessName == 'views')
            {
                if($event->modelObj->statistic)
                    $event->modelObj->statistic->increment('views');
                else
                    $event->modelObj->statistic()->create(['views' => 1]);
            }

            $viewKey = $event->sessName.'.'.$event->modelObj->id;

            
            session()->put($viewKey,time());
            session()->save();
        }
        return false;
    }

    /**
     * Handle the event.
     *
     * @param  TrackVisitor  $event
     * @return void
     */
    public function viewThrottle($sesionName = 'views')
    {

        // Get all the viewed model from the session. If no
        // entry in the session exists, default to null.
        $checkSessionData = session()->get($sesionName,null);
        if(! is_null($checkSessionData) )
        {
            $time = time();

            // Expire Views after 1 day.
            $throttleTime = 86400;

            // Filter through the post array. The argument passed to the
            // function will be the value from the array, which is the
            // timestamp in our case.
            $getTimestamp = array_filter($checkSessionData, function ($timestamp) use ($time, $throttleTime)
            {
                // If the view timestamp + the throttle time is 
                // still after the current timestamp the view  
                // has not expired yet, so we want to keep it.
                return ($timestamp + $throttleTime) > $time;
            });
            session()->put($sesionName,$getTimestamp);
        }
        return false;
    }
}