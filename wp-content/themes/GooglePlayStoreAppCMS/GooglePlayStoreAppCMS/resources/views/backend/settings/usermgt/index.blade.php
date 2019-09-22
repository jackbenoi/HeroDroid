@extends('backend.layouts.backend')

@section('menu') User Management
@stop

@section('content')
<div class="row" ng-controller="UserController">
    <div class="card">
        <div class="card-header ">
            <h4 class="card-title">
                User Management |  <a href="{{ route('backend.setting.usermgt.detail')}}" class="btn btn-sm bg-dark"> Create New User</a>
            </h4>
        </div>
        <div class="card-block">
            <div block-ui="blockui-effect" ng-cloak>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped m-b-0">
                            <thead>
                                <tr>
                                    <th width="10">
                                        
                                    </th>
                                    <th width="120">
                                        First Name
                                    </th>
                                    <th  width="100">
                                        Last Name
                                    </th>
                                    <th width="120">
                                        Email
                                    </th>
                                    <th class="text-center" align="center" width="100" style="text-align: center;">
                                       Action
                                    </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th width="10">
                                        
                                    </th>
                                    <th width="120">
                                        First Name
                                    </th>
                                    <th  width="100">
                                        Last Name
                                    </th>
                                    <th width="120">
                                        Email
                                    </th>
                                    <th class="text-center" align="center" width="100" style="text-align: center;">
                                       Action
                                    </th>
                                </tr>
                            </tfoot>
                            <tbody block-ui="blockui-effect">
                                 <tr class="items ng-cloak" ng-repeat="list in data track by $index">
                                    <td>
                                         <div uib-tooltip="@{{ list.id }}"> @{{ list.id }} </div>
                                    </td>
                                    <td>
                                         <div uib-tooltip="@{{ list.first_name }}"> @{{ list.first_name | truncateStr:35 }} </div>
                                    </td>
                                    <td>
                                        <div uib-tooltip="@{{ list.last_name }}"> @{{ list.last_name | truncateStr:35 }} </div>
                                    </td>
                                    <td>
                                        <div uib-tooltip="@{{ list.email }}"> @{{ list.email | truncateStr:35 }} </div>
                                    </td>
                                    <td align="center">
                                        
                                        <a uib-tooltip="Edit @{{ list.title }}" href="@{{ list.backend_detail_url }}" class="btn btn-sm  btn-info">
                                             <i class="fa fa-pencil"></i>
                                        </a>
                                        @if($isDemo)
                                           @include('backend.layouts.common.demo-btn')
                                        @else
                                            <button uib-tooltip="Delete @{{ list.title }}" ng-click="delModal(list)" class="btn btn-sm btn-danger">
                                               <i class="fa fa-remove"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                <tr ng-if="data.length == 0">
                                  <td  align="center" mode="simple" colspan="3">No Result Found!</td>
                                </tr>
                                
                            </tbody>
                        </table>
                        <nav class="pull-right">
                            <pagination-directive class="pull-right"></pagination-directive>
                        </nav>
                    </div>
                </div>
            </div>
        </div> 
        {{-- <div class="card-footer text-muted">
            @if($isDemo)
               @include('backend.layouts.common.demo-btn')
            @else
                <button type="submit" class="btn btn-sm btn-primary" ng-click="update(details)">Save Changes</button>
            @endif
        </div>    
        --}}
    </div>
</div>


@stop
@include('backend.settings.usermgt.partials.js')