@section('dl-from-api')

<div class="card panel panel-default m-b-xs">

    <div class="card-header panel-heading" role="tab" >
        <h5 class="panel-title m-a-0">
            <a data-toggle="collapse" title="{{ trans('frontend.app_detail.download_latest_version') }} - {{ $detail->title }}">
                {{ trans('frontend.app_detail.download_latest_version') }}
            </a>
        </h5>
    </div>
    <div class="card-block"> 

        @if($isDemo)
            <a href="{{ $detail->detail_url }}" class="btn btn-block btn-danger animated infinite pulse">
                {{ trans('frontend.app_detail.download_latest_version') }} - {{ $detail->title }} (DEMO MODE)
            </a>
        @else
            
             <a href="{{ downloadLink($detail->title,$detail->app_id,'api') }}" class="btn btn-block btn-danger animated infinite pulse">
                {{ trans('frontend.app_detail.download_latest_version') }} - {{ $detail->title }}
            </a>

        @endif
    </div>
</div>
@stop

<div class="col-12 col-sm-12 col-md-12" >
               
    <div id="accordion" role="tablist" aria-multiselectable="true">

        @if($isDemo)

            @yield('dl-from-api')
            <a href="{{ downloadLink($detail->title,$detail->app_id,'1.1') }}" title="Download {{ $detail->title }} - 1.1 version" class="btn btn-block btn-success">{{ trans('frontend.app_detail.download_apk') }} 1.1 - {{ formattedFileSize(70000,true)  }} (DEMO MODE)</a>
        @else
            
            {{-- @if(isset($detail->versions) && !$detail->versions->isEmpty()) --}}

                {{-- @if(@$configuration['purchase_code'] && @$configuration['buyer_username'])
                    @yield('dl-from-api')
                @endif --}}
                <div class="card panel panel-default m-b-xs ">
                    <div class="card-header panel-heading" role="tab" id="no-result">
                        <h6 class="panel-title m-a-0 text-center">

                            @if(@$configuration['purchase_code'] && @$configuration['buyer_username'])

                               @yield('dl-from-api')
                                
                            @endif
                            <a href="{{ $detail->link }}" target="_blank" title="Download {{ $detail->title }} from google play store" class="btn btn-block btn-success">{{ trans('frontend.app_detail.download_apk') }} - {{ $detail->title }} <i class="fa fa-external-link"></i></a>
                            
                        </h6>
                    </div>
                </div>
                @if(isset($detail->versions) && !$detail->versions->isEmpty())
                    <h6 class="panel-title m-a-0 text-center">Download from other sources</h6>
                    <hr/>
                    @foreach($detail->versions as $key => $version)
                        <div class="card panel panel-default m-b-xs">
                            <div class="card-header panel-heading" role="tab" id="#hversion-{{ $key }}">
                                <h5 class="panel-title m-a-0">
                                    <a data-toggle="collapse" title="{{ trans('frontend.common.download') }} {{ $detail->title }} - {{ $version->app_version }}" data-parent="#accordion" href="#version-{{ $key }}" aria-expanded="true" aria-controls="version-{{ $key }}" class="">
                                    {{ trans('frontend.common.download') }} {{ $detail->title }} - {{ $version->app_version }}
                                    </a>
                                </h5>
                            </div>
                            <div id="version-{{ $key }}" class="card-block panel-collapse collapse @if ($key == 0) in @endif" role="tabpanel" aria-labelledby="#hversion-{{ $key }}" aria-expanded="true">
                                <ul>
                                    @if($version->app_version)
                                    <li>
                                        <strong>{{ trans('frontend.common.version') }}</strong>: {{ $version->app_version }}
                                    </li>
                                    @endif
                                    @if($version->signature)
                                    <li>
                                        <strong>{{ trans('frontend.common.signature') }}</strong>: {{ $version->signature }}
                                    </li>
                                    @endif
                                    @if($version->sha_1)
                                    <li>
                                        <strong>{{ trans('frontend.common.apk_sha1') }}</strong>: {{ $version->sha_1 }}
                                    </li>
                                    @endif
                                </ul>
                                <a href="{{ downloadLink($detail->title,$detail->app_id,$version->id) }}" title="Download {{ $detail->title }} - {{ $version->app_version }} version" class="btn btn-block btn-success">{{ trans('frontend.app_detail.download_apk') }} {{ $version->app_version }} @if($version->size != 0)({{ formattedFileSize($version->size,true) }})@endif</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            {{-- @else --}}
                {{-- <div class="card panel panel-default m-b-xs ">
                    <div class="card-header panel-heading" role="tab" id="no-result">
                        <h6 class="panel-title m-a-0 text-center">

                            @if(@$configuration['purchase_code'] && @$configuration['buyer_username'])

                               @yield('dl-from-api')
                                
                            @endif
                            <a href="{{ $detail->link }}" target="_blank" title="Download {{ $detail->title }} from google play store" class="btn btn-block btn-success">{{ trans('frontend.app_detail.download_apk') }} - {{ $detail->title }} <i class="fa fa-external-link"></i></a>
                            
                        </h6>
                    </div>
                </div> --}}
            {{-- @endif --}}

        @endif
    </div>
</div>