@extends('backend.layouts.backend')

@section('menu') Ads
@stop

@section('content')
<div class="row" ng-controller="AdsController">
    <div class="card">
        <div class="card-header ">
            <h4 class="card-title">
                Ads Informations
            </h4>
        </div>
        <div class="card-block" ng-cloak>
           
           <div class="col-xs-12 row" block-ui="blockui-new">
                <h4>Add New Block Lists <button ng-click="clearBlock()" class="btn btn-md btn-info"><i class="fa fa-plus"></i> New</button></h4>
                 <div class="col-xs-12 col-md-12">
                  <div class="form-group row">
                     <label for="identifier">Ads Code (use this code to place anywhere in the page) Ex. <code><?php echo "{!! showAds('leaderboard') !!}"; ?></code> </label>
                      <input type="text" ng-model="details.identifier" class="form-control" id="identifier" placeholder="Ads Code">
                  </div>
                </div>
                <div class="col-xs-12 col-md-12">
                  <div class="form-group row">
                     <label for="title">Block Name </label>
                      <input type="text" ng-model="details.title" class="form-control" id="title" placeholder="Block Name">
                  </div>
                </div>
                <div class="col-xs-12 col-md-12">
                  <div class="form-group row">
                     <label for="description">Block Content (Html/Text) </label>
                      <textarea class="form-control" rows="5" ng-model="details.code"></textarea>
                  </div>
                </div>
                <div class="col-xs-12 col-md-12">
                  <div class="form-group row">
                      <button ng-if="!isEdit" uib-tooltip="Add New Block" ng-click="addData()" class="btn btn-md btn-primary btn-block">
                         <i class="fa fa-pencil"></i> Add Block
                      </button>
                      @if($isDemo)
                         <button ng-if="isEdit" uib-tooltip="Update Ads Block" class="btn btn-md btn-warning btn-block">
                           <i class="fa fa-pencil"></i> Demo Mode Active
                        </button>
                      @else
                        <button ng-if="isEdit" uib-tooltip="Update Ads Block" ng-click="updateData(details)" class="btn btn-md btn-primary btn-block">
                           <i class="fa fa-pencil"></i> Update Ads Block
                        </button>
                      @endif
                  </div>
                </div>
            </div>
            <hr/>
            <h4>Ads Block Lists</h4>
            <div class="col-xs-12 col-md-12">
              <div class="form-group row">
                <nav class="pull-right">
                    <pagination-directive ></pagination-directive>
                </nav>
                 <table class="table table-bordered table-custom" block-ui="blockui-table">
                  <thead>
                    <tr>
                      <th width="10" class="text-center">ID</th>
                      <th width="60">Ads Code</th>
                      <th width="60">Name</th>
                      <th width="30" class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="items ng-cloak" ng-repeat="block in data track by block.id">
                      <td class="text-center">@{{ block.id }}</td>
                      <td><strong>@{{ block.identifier }}</strong></td>
                      <td>@{{ block.title }}</td>
                      <td class="text-center">
                        <button uib-tooltip="Edit @{{  block.title }}" ng-click="editData(block)" class="btn btn-sm btn-orange">
                           <i class="fa fa-pencil"></i> Edit
                        </button>
                        @if($isDemo)
                         @include('backend.layouts.common.demo-btn')
                        @else
                          <button uib-tooltip="Delete @{{ block.title}}" ng-click="delModal(block)" class="btn btn-sm btn-danger">
                             <i class="fa fa-remove"></i>
                          </button>
                        @endif
                      </td>
                    </tr>
                    <tr ng-if="data.length == 0">
                      <td class="text-center" mode="simple" colspan="3">No Result Found!</td>
                    </tr>
                  </tbody>
                </table>
                <nav class="pull-right">
                    <pagination-directive ></pagination-directive>
                </nav>
              </div>
            </div>
            
        </div>
    </div>
</div>

@stop
@include('backend.settings.ads.partials.js')