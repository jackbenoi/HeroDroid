@extends('frontend.layouts.frontend')

@section('site_title')
{{ trans('frontend.index.editors_pick') }} | {{ @$configuration['site_title'] }}@stop

@section('meta_description'){{ trans('frontend.index.editors_pick_meta_description') }}@stop


@section('content')
    @include('frontend.index.partials.editorspick')
@stop