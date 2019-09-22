
@extends('backend.layouts.backend')

@section('menu') App Collections
@stop
@section('content')

<div class="row" ng-controller="SubmittedAppController">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header ">
                <h4 class="card-title">
                    Review Submitted Apps Informations
                </h4>
            </div>

            <div class="card-block">
                <div class="input-group">
                        <input class="form-control" ng-model="details.search" placeholder="Search for apps or games title" key-bind="{ enter: 'search()'}">
                        <span class="input-group-btn"> 
                            <button class="btn btn-primary" ng-click="search()" type="button">Go!</button> 
                            <button class="btn btn-default" ng-click="clearAll()" type="button">Clear All</button> 
                        </span> 
                    </div> 

                    <div class="input-group">
                        <div class="form-group">
                            <label for="data">Show Data Per Page</label>
                            <select class="form-control"
                                ng-options="page | number for page  in perPageArray "
                                data-placeholder="Show Data Per Page"
                                ng-model="details.per_page"
                                ng-change="perPageChange(details.per_page)">
                            </select>
                        </div>
                    </div>

                    <div class="input-group">
                        <strong>Filter by Letter</strong>
                        <div class="well well-sm" style="text-align: center;margin:5px 0px;padding: 20px;background: #f5f5f5;">
                            <div class="text-center" ng-cloak>
                                <a style="color: #ffffff;"  class="btn btn-success btn-circle" ng-click="letterFilter('')"> All </a>
                                <a style="color: #ffffff;" ng-repeat="letter in letters track by $index" ng-class="{'active': letter == details.letter}" class="btn btn-success btn-circle" ng-model="details.letter" ng-click="letterFilter(letter)"> @{{ letter }} </a>
                            </div>
                        </div>
                    </div>

                    
                    <table class="table table-bordered table-striped m-b-0">
                        <thead>
                            <tr>
                                <th width="10">
                                </th>
                                <th width="100">
                                    AppName
                                </th>
                                <th width="50">
                                    Developer
                                </th>
                                <th width="50">
                                    Status
                                </th>
                                <th width="100" class="text-center" align="center"  style="text-align: center;">
                                   Action
                                </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th width="10">
                                </th>
                                <th width="100">
                                    AppName
                                </th>
                                <th width="50">
                                    Developer
                                </th>
                                <th width="50">
                                    Status
                                </th>
                                <th width="100" class="text-center" align="center"  style="text-align: center;">
                                   Action
                                </th>
                            </tr>
                        </tfoot>
                        <tbody block-ui="blockui-effect">
                            
                            <tr class="items ng-cloak" ng-repeat="list in data track by $index">
                                <td>
                                     <div uib-tooltip="@{{ list.title }}" style="text-align: center;">
                                         <img ng-src="@{{ list.image_url || list.app_image.image_link }}"  width="30px">
                                     </div>
                                </td>
                               
                                <td>
                                     <div uib-tooltip="@{{ list.title }}">@{{ list.title | truncateStr:30 }}</div>
                                </td>
                                <td>
                                     <div uib-tooltip="@{{ list.developer_name }}">@{{ list.developer_name | truncateStr:30 }}</div>
                                </td>
                                <td>
                                    <div uib-tooltip="@{{ list.is_enabled == '1' ? 'Approve' : 'Pending'}}">
                                        <button class="btn btn-sm btn-@{{ list.is_enabled == '1' ? 'success' : 'danger'}}">
                                            @{{ list.is_enabled == '1' ? 'Approve' : "Pending"}}
                                        </button>
                                    </div>
                                </td>
                                <td align="center">
                                    <a uib-tooltip="Review App @{{ list.title }}" href="@{{ list.backend_detail_url }}" class="btn btn-sm  btn-info">
                                         <i class="fa fa-pencil"></i>
                                    </a>
                                    @if($isDemo)
                                       @include('backend.layouts.common.demo-btn')
                                    @else
                                        <button uib-tooltip="Delete @{{ list.title }}" ng-click="delModal(list)" class="btn btn-sm  btn-danger">
                                           <i class="fa fa-remove"></i>
                                         </button>
                                    @endif
                                </td>
                            </tr>
                            <tr ng-if="data.length == 0">
                              <td  align="center" mode="simple" colspan="6">No Result Found!</td>
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
@stop
@include('backend.submitted_apps.partials.js')