@extends('backend.layouts.backend')

@section('menu') Parent Categories
@stop
@section('content')


<div class="row" ng-controller="ParentCategoryController">
    <div class="col-xs-12 col-md-12 col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header ">
                <h4 class="card-title">
                    Category Informations |  <a href="{{ route('backend.category.detail')}}" class="btn btn-sm bg-dark"> Create Main Category</a>
                </h4>
            </div>
            <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped m-b-0">
                            <thead>
                                <tr>
                                    <th width="120">
                                        Name
                                    </th>
                                    <th  width="100">
                                        Status
                                    </th>
                                    <th class="text-center" align="center" width="100" style="text-align: center;">
                                       Action
                                    </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th width="120">
                                        Name
                                    </th>
                                    <th  width="100">
                                        Status
                                    </th>
                                    <th class="text-center" align="center" width="100" style="text-align: center;">
                                       Action
                                    </th>
                                </tr>
                            </tfoot>
                            <tbody block-ui="blockui-effect">
                                 <tr class="items ng-cloak" ng-repeat="list in data track by $index">
                                    <td>
                                         <div uib-tooltip="@{{ list.title }}"><i class="fa fa-@{{ list.icon }}"></i> @{{ list.title | truncateStr:35 }} </div>
                                    </td>
                                    <td>
                                        @{{ list.is_enabled == '1' ? 'Enabled' : "Disabled"}}
                                    </td>
                                    <td align="center">
                                        
                                        <a uib-tooltip="View Sub-categories for @{{ list.title }}" href="{{ route('backend.sub.category.index') }}/@{{ list.id }}" class="btn btn-sm  bg-dark">
                                             <i class="fa fa-eye"></i>
                                              Categories
                                        </a>
                                        <a uib-tooltip="Edit @{{ list.title }}" href="@{{ list.backend_detail_url }}" class="btn btn-sm  btn-info">
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
</div>
@stop
@include('backend.category.partials.js')