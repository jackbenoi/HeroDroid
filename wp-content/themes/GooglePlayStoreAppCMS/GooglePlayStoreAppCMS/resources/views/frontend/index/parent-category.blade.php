@extends('frontend.layouts.frontend')

@section('site_title')
{{ $detail->seo_title | $detail->title }} | {{ @$configuration['site_title'] }}@stop

@section('meta_description'){{ $detail->seo_descriptions ? $detail->seo_descriptions :  @$configuration['site_description'] }}@stop

@section('meta_keywords'){{ $detail->seo_keywords ? $detail->seo_keywords :  @$configuration['site_keywords'] }}@stop


@section('content')

<div class="card">
    <div class="card-header">
        <div class="pull-left">
            {{ trans('frontend.common.categories') }} <i class="fa fa-angle-double-right"></i> <a title="{{ $detail->title }}" href="{{ $detail->detail_url }}"> <strong>{{ $detail->title }}</strong></a>
        </div>
    </div>
    <div class="card-block">
        <h4> <i class="fa fa-{{ @$detail->icon != '' ? $detail->icon : 'android' }}"></i>  {{ $detail->title }}</h4>
        <p>
            {!! nl2br($detail->description) !!}
        </p>
        <hr/>
    </div>
    <div class="card-block">
        <h4>{{ trans('frontend.common.categories') }}</h4>
        <p>
        @if(isset($categories) and !$categories->isEmpty())
            @foreach($categories as $item)
                <div class="col-xs-6 col-sm-6 col-md-4">
                    <div class="card">
                        <a href="{{ $item->detail_url }}" title="{{ $item->title }}" class="btn btn-block btn-icon btn-outline-success m-r-xs m-b-xs">
                          <i class="fa fa-{{ @$item->icon != '' ? $item->icon : 'android' }}"></i> <span>
                            {{ $item->title }}
                          </span> 
                        </a>
                    </div>
                </div>
            @endforeach
            <div class="col-xs-12">
            @include('pagination.default', ['paginate' => $categories])
            </div>
        @else
            <a title="{{ $detail->title }}" href="{{ $detail->detail_url }}" class="btn btn-block btn-icon btn-outline-success m-r-xs m-b-xs">
              <i class="material-icons">
                android
              </i><span>
               {{ trans('frontend.common.no_category') }}
              </span> 
            </a>
        @endif
        </p>
    </div>
</div>
@include('frontend.index.partials.editorspick')
@stop