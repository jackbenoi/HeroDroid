@extends('frontend.layouts.frontend')


@section('site_title')
{{ $detail->title }} | {{ @$configuration['site_title'] }}@stop


@section('meta_keywords'){{ $detail->seo_keywords }}@stop
@section('meta_description'){{ $detail->seo_descriptions }}@stop


@section('content')

<div class="card">
    <div class="card-header">
        <div class="pull-left">
            {{ trans('frontend.common.categories') }} <i class="fa fa-angle-double-right"></i> 
            <a title="{{ $detail->parentCategory->title }}" href="{{ $detail->parentCategory->detail_url }}"> <strong>{{ $detail->parentCategory->title }}</strong>
            </a> 
            <i class="fa fa-angle-double-right"></i> <a title="{{ $detail->title }}" href="{{ $detail->detail_url }}"> 
                <strong>{{ $detail->title }}</strong>
            </a>
        </div>
    </div>
    <div class="card-block">
        <h4><i class="fa fa-{{ @$detail->icon != '' ? $detail->icon : 'android' }}"></i>  {{ $detail->title }}</h4>
        <p>
            {{ $detail->description }}
        </p>
        <hr/>
        @include('frontend.index.partials.grid',['items' => $apps])
        @include('pagination.default', ['paginate' => $apps])

    </div>
</div>

@include('frontend.index.partials.editorspick')
@stop