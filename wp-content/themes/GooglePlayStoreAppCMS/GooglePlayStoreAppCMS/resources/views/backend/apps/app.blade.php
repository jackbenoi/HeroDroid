@extends('backend.layouts.backend')

@section('menu') App Collections
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
                    Create New Apps/Games from Playstore
                </h4>
            </div>

            <div class="card-block">

                <div class="well">

                    <div class="form-group">
                      <label for="search"><strong>Search App/Games from GooglePlayStore</strong></label>
                      <input type="text" class="form-control ng-pristine ng-untouched ng-valid ng-empty" name="search" ng-model="details.search" placeholder="ex. Facebook, Messenger">
                    </div>

                    <div class="form-group">
                      <button class="btn btn-success btn-block" ng-click="searchFromGooglePlay()"> <i class="material-icons" aria-hidden="true">android</i> Search App/Games </button>
                    </div>
                </div>
            </div>

            <div class="card-block">

                <div class="form-group">
                    @if($isDemo)
                      <button class="btn btn-default"><i class="material-icons" aria-hidden="true">import_export</i>  Demo Mode Cannot Import</button>
                    @else
                      <button class="btn btn-default" ng-click="searchBulkAction()"><i class="material-icons" aria-hidden="true">import_export</i> Import All Selected App/Games</button>
                    @endif
                </div>
                <div class="form-group">
                    <label >Save Import App/Games to the selected categories</label>
                    <select class="form-control ng-cloak"
                        chosen
                        multiple 
                        ng-options="category.title group by category.group for category in categories"
                        data-placeholder-text-single="'Select Categories'"
                        ng-model="categoryObj.list">
                        <option value=""></option>
                    </select>
                </div>


                <table class="table table-bordered table-custom">
                  <thead>
                    <tr >
                      <th width="10" style="text-align: center;">
                          <input type="checkbox" id="checkbox-fa-light-1" ng-model="details.allItemsSelected" ng-change="searchSelectAll()">
                      </th>
                      <th width="10" >Preview</th>
                      <th width="200">App/Game Name</th>
                      <th width="200">Developer</th>
                      <th width="10">Action</th>
                    </tr>
                  </thead>
                  <tbody block-ui="search-result">
                    <tr class="items ng-cloak" ng-repeat="list in appLists track by $index">
                      <td align="center">
                            <input type="checkbox" ng-model="list.is_checked" ng-change="searchSelectedItem()">
                      </td>
                      <td align="center">
                        <img ng-src="@{{ list.image.small }}" width="50">
                      </td>
                      <td>
                        @{{ list.title }}
                      </td>
                      <td>
                        @{{ list.developer.name }}
                      </td>
                      <td>

                          @if($isDemo)
                            @include('backend.layouts.common.demo-btn')
                          @else
                            <button class="btn btn-info btn-sm" ng-click="importApp(list)">
                              <i class="fa fa-download"></i> Import 
                            </button>
                          @endif
                      </td>
                    </tr>
                    <tr ng-if="appLists.length == 0">
                        <td align="center" mode="simple" colspan="5">No Result Found!</td>
                    </tr>
                  </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@stop
@include('backend.apps.partials.js')