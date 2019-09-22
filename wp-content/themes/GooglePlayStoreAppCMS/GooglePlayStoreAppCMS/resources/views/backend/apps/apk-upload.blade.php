<h5>Upload APK File | <small> Upload your apk file here for your customer to download</small></h5>
<hr/>
<div class="card">
    <div class="card-block">
        
         <uib-accordion >
            <div uib-accordion-group class="card">
                <uib-accordion-heading>
                    <div class="card-header" role="tab" id="headingOne">
                        <i class="fa fa-plus"></i> <strong>Click to Add New App Version</strong>
                        
                       
                    </div>
                </uib-accordion-heading>
                <div class="card-block">
                   
                   <form>
                        <fieldset class="form-group">
                            <label for="app-version">
                               Add New App Version
                            </label>
                            <input type="text" class="form-control" id="app-version" placeholder="Ex. 1.1 or 1.2.4" ng-model="apkFiles.app_version">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="app-version">
                                Signature <small class="text-red">(Optional)</small>
                            </label>
                            <input type="text" class="form-control" id="app-version" placeholder="Ex.fd2f662cc20261f7a31d38aac91a1d01e8d54ff1" ng-model="apkFiles.signature">
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="app-version">
                                APK File SHA1 <small class="text-red">(Optional)</small>
                            </label>
                            <input type="text" class="form-control" id="app-version" placeholder="Ex. 982c3907e68ec7245862b24e7f8388c288196440" ng-model="apkFiles.sha_1">
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="app-version">
                                What's new <small class="text-red">(Optional)</small>
                            </label>
                            <textarea ng-model="apkFiles.description" class="form-control" placeholder="Enter some updates description" rows="3" ></textarea>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="app-version">
                                APK URL Source <small class="text-danger">* (used outside apk download link source)</small>
                            </label>
                            <input type="text"  class="form-control" ng-model="apkFiles.app_link" placeholder="Download Link from other sources.">
                        </fieldset>

                        <fieldset class="form-group">
                            <label for="app-version">
                                Upload Apk file |
                                <small class="text-danger"> * <strong> Upload File Max Limit - {{ formattedFileSize(file_upload_max_size()) }}</strong>
                                    ; to increase the limit, adjust your php.ini
                                </small>
                            </label>
                            <div class="col-sm-12 img-uploaded mar-no pad-no">
                                <div class="wrap-uploader" id="div-uploader">
                                    <div class="uploader" file-uploader identifier="app-version" style="width: 100%">
                                        <div class="drop-zone">
                                            <div class="content">
                                                <div class="img-arrow">
                                                    <i class="fa fa-arrow-circle-o-up"></i>
                                                </div>
                                                <div ng-hide="file_show">DRAG N' DROP</div>
                                                
                                                <div class="btn-browse">
                                                    <div ng-hide="file_show">Browse</div>
                                                    <div ng-show="file_show">Change</div>
                                                    <input name="file_upload" id="fileuploader" class="input-uploader" type="file" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-sm-12 mar-no pad-no" ng-if="apkFiles.file.name || apkFiles.original_name">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <span ng-if="apkFiles.file.name"> @{{ apkFiles.file.name }} </span>
                                        <span ng-if="apkFiles.original_name"> @{{ apkFiles.original_name }} </span>
                                        <span ng-if="apkFiles.file.original_name"> @{{ apkFiles.file.original_name }} </span>
                                        <button class="btn btn-danger btn-sm" ng-click="removeItem(apkFiles.file)" ><i class="fa fa-trash-o"></i></button>
                                    </li>
                                </ul>
                            </div>
                        </fieldset>

                        <fieldset class="form-group">
                            @if(isset($is_create) && $is_create != 1)
                                @if($isDemo)
                                   @include('backend.layouts.common.demo-btn')
                                @else
                                     <button type="button" class="btn btn-block btn-default" ng-click="createApkItem()"><i class="fa fa-save"></i> Upload New APK Version </button>
                                @endif
                            @endif
                           
                        </fieldset>

                    </form>
                </div>
            </div>
        </uib-accordion>

        <uib-accordion ng-if="details.versions">
            <div ng-repeat="version in details.versions track by $index" uib-accordion-group class="card" is-open="status.open">
                <uib-accordion-heading>
                    <div class="card-header" role="tab" id="headingOne">
                        <strong>App Version: @{{ version.app_version }}</strong>
                        
                        <button uib-tooltip="Edit App Version: @{{ version.app_version }}" class="btn btn-dark btn-sm"><i class="fa fa-pencil"></i> </button> <span style="margin-right: 5px;"> </span>
                        <button uib-tooltip="Delete App Version: @{{ version.app_version }}" ng-click="removeApkItem(version)" class="pull-right btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> </button>
                    </div>
                </uib-accordion-heading>
                <div class="card-block" block-ui="version_@{{ $index }}">
                    <fieldset class="form-group">
                        <label for="app-version">
                            APK Signature
                        </label>
                        <input type="text"  class="form-control" ng-model="version.signature">
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="app-version">
                            APK SHA1
                        </label>
                        <input type="text"  class="form-control" ng-model="version.sha_1">
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="app-version">
                            APK Description
                        </label>
                        <textarea  ng-model="version.description" class="form-control"  rows="2" ></textarea>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="app-version">
                            APK URL Source <small class="text-danger">* (used outside apk download link source)</small>
                        </label>
                        <input type="text"  class="form-control" ng-model="version.app_link" placeholder="Download Link from other sources.">
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="app-version">
                            Upload your own apk file (@{{ version.original_name }})
                        </label>
                        <div class="col-sm-12 img-uploaded mar-no pad-no">
                            <div class="wrap-uploader" id="div-uploader">
                                <div class="uploader" file-uploader identifier="app-version-update" style="width: 100%">
                                    <div class="drop-zone">
                                        <div class="content">
                                            <div class="img-arrow">
                                                <i class="fa fa-arrow-circle-o-up"></i>
                                            </div>
                                            <div ng-hide="file_show">DRAG N' DROP</div>
                                            
                                            <div class="btn-browse">
                                                <div ng-hide="file_show">Browse</div>
                                                <div ng-show="file_show">Change</div>
                                                <input name="file_upload" id="fileuploader" class="input-uploader" type="file" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mar-no pad-no" ng-if="apkFile.file.name || apkFile.original_name">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <span ng-if="apkFile.file.name"> @{{ apkFile.file.name }} </span>
                                        <span ng-if="apkFile.original_name"> @{{ apkFile.original_name }} </span>
                                        <span ng-if="apkFile.file.original_name"> @{{ apkFile.file.original_name }} </span>
                                        <button class="btn btn-danger btn-sm" ng-click="removeItem(apkFile.file,'apk-update')" ><i class="fa fa-trash-o"></i></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-group">
                        <button type="button" class="btn btn-block btn-default" ng-click="updateApkItem(version,$index)"><i class="fa fa-save"></i> Update APK (@{{ version.app_version }}) Information</button>
                    </fieldset>

                </div>
            </div>
        </uib-accordion>

    </div>
</div>