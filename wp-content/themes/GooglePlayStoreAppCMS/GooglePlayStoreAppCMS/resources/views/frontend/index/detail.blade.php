@extends('frontend.layouts.frontend')

@section('site_title')
{{ ($detail->seo_title != '') ? $detail->seo_title : $detail->title }} | {{ @$configuration['site_title'] }}@stop


@section('meta_item_url'){{ $detail->detail_url }}@stop
@section('meta_item_name'){{ $detail->title }} | {{ @$configuration['site_title'] }}@stop
@section('meta_item_desc'){{ truncate($detail->description,120) }} @stop
@section('meta_item_image'){{ isset($detail->appImage) ? $detail->appImage->image_link : $detail->image_url }}@stop

@section('meta_keywords'){{ $detail->seo_keywords ? $detail->seo_keywords : @$configuration['site_keywords'] }}@stop
@section('meta_description'){{ $detail->seo_descriptions ? $detail->seo_descriptions : @$configuration['site_description'] }}@stop

@section('content')

<div class="card" ng-app="DetailApp">
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
                        <a href="{{ $detail->categories->first()->detail_url }}" title="{{ $detail->categories->first()->title }}">
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
                <img src="{{ firefoxImage(isset($detail->appImage) ? $detail->appImage->image_link : $detail->image_url) }}" alt="{{ $detail->title }}" width="100%" style="padding: 20px;background: #f7f7f7;border-radius: 20px;">
            </div>
            <div class="col-12 col-sm-12 col-md-9 m-t-30" style="padding: 0 20px">
                <div class="row no-gutters">
                    <div class="col-12 col-sm-8">
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
                        <div>
                            <span style="font-size: 1em;">{!! trans('frontend.app_detail.rated_link',['attr' => $detail->ratings]) !!}</span>
                            <br/>
                            <span class="my-ratings" data-ratings='{"max": 5, "value": "{{ $detail->ratings }}" }'></span>
                            <span><i class="fa fa-users"></i> {{ $detail->ratings_total }} {{ trans('frontend.app_detail.total') }}</span>

                        </div>

                        <sn-addthis-toolbox>
                            <a href class="addthis_button_facebook"></a>
                            <a href class="addthis_button_twitter"></a>
                            <a href class="addthis_button_google_plusone_share"></a>
                            <a href class="addthis_button_email"></a>
                            <a href class="addthis_button_compact"></a>
                        </sn-addthis-toolbox>

                         <hr/>
                        <div>
                            <label>
                                {{ trans('frontend.app_detail.additional_info') }}
                            </label>
                            <ul>
                                <li><strong>{{ trans('frontend.app_detail.required_android') }}:</strong> <span style="font-size: 1em;">{{ @$detail->required_android ? $detail->required_android : '--' }}</span>
                                </li>
                                <li><strong>{{ trans('frontend.app_detail.installs') }}:</strong> <span style="font-size: 1em;">{{ @$detail->installs ? $detail->installs : '--' }}</span>
                                </li>
                                <li><strong>{{ trans('frontend.app_detail.updated_at') }}:</strong> <span style="font-size: 1em;">{{ @$detail->published_date ? $detail->published_date : '--' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 text-right">
                        <p >
                            <a  href="#download-page" target="_self" class="btn btn-success" style="white-space: normal;">
                            <i class="fa fa-android"></i>&nbsp; {{ trans('frontend.app_detail.download_apk') }}
                            </a>
                        </p>
                    </div>
                </div>
                
            </div>
            @include('frontend.index.partials.screenshots')
            
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


<div class="card" id="download-page">
    <div class="card-header">
        <div class="pull-left">
            <h5>{{ $detail->title }} {{ trans('frontend.app_detail.apk_version_history') }}</h5>
        </div>
    </div>
    <div class="card-block">
        <div class="row no-gutters">
            @include('frontend.index.partials.versions')
        </div>
    </div>

</div>


@include('frontend.index.partials.related-apps')

@include('frontend.index.partials.reviews')
@include('frontend.index.partials.comments')
@include('frontend.index.partials.rich-snippets')


@stop



@section('scripts')

<script type="text/javascript" src="{{ elixit('assets/js/helper.js') }}"></script>
<script type="text/javascript" src="{{ elixit('assets/js/angular-modules.js') }}"></script>
<script type="text/javascript" src="{{ elixit('assets/js/frontend/detail.js') }}"></script>

<!-- Go to www.addthis.com/dashboard to customize your tools --> 
 <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid={{ $configuration['addthis_code'] }}"></script> 


<script type="text/javascript">
    $(document).ready(function() {

        @if(isset($detail->reviews) && !$detail->reviews->isEmpty())
            $('#reviews').readMoreFade({height:500,text: '{{ trans('frontend.app_detail.read_more_reviews') }}'});
        @endif

        
        $('.owl-carousel').owlCarousel({
                loop: true,
                autoplay:true,
                items : 5,
                slideSpeed : 2000,
                nav: true,
                dots: true,
                loop: false,
                navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>','<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],

                responsiveClass: true,

                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  300: {
                    items: 3,
                    nav: false
                  },
                  1000: {
                    items: 5,
                    nav: true
                  }
                }
        });

    });

</script>

@stop