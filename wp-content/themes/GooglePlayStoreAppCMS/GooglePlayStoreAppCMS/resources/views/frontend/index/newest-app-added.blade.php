@extends('frontend.layouts.frontend')

@section('site_title')
{{ trans('frontend.index.newest_app') }} | {{ @$configuration['site_title'] }}@stop

@section('meta_description'){{ trans('frontend.index.newest_app') }}@stop


@section('content')
    @if(isset($newestItemLists) && !$newestItemLists->isEmpty())
	    <div class="card">
	        <div class="card-header">
	            <div class="pull-left">
	                {{ trans('frontend.index.newly_added') }}
	            </div>

	            @if(!isset($isViewAll))
	            <div class="pull-right">
	                <a href="{{ route('frontend.index.newest-app') }}" > {{ trans('frontend.common.see_more') }}</a>
	            </div>
	            @endif
	        </div>
	        <div class="card-block">
	            @include('frontend.index.partials.grid',['items' => $newestItemLists])
	        </div>
	        @include('pagination.default', ['paginate' => $newestItemLists])
	    </div>

	@else
	    @include('frontend.index.partials.no-setup')
	@endif
@stop