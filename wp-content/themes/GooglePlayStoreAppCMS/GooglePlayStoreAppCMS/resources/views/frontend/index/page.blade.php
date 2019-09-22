@extends('frontend.layouts.frontend')


@section('site_title')
{{ $detail->seo_title | $detail->title }} | {{ @$configuration['site_title'] }}@stop

@section('meta_description'){{ $detail->seo_descriptions ? $detail->seo_descriptions :  @$configuration['site_description'] }}@stop

@section('meta_keywords'){{ $detail->seo_keywords ? $detail->seo_keywords :  @$configuration['site_keywords'] }}@stop


@section('content')

<div class="card">
    <div class="card-header">
        <div class="pull-left">
            <a href="{{ url('/') }}" title="{{ trans('frontend.common.home') }}">{{ trans('frontend.common.home') }} <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
            <a href="{{ $detail->detail_url }}" title="{{ $detail->title }}">{{ $detail->title }} </a>
        </div>
       
    </div>
    
    <div class="card-block">
        <p>
            {!! nl2br($detail->content) !!}
        </p>
    </div>
   
    </form>
</div>

@stop