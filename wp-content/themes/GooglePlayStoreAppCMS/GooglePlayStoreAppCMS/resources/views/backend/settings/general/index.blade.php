@extends('backend.layouts.backend')

@section('menu') General
@stop

@section('content')
<div class="row" ng-controller="GeneralController">
    <div class="card">
        <div class="card-header ">
            <h4 class="card-title">
                General Informations
            </h4>
        </div>
        <div class="card-block">
           <div block-ui="blockui-effect" ng-cloak>


                <ul class="nav nav-tabs" role="tablist">


                    <li class="nav-item" ng-repeat="(key,detail) in details track by $index">
                        <a class="nav-link" ng-class="{'active': $index == 0}" data-toggle="tab" href="#@{{ key }}" role="tab">
                        @{{ detail.title  }}</a>
                    </li>
                   
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    <div class="tab-pane active" id="general_informations" role="tabpanel">
                        
                        <div ng-repeat="detail in details.general_informations.lists track by $index" ng-if="detail.key != 'app_version'">
                            <div class="sub-title">
                                <strong>@{{ detail.name }}</strong>
                            </div>

                            <div ng-if="detail.key != 'cms_upload_logo'">
                                <input type="text" class="form-control" ng-model="detail.value" name="@{{ detail.key }}" placeholder="@{{ detail.name }}" >
                                <small>@{{ detail.description }}</small>
                            </div>

                            <div class="row" ng-if="detail.key == 'cms_upload_logo'">

                                <div class="col-md-9 col-sm-8 col-xs-6">
                                    <div class="input-group" file-uploader is-multiple="false" identifier="app-image" style="border: 1px dashed;">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file">
                                               <i class="fa fa-folder-open"></i> Drop or Browse…  <input type="file" name="file_upload" value="@{{ upload.file.name }}" >
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly ng-model="upload.file.name">
                                    </div>
                                    @if($isDemo)
                                        @include('backend.layouts.common.demo-btn')
                                    @else
                                        <button type="button" class="btn btn-sm btn-warning" ng-click="uploadImage(detail.key)">Upload Logo</button>
                                    @endif
                                </div>
                                
                                <div ng-if="detail.image_logo" class="col-md-3 col-sm-4 col-xs-6 media-item">
                                   
                                    <div class="text-xs-center">
                                        <img style="border-radius: 5px;" width="80px" ng-src="@{{ detail.image_logo }}">
                                        <p >
                                            <button type="button" ng-click="deleteImage(detail)" class="btn btn-sm btn-danger"> Delete</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <br/>
                        </div>
                    </div>
                    <div class="tab-pane " id="seo_configurations" role="tabpanel">
                        
                        <div ng-repeat="detail in details.seo_configurations.lists track by $index">
                            <div class="sub-title">
                                <strong>@{{ detail.name }}</strong>
                            </div>
                            <div>
                                <input type="text" class="form-control" ng-model="detail.value" name="@{{ detail.key }}" placeholder="@{{ detail.name }}" >
                                <small>@{{ detail.description }}</small>
                            </div>
                            <br/>
                        </div>
                        
                    </div>

                    <div class="tab-pane " id="social_networks" role="tabpanel">

                        <div ng-repeat="detail in details.social_networks.lists track by $index">
                            <div class="sub-title">
                                <strong>@{{ detail.name }}</strong>
                            </div>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-@{{ detail.key }}"></i>
                              </div>
                              <input type="text" class="form-control" ng-model="detail.value" name="@{{ detail.key }}" placeholder="@{{ detail.name }}" >
                              <small>@{{ detail.description }}</small>
                            </div>
                            <br/>
                        </div>
                    </div>


                    <div class="tab-pane row" id="google_webmaster_tools" role="tabpanel">

                        <div ng-repeat="detail in details.google_webmaster_tools.lists track by $index">
                            <div class="col-md-6">
                                <div class="sub-title">
                                    <strong>@{{ detail.name }}</strong>
                                </div>
                                <div>
                                    <input type="text" class="form-control" ng-model="detail.value" name="@{{ detail.key }}" placeholder="@{{ detail.name }}" >
                                    <small>@{{ detail.description }}</small>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="tab-pane row" id="custom_css_and_js" role="tabpanel">

                        <div ng-repeat="detail in details.custom_css_and_js.lists track by $index">
                            <div class="col-md-6">
                                <div class="sub-title">
                                    <strong>@{{ detail.name }}</strong>
                                </div>
                                <div>
                                    <textarea rows="20" type="text" class="form-control" ng-model="detail.value" name="@{{ detail.key }}" placeholder="@{{ detail.name }}"></textarea>
                                    <small>@{{ detail.description }}</small>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane row" id="apk_download_via_api" role="tabpanel">

                        <div ng-repeat="detail in details.apk_download_via_api.lists track by $index">
                            <div class="col-md-12">

                                <div class="sub-title">
                                    <strong>@{{ detail.name }}</strong> 
                                </div>
                                <div>
                                    <textarea ng-if="detail.key != 'download_api_url'" rows="2"  class="form-control" ng-model="detail.value" name="@{{ detail.key }}" placeholder="@{{ detail.name }}"></textarea>

                                    <small>@{{ detail.description }}</small>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12"> 
                            @if($isDemo)
                                Validate and Get Api Url (Demo mode on)
                            @else
                                <button type="button" class="btn btn-sm btn-danger" ng-click="validatePurchaseCode()">Validate and Download Api File</button>
                            @endif
                        </div>


                    </div>
                    
                    <div class="tab-pane row" id="recaptcha_api_key" role="tabpanel">

                        <div ng-repeat="detail in details.recaptcha_api_key.lists track by $index">
                            <div class="col-md-6">

                                <div class="sub-title">
                                    <strong>@{{ detail.name }}</strong> 
                                </div>
                                <div>
                                    <input type="text" class="form-control" ng-model="detail.value" name="@{{ detail.key }}" placeholder="@{{ detail.name }}" >
                                    <small>@{{ detail.description }}</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div> 

        <div class="card-footer text-muted">
            @if($isDemo)
               @include('backend.layouts.common.demo-btn')
            @else
                <button type="submit" class="btn btn-sm btn-primary" ng-click="update(details)">Save Changes</button>
            @endif
        </div>    

        </div>
    </div>
</div>

@stop
@include('backend.settings.general.partials.js')