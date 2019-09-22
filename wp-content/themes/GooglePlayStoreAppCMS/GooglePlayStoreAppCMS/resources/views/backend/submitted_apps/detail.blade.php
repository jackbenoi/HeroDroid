@extends('backend.layouts.backend')


@section('stylesheets')
<style type="text/css">
    .chosen-container {
        width: 100% !important;
    }
</style>

@stop
@section('menu') Submitted App Collections
@stop

@section('content')

<div class="row" ng-controller="AppsController">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header ">
                <h4 class="card-title">
                    <a class="btn btn-sm btn-default" href="{{ route('backend.apps.index') }}">
                    <i class="fa fa-arrow-left"></i> Go Back</a>
                    |
                    @if(isset($is_create) && $is_create == 1)
                    Create New Apps
                    @else
                    Update Apps Information
                    @endif
                </h4>
            </div>

            <div class="card-block" block-ui="blockui-effect">

               


            </div>

        </div>
    </div>
</div>
@stop
@include('backend.apps.partials.js')