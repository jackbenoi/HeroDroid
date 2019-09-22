@extends('backend.layouts.backend')

@section('menu') Generate Sitemap
@stop

@section('content')
<div class="row" >
    <div class="card">
        <div class="card-header ">
            <h4 class="card-title">
                Generate Sitemap 

                @if(!$isDemo)
                    @if(isset($sitemapArray))
                        @if(count($sitemapArray) > 0)
                            {{ Form::open(['accept-charset'=>'UTF-8', 'url' => route('backend.sitemap.clear'), 'method' => 'POST']) }}
                                <button type="submit" class="btn btn-sm btn-default"> Clear All</button>
                            {{ Form::close() }}
                        @endif
                    @endif
                @endif
            </h4>
        </div>
        <div class="card-block">
           <div block-ui="blockui-effect" ng-cloak>

                <div class="col-xs-12">
                    @if($isDemo)
                            @include('backend.layouts.common.demo-btn')
                    @else
                        {{ Form::open(['accept-charset'=>'UTF-8', 'url' => route('backend.sitemap.apps'), 'method' => 'POST']) }}
                            <strong>Apps Sitemap</strong> - <button type="submit" class="btn btn-sm btn-default"> Generate </button>
                        {{ Form::close() }}
                    @endif
                    <div class="col-md-12">
                        @if(isset($sitemapArray) && isset($sitemapArray['apps']) )

                            <label>App Index Url: 
                                <strong>
                                    <a href="{{ $sitemapArray['apps']['url'] }}">
                                            {{ $sitemapArray['apps']['url'] }}
                                    </a>
                                </strong>
                            </label>
                            <ul class="list-group">
                            @foreach($sitemapArray['apps']['sitemaps'] as $item)
                                <li  class="list-group-item">
                                    <a target="_blank" href="{{ $item }}">
                                        {{ $item }}
                                    </a>
                                </li>
                            @endforeach
                            </ul>
                        @else
                            <div class="text-xs-center">No apps sitemap generate</div>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <hr/>
                </div>
                <div class="col-xs-12">
                    @if($isDemo)
                            @include('backend.layouts.common.demo-btn')
                    @else
                        {{ Form::open(['accept-charset'=>'UTF-8', 'url' => route('backend.sitemap.category'), 'method' => 'POST']) }}
                            <strong>Categories Sitemap</strong> - <button type="submit" class="btn btn-sm btn-default"> Generate </button>
                        {{ Form::close() }}
                    @endif

                    <div class="col-md-12">
                        @if(isset($sitemapArray) && isset($sitemapArray['categories']) )

                            <label>App Index Url: 
                                <strong>
                                    <a href="{{ $sitemapArray['categories']['url'] }}">
                                            {{ $sitemapArray['categories']['url'] }}
                                    </a>
                                </strong>
                            </label>
                            <ul class="list-group">
                            @foreach($sitemapArray['categories']['sitemaps'] as $item)
                                <li  class="list-group-item">
                                    <a target="_blank" href="{{ $item }}">
                                        {{ $item }}
                                    </a>
                                </li>
                            @endforeach
                            </ul>
                        @else
                            <div class="text-xs-center">No categories sitemap generate</div>
                        @endif
                    </div>
                </div>

                @if(isset($sitemapArray))

                    @if(count($sitemapArray) > 0)
                        <div class="col-md-12">
                            <hr/>
                        </div>
                        <div class="col-md-12">
                            <label>Sitemap Index Url: 
                            </label>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a target="_blank" href="{{ url('sitemap/sitemap.xml')  }}">
                                            {{ url('sitemap/sitemap.xml')  }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                @endif
            </div>
        </div> 

        </div>
    </div>
</div>

@stop