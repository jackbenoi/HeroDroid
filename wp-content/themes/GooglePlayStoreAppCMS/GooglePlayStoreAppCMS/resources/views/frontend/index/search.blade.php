@extends('frontend.layouts.frontend')

@section('content')


<div class="card">
    <div class="card-header">
        <div class="pull-left">
            <a href="">{!! trans('frontend.common.search_result',['item' => $query]) !!} <i class="fa fa-angle-double-right"></i></a>
        </div>
    </div>
    <div class="card-block">

    	@if(isset($searchItems) && !$searchItems->isEmpty())
        	@include('frontend.index.partials.grid',['items' => $searchItems])
        @else
        	<p class="text-xs-center">
        		{{ trans('frontend.common.no_result_found') }}
        	</p>
        @endif
    </div>
    @if(isset($isViewAll))
        <div>
            @include('pagination.default', ['paginate' => $searchItems])
        </div>
    @endif
</div>

@include('frontend.index.partials.editorspick')
@stop