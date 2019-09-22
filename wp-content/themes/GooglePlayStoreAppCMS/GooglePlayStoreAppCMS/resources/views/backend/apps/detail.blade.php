@extends('backend.layouts.backend')


@section('stylesheets')
<style type="text/css">
    .chosen-container {
        width: 100% !important;
    }
</style>

@stop
@section('menu') App Collections
@stop


@section('detail-app-button')
    @if(isset($is_create) && $is_create == 1)
        @if($isDemo)
           @include('backend.layouts.common.demo-btn')
        @else
            <button type="button" class="btn btn-info" ng-click="create()"><i class="fa fa-user-plus"></i> Add New Apps</button>
        @endif
    @else
        @if($isDemo)
           @include('backend.layouts.common.demo-btn')
        @else
            <button type="button" class="btn bg-dark" ng-click="update()"><i class="fa fa-save"></i> Update Information</button>
            <button type="button" class="btn btn-danger" ng-click="delModal(details,'details')"><i class="fa fa-trash"></i> Delete App</button>
        @endif
    @endif
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

                <div class="col-md-8" ng-cloak>

                    <h5 ng-if="details.is_submitted_app =='0' ">App Details | <small> Show all information about your app/game</small></h5>
                    <h5 ng-if="details.is_submitted_app =='1' ">Review App Details | <small> Show all information about your app/game</small></h5>
                    <hr/>
                    <form>
                        <fieldset ng-if="details.is_submitted_app =='0' " class="form-group">
                            <label for="title" >
                                App Status
                            </label>
                           <div class="input-group">
                              <span class="input-group-addon">
                                <input type="checkbox" ng-model="details.is_enabled">
                              </span>
                              <input type="text" class="form-control" value="@{{ details.is_enabled == true ? 'Enabled' : 'Disabled' }}">
                            </div>
                        </fieldset>

                        <fieldset ng-if="details.is_submitted_app =='1' " class="form-group">
                            <label for="title" >
                                App Status
                            </label>
                            <p>
                                <strong>Click to toggle: @{{ details.is_enabled == false ? 'Approve' : 'Disabled' }}</strong>
                                and click the update button below.
                            </p>
                            <button type="button" class="btn" ng-class="{true: 'btn-success', false: 'btn-danger'}[details.is_enabled]" data-toggle="button" ng-model="details.is_enabled" aria-pressed="details.is_enabled" autocomplete="off" ng-click="details.is_enabled = !details.is_enabled">
                              @{{ details.is_enabled == true ? 'Approve' : 'Disabled' }}
                            </button>
                           
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="appid">
                              App ID
                            </label>
                            <div class="input-group">
                              <input type="text" class="form-control" placeholder="Enter app id" ng-model="details.app_id">
                              <span class="input-group-btn">
                                <button class="btn btn-success" type="button" ng-click="grabAndroidDetail()"><i class="fa fa-android"></i> Get Details</button>
                              </span>
                            </div>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="appname">
                              App Name
                            </label>
                            <input type="text" class="form-control" id="appname" placeholder="Enter app name" ng-model="details.title">
                        </fieldset>
                        
                        <fieldset class="form-group">
                            <label for="google-playlink">
                              Google Play Link
                            </label>
                            <input type="text" class="form-control" id="google-playlink" placeholder="Enter app id" ng-model="details.link">
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="description">
                            Description
                            </label>
                            <textarea  class="form-control" placeholder="Enter category description" rows="6" ui-tinymce="tinymceOptions" ng-model="details.description"></textarea>
                        </fieldset>

                        
                        @include('backend.apps.custom-input')
                        @include('backend.apps.apk-upload')


                    </form>
                    @include('backend.layouts.common.seo')

                </div>

                <div class="col-md-4" ng-cloak>
                    <fieldset class="form-group" ng-cloak>
                    <img ng-src="@{{ details.app_image.image_link || details.image_url }}" class="img-fluid" alt="@{{ details.title }}" style="padding: 0px;margin: 0 auto;width: 100px;border-radius: 15px;">

                    <div ng-if="details.app_image.image_link" style="text-align: center;cursor: pointer;" ng-click="removeItem(details.app_image)" class="hand text-danger" >
                    <i class="fa fa-remove"></i> Remove Image</div>

                    </fieldset>
                    <fieldset class="form-group">
                        <label for="direct-image-url">
                          Upload Main App Image
                        </label>
                        @include('backend.apps.image')
                    </fieldset>
                    <fieldset class="form-group">
                        <small>Note: * If you upload manual image, thats the first one we will used in our frontend before the image link from google play.</small><br/>
                        <label for="direct-image-url">
                          Image Uploaded Url
                        </label>
                        <input disabled ng-if="details.app_image.image_link" type="text" class="form-control" id="direct-image-url" placeholder="Enter Image url" ng-model="details.app_image.image_link">

                        <label for="direct-image-url">
                          Image Link from Google Play 
                        </label>
                        <input  type="text" class="form-control" id="direct-image-url" placeholder="Enter Image url" ng-model="details.image_url">
                    </fieldset>
                    <hr/>
                    <fieldset class="form-group">
                        <label for="description">
                        Select App Categories
                        </label>
                        <select class="form-control ng-cloak"
                            chosen
                            multiple 
                            ng-options="category as category.title group by category.group for category in categories  track by category.id"
                            data-placeholder-text-single="'Select Categories'"
                            ng-model="details.categories">
                            <option value=""></option>
                        </select>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="developer-name">
                          Developer Name
                        </label>
                        <input type="text" class="form-control" id="developer-name" placeholder="Enter Developer Name" ng-model="details.developer_name">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="developer-name">
                          Developer Link Url
                        </label>
                        <input type="text" class="form-control" id="developer-name" placeholder="Enter Developer Link" ng-model="details.developer_link">
                    </fieldset>

                    <fieldset class="form-group">
                            <label for="description">
                            Add Screenshots
                            </label>
                            <div class="col-sm-12 img-uploaded mar-no pad-no">
                                <div class="wrap-uploader" id="div-uploader">
                                    <div class="uploader" file-uploader is-multiple="true" my-file="uploads" style="width: 100%">
                                        <div class="drop-zone">
                                            <div class="content">
                                                <div class="img-arrow">
                                                    <i class="fa fa-arrow-circle-o-up"></i>
                                                </div>
                                                <div ng-hide="file_show">DRAG N' DROP</div>
                                                
                                                <div class="btn-browse">
                                                    <input type="hidden" name="file_upload" value="@{{ file_upload }}">
                                                    <div ng-hide="file_show">Browse</div>
                                                    <div ng-show="file_show">Change</div>
                                                    <input name="img_file" id="fileuploader" class="input-uploader" type="file" multiple />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mar-no pad-no screenshot-container">

                                <ul class="list-group">
                                    <li ng-repeat="image in details.screenshots" class="list-group-item">
                                        <div class="image">
                                            <img ng-if="image.preview" src="@{{ image.preview }}" alt="@{{ image.preview }}"/>
                                            <img ng-if="!image.preview && !image.link" src="{{ asset('assets/img/no-image.png') }}" alt="@{{ image.preview }}"/>
                                            <img ng-if="image.link" src="@{{ image.link }}" />
                                            <div class="text-danger image-remove" ng-click="removeItem(image)" ><i class="fa fa-remove"></i></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </fieldset>

                </div>


            </div>

            <div class="card-footer ">
                @yield('detail-app-button')
            </div>
        </div>
    </div>
</div>
@stop
@include('backend.apps.partials.js')