@extends('frontend.layouts.frontend')

@section('site_title')
{{ trans('frontend.common.download_title') }}{{ $detail->title }} | {{ @$configuration['site_title'] }}@stop


@section('meta_item_url'){{ $detail->detail_url }}@stop
@section('meta_item_name'){{ trans('frontend.common.download_title') }}{{ $detail->title }} | {{ @$configuration['site_title'] }}@stop
@section('meta_item_desc'){{ truncate($detail->description,120) }} @stop
@section('meta_item_image'){{ isset($detail->appImage) ? $detail->appImage->image_link : $detail->image_url }}@stop

@section('meta_keywords'){{ $detail->seo_keywords ? $detail->seo_keywords : @$configuration['site_keywords'] }}@stop
@section('meta_description'){{ $detail->seo_descriptions ? $detail->seo_descriptions : @$configuration['site_description'] }}@stop

@section('content')



<div class="card" >
    <div class="card-header">
        <div class="pull-left">

            <ol class="breadcrumb" style="margin-bottom: 5px;">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                      {{ trans('frontend.common.home') }}
                    </a>
                </li>
                @if(!$detail->categories->isEmpty())

                    <li class="breadcrumb-item">
                        <a href="#">
                          {{ $detail->categories->first()->parentCategory->title }}
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ $detail->categories->first()->title }}" title="{{ $detail->categories->first()->title }}">
                          {{ $detail->categories->first()->title }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active">
                    {{ $detail->title }}
                </li>
            </ol>
          
        </div>
        <div class="pull-right">
            <a href="#" > <i class="fa fa-3x fa-qrcode" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="card-block">
        <div class="row no-gutters">
            <div class="col-12 col-sm-12 col-md-3 app-image text-center">
                <img src="{{ isset($detail->appImage) ? $detail->appImage->image_link : $detail->image_url }}" alt="{{ $detail->title }}" width="100%" style="padding: 20px;background: #f7f7f7;border-radius: 20px;">
            </div>
            <div class="col-12 col-sm-12 col-md-9 m-t-30" style="padding: 0 20px">
                <div class="row no-gutters">
                    <div class="col-12 col-sm-12">
                        <h2>{{ $detail->title }}</h2>
                        <label>
                            @if($detail->is_submitted_app == 1)
                                {{ trans('frontend.app_detail.by') }} <a href="{{ $detail->developer_link }}" title="{{ $detail->user->full_name }}">
                                {{ $detail->user->full_name }}
                                </a>
                            @else
                                {{ trans('frontend.app_detail.by') }} <a href="{{ $detail->developer_link }}" title="{{ $detail->developer_name }}">
                                {{ $detail->developer_name }}
                                </a>
                            @endif
                        </label>

                        <div>
                            {{ trans('frontend.app_detail.views') }}: <i class="fa fa-eye" aria-hidden="true"></i> <span style="font-size: 1em;">{{ countFormat(@$detail->statistic->views) }}</span>
                        </div>
                       
                    </div>
                    <div class="col-12 col-sm-12">
                        <hr/>
                        <p class="pull-right">
                            <div class="card">
                                <div class="card-block">
                                    <div class="h5 m-b-0">
                                        {{ trans('frontend.app_detail.automatic_download') }} <i class="icon-speedometer"></i> <span id="timer">0</span> {{ trans('frontend.app_detail.seconds') }}
                                    </div>
                                    <small class="text-muted text-uppercase font-weight-bold">{{ trans('frontend.app_detail.remaining_time') }}</small>

                                    @if($versionId == 'api')
                                        {{ Form::open(['accept-charset'=>'UTF-8', 'url' =>  route('frontend.download.api'), 'method' => 'POST','id' => 'download-app']) }}
                                            <input type="hidden" name="app_url" value="{{ $detail->detail_url }}">
                                            <input type="hidden" name="app_id" value="{{ encrypt($detail->app_id) }}">
                                            <input type="hidden" name="token" value="{{ encrypt('api') }}">
                                            <input type="hidden" name="app_title" value="{{ $detail->title }}">

                                            <button type="submit" class="btn btn-block btn-danger animated infinite pulse">
                                                {{ trans('frontend.app_detail.manual_download_latest_version') }} - {{ $detail->title }}
                                            </button>
                                        {{ Form::close() }}
                                    @else
                                        <a href="{{ $dlURL }}" class="btn btn-block btn-danger animated infinite pulse">
                                            {{ trans('frontend.app_detail.manual_download_latest_version') }} - {{ $detail->title }}
                                        </a>

                                    @endif
                                </div>
                            </div>
                        </p>

                    </div>
                </div>
                
            </div>
            
        </div>

    </div>

    <div class="card text-center">
        <div class="card-block">
            {!! showAds('footer_ads') !!}
        </div>
    </div>

    <div class="card-footer text-muted">
        <div class="row no-gutters">
            <div class="col-12 col-md-6" style="text-align: left;">
                <a href="{{ $detail->link }}" class="btn btn btn-sm bg-success-light" target="_blank">
                    <i class="fa fa-android"></i> {{ trans('frontend.common.playstore_link') }}
                </a>
            </div>
            <div class="col-12 col-md-6 " style="text-align: right;">
               <a href="{{ route('frontend.index.report-app',$detail->app_id) }}" class="btn btn-sm bg-danger-darker">
                <i class="fa fa-flag-o"></i> {{ trans('frontend.common.report_app') }}
               </a>
            </div>
        </div>
    </div>
</div>




@include('frontend.index.partials.description')
@include('frontend.index.partials.related-apps')

@include('frontend.index.partials.comments')
@include('frontend.index.partials.rich-snippets')

@stop

@section('scripts')

<script type="text/javascript">

    var startDl = false;
    @if($versionId !='api')
        redirect = "{{ @$dlURL }}";
        startDl = true;
    @else
        var redirect = "{{ @$dlURL }}";
    @endif 


    function autoDownload()
    {
        jQuery(document).ready(function($) {
            $("#download-app").submit();
            window.close();
        });
    }
    var count = 10;
    function countDown(){
        var timer = document.getElementById("timer");
        if(count > 0){
            count--;
            timer.innerHTML = count;
            setTimeout(countDown, 1000);
        }else{

            @if($versionId !='api')
                window.location.href = redirect;
            @else
                autoDownload();
            @endif
        }
    }
    countDown();
</script>

@stop