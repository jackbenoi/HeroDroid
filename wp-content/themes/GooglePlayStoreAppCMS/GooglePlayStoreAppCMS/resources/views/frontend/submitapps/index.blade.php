@extends('frontend.layouts.frontend')

@section('content')

<div class="card"  ng-app="FrontendApp" ng-controller="AppsController">
    <div class="card-header">
        <div class="pull-left">
            <a href="#">{{ trans('frontend.submit_apps.title') }}</a>
        </div>
        
    </div>
    <div class="card-block" block-ui="blockui-effect">

        <div class="col-md-12">
            <h5>{{ trans('frontend.submit_apps.app_detail') }} | <small> {{ trans('frontend.submit_apps.app_detail_desc') }}</small></h5>
            <hr/>
            {{ Form::open(['accept-charset'=>'UTF-8', 'url' => '#', 'method' => 'POST']) }}
                <fieldset class="form-group">
                    <label for="appid">
                      {{ trans('frontend.submit_apps.google_play_id') }}
                    </label>
                    <p>
                        {!! trans('frontend.submit_apps.instruction_message') !!}
                    </p>
                    <small class="text-danger">{{ trans('frontend.submit_apps.google_play_id') }}</small>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{ trans('frontend.submit_apps.enter_app_placeholder') }}" ng-model="details.app_id">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" ng-click="grabAndroidDetail()"><i class="fa fa-android"></i> {{ trans('frontend.submit_apps.get_details') }}</button>
                        </span>
                    </div>
                    <small>{{ trans('frontend.submit_apps.get_details_desc') }}</small>
                </fieldset>

                <fieldset class="form-group" ng-cloak>
                    <img ng-src="@{{ details.app_image.image_link || details.image_url }}" class="img-fluid" alt="@{{ details.title }}" style="padding: 0px;margin: 0 auto;width: 100px;border-radius: 15px;">

                    <div ng-if="details.app_image.image_link" style="text-align: center;cursor: pointer;" ng-click="removeItem(details.app_image)" class="hand text-danger" >
                    <i class="fa fa-remove"></i> {{ trans('frontend.submit_apps.remove_image') }}</div>

                </fieldset>
                <fieldset class="form-group">
                    <label for="direct-image-url">
                     {{ trans('frontend.submit_apps.upload_main_app_image') }}
                    </label>
                    @include('backend.apps.image')
                </fieldset>
                <fieldset class="form-group">
                    <small>{{ trans('frontend.submit_apps.note_manual_image_upload') }}</small><br/>
                    <label for="direct-image-url">
                      {{ trans('frontend.submit_apps.image_upload_url') }}
                    </label>
                    <input disabled ng-if="details.app_image.image_link" type="text" class="form-control" id="direct-image-url" placeholder="Enter Image url" ng-model="details.app_image.image_link">

                    <label for="direct-image-url">
                       {{ trans('frontend.submit_apps.image_link_from_google_play') }}
                    </label>
                    <input  type="text" class="form-control" id="direct-image-url" placeholder="Enter Image url" ng-model="details.image_url">
                </fieldset>

                <fieldset class="form-group">
                    <label for="appname">
                      {{ trans('frontend.submit_apps.app_name') }}
                    </label>
                    <input type="text" class="form-control" id="appname" placeholder="Enter app name" ng-model="details.title">
                </fieldset>
                
                <fieldset class="form-group">
                    <label for="google-playlink">
                      {{ trans('frontend.submit_apps.google_play_link') }}
                    </label>
                    <input type="text" class="form-control" id="google-playlink" placeholder="Enter app id" ng-model="details.link">
                </fieldset>

                <fieldset class="form-group">
                    <label for="description">
                    {{ trans('frontend.submit_apps.select_categories') }}
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
                    <label for="description">
                    {{ trans('frontend.submit_apps.select_categories') }}
                    </label>
                    <textarea  class="form-control" placeholder="Enter category description" rows="6" ui-tinymce="tinymceOptions" ng-model="details.description"></textarea>
                </fieldset>

                <h5>{!! trans('frontend.submit_apps.developer_detail') !!}</h5>
                <hr/>
                <fieldset class="form-group">
                    <label for="developer-name">
                      {!! trans('frontend.submit_apps.developer_name') !!}
                    </label>
                    <input type="text" class="form-control" id="developer-name" placeholder="Enter Developer Name" ng-model="details.developer_name">
                </fieldset>
                <fieldset class="form-group">
                    <label for="developer-name">
                      {{ trans('frontend.submit_apps.developer_link') }}
                    </label>
                    <input type="text" class="form-control" id="developer-name" placeholder="Enter Developer Link" ng-model="details.developer_link">
                </fieldset>
                <hr/>


                <h5>{!! trans('frontend.submit_apps.app_screenshots') !!}</h5>
                <hr/>
                <fieldset class="form-group">
                    <label for="description">
                    {{ trans('frontend.submit_apps.screenshot_desc') }}
                    </label>
                    <div class="col-sm-12 img-uploaded mar-no pad-no">
                        <div class="wrap-uploader" id="div-uploader">
                            <div class="uploader" file-uploader is-multiple="true" my-file="uploads" style="width: 100%">
                                <div class="drop-zone">
                                    <div class="content">
                                        <div class="img-arrow">
                                            <i class="fa fa-arrow-circle-o-up"></i>
                                        </div>
                                        <div ng-hide="file_show">{{ trans('frontend.submit_apps.drag_drop') }}</div>
                                        
                                        <div class="btn-browse">
                                            <input type="hidden" name="file_upload" value="@{{ file_upload }}">
                                            <div ng-hide="file_show">{{ trans('frontend.submit_apps.browse') }}</div>
                                            <div ng-show="file_show">{{ trans('frontend.submit_apps.change') }}</div>
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
                                    <img ng-if="image.preview" ng-src="@{{ image.preview }}" alt="@{{ image.preview }}"/>
                                    <img ng-if="!image.preview && !image.link" ng-src="{{ asset('assets/img/no-image.png') }}" alt="@{{ image.preview }}"/>
                                    <img ng-if="image.link" ng-src="@{{ image.link }}" />
                                    <div class="text-danger image-remove" ng-click="removeItem(image)" ><i class="fa fa-remove"></i></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </fieldset>
                <hr/>
                @include('backend.apps.apk-upload')


            </form>

            @include('backend.layouts.common.seo')

        </div>

    </div>

    <div class="card-footer">

        @if(isset($is_create) && $is_create == 1)
            @if($isDemo)
               @include('backend.layouts.common.demo-btn')
            @else
                <button type="button" class="btn btn-info" ng-click="create()"><i class="fa fa-user-plus"></i> {{ trans('frontend.submit_apps.add_new_apps') }}</button>
            @endif
        @else
            @if($isDemo)
               @include('backend.layouts.common.demo-btn')
            @else
                <button type="button" class="btn bg-dark" ng-click="update()"><i class="fa fa-save"></i> {{ trans('frontend.submit_apps.update_info') }}</button>
                <button type="button" class="btn btn-danger" ng-click="delModal(details,'details')"><i class="fa fa-trash"></i> {{ trans('frontend.submit_apps.delete_app') }}</button>
            @endif
        @endif
    </div>
</div>

@stop
@section('scripts')

<script type="text/javascript" src="{{ elixit('assets/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ elixit('assets/js/angular-tinymce.js') }}"></script>

<script type="text/javascript" src="{{ elixit('assets/js/helper.js') }}"></script>
<script type="text/javascript" src="{{ elixit('assets/js/angular-modules.js') }}"></script>

<script type="text/javascript" src="{{ elixit('assets/js/frontend/app.js') }}"></script>
<script type="text/javascript" src="{{ elixit('assets/js/frontend/apps.js') }}"></script>


<script type="text/javascript">
window.APPMarket.Resources = {
        root               : '{{ route('frontend.index.index') }}',
        submitapps_list    : '{{ route('frontend.submitapps.list') }}',
        index              : '{{ route('resource.appmarket.index') }}',
        app_update         : '{{ route('resource.appmarket-update.store') }}',
        app_version_update : '{{ route('resource.appmarket-apk-update.store') }}',
        app_android_detail : '{{ route('frontend.submitapps.details') }}',
        app_remove_upload  : '{{ route('backend.apps.remove.upload') }}',
        app_remove_apk     : '{{ route('backend.apps.remove.apk') }}',
    };

window.APPMarket.Vars = {
        alpha          : {!! json_encode($letters) !!},
        hash_id        : {{ isset($hashId)         ? $hashId : 0 }},
        is_create      : {{ isset($is_create)      ? $is_create : 0 }},
        categories     : {!! isset($categories)     ? json_encode($categories) : json_encode([]) !!},
    }; 
</script>

@stop