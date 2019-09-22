###*
# AppsController
# __SHORT_DESCRIPTION__
#
# @class        AppsController
# @package      APPMarket.Frontend.FrontendApp
# @author       Anthony Pillos <me@anthonypillos.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

APPMarket.Frontend.FrontendApp.controller "AppsController",
['$scope'
'$rootScope'
'$timeout'
'$filter'
'blockUI'
'ApiFactory'
'ListingService'
'SystemFactory'
'SweetAlertService'
'UploaderFactory'
(
    $scope
    $rootScope
    $timeout
    $filter
    blockUI
    $apiFactory
    $listingService
    $systemFactory
    $sweetAlertService
    $uploaderFactory
) ->

    class AppsController

        ###*
        #
        # @return
        ###
        constructor : () ->
            
            $scope.resources    = APPMarket.Resources
            $scope.vars         = APPMarket.Vars
            $scope.link         =
                root               : $scope.resources.root
                submitapps_list    : $scope.resources.submitapps_list
                lists              : $scope.resources.index
                app_update         : $scope.resources.app_update
                app_version_update : $scope.resources.app_version_update
                app_search         : $scope.resources.app_search
                app_import         : $scope.resources.app_import
                app_android_detail : $scope.resources.app_android_detail
                app_remove_upload  : $scope.resources.app_remove_upload
                app_remove_apk     : $scope.resources.app_remove_apk

            $scope.blockUI       = $scope.blockui('blockui-effect')
            $scope.details       = {}
            
            $scope.uploads    = {}
            $scope.categories = $scope.vars.categories
            $scope.apkFile = $scope.apkFiles = 
                app_version : ''
                signature   : ''
                sha_1       : ''
                description : ''
                app_link    : ''
                file        : {}

            $scope.details  =
                image_app      : {}
                screenshots    : []
                is_enabled     : true
                app_id         : ''
                title          : ''
                description    : ''
                image_url      : ''
                link           : ''
                developer_link : ''
                developer_name : ''
                apk_files      : []
                versions       : []


            # if is create = 0, it means we just need to load the details
            if $scope.vars.is_create is 0
                $scope.getDetail()


        # # DETAIL START #
        $scope.getDetail = () ->
            $scope.blockUI.start('Please Wait . . .')

            # assign user_id
            $scope.details.user_id = APPMarket.user_id

            $apiFactory.sendRequest {}, $scope.link.lists+'/'+$scope.vars.hash_id,'GET'
            .then (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}
                    $scope.blockUI.stop()
                else
                    dataObj                    = response.data.data

                    screenshots = []
                    angular.forEach dataObj.screenshots, (value, key)->
                        screenshots[key] =
                            id       : value.id
                            name     : value.original_name
                            link     : value.image_link
                            position : value.position


                    dataObj.screenshots = screenshots
                    $scope.details      = dataObj

                    $scope.details.is_enabled =  if $scope.details.is_enabled is 1 then true else false
                    $scope.details.is_featured = if $scope.details.is_featured is 1 then true else false



                    $scope.blockUI.stop()
            .catch (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: 'No query results found, You will be redirected back in 2 seconds...'}
                    $timeout () ->
                        window.location.href = $scope.link.root
                    ,2000

        $scope.grabAndroidDetail = () ->



            try
                $systemFactory.validateObj $scope.details,['app_id']

                $scope.blockUI.start('Please Wait . . .')

                # assign user_id
                $scope.details.user_id = APPMarket.user_id

                $apiFactory.sendRequest {app_id: $scope.details.app_id}, $scope.link.app_android_detail,'POST'
                .then (response) ->
                    if response.data.status is 'error'
                        $scope.alertMsg {msg: response.data.message}
                        $scope.blockUI.stop()
                    else
                        dataObj     = response.data.data
                        screenshots = []
                        angular.forEach dataObj.screenshots, (value, key)->
                            screenshots[key] = 
                                name     : 'Screenshot From Google #'+ ++key
                                link     : value
                                position : key

                        details =
                            is_enabled     : true
                            app_id         : dataObj.app_id
                            title          : dataObj.title
                            description    : dataObj.description
                            image_url      : dataObj.cover_image
                            link           : dataObj.app_link
                            developer_link : dataObj.developer.link
                            developer_name : dataObj.developer.name
                            screenshots    : screenshots
                            image_app      : {}


                        if dataObj.title
                            details.seo_title = dataObj.title

                        if dataObj.description
                            details.seo_descriptions = $filter('truncateStr')(dataObj.description,155)

                        angular.extend $scope.details,details

                        $scope.blockUI.stop()
                .catch (response) ->
                    msgInfo = 'No results found'
                    if response.data.status is 'error'
                        msgInfo = response.data?.message

                    $scope.alertMsg {msg: msgInfo}
                    $scope.blockUI.stop()

            catch e
                $scope.alertMsg {msg: e}


        uploadSingle = $rootScope.$on 'file:uploading', (evt,fileObj,identifier,isMultiple) ->

            # validation
            $timeout () ->

                if identifier is 'app-image'
                    $scope.details.image_app = fileObj

                else if identifier is 'app-version'
                    if angular.isUndefined $scope.apkFiles
                        $scope.apkFiles = {}

                    $scope.apkFiles.file = fileObj

                else if identifier is 'app-version-update'
                    if angular.isUndefined $scope.apkFile
                        $scope.apkFile = {}

                    $scope.apkFile.file = fileObj

        upload = $rootScope.$on 'file:upload-in-array', (evt, data, index)->
            $timeout () ->
                files = data.file

                if angular.isUndefined $scope.details.screenshots
                    $scope.details.screenshots = []

                angular.forEach files, (file,key) ->
                    identifier      = _h.randomKey 12
                    file.identifier = identifier
                    if _.contains ["image/gif", "image/jpeg", "image/jpg", "image/png"], file.type
                        filereader = new FileReader()
                        filereader.onload = (e) -> $rootScope.$emit 'image:preview', e.target.result, identifier
                        filereader.readAsDataURL file

                        $scope.details.screenshots.push file
                    else
                        $scope.alertMsg {msg: 'Upload Image only'}

    
        $onImagePreview = $rootScope.$on 'image:preview', (evt, image, identifier) ->
            uploadimage = _.findWhere $scope.details.screenshots, { identifier : identifier }
            uploadimage.preview = image
            $scope.$apply() if not $scope.$$phase
            return


        complete = $rootScope.$on 'upload:complete', (evt, data, index)->
                
                resp = JSON.parse $uploaderFactory.dataObj[index].xhr.response

                if resp.status is 'error'
                    $scope.alertMsg {msg: resp.message}

                    if angular.isDefined($scope.blockUI)    
                        $scope.blockUI.stop()

                    return false

                if angular.isDefined($scope.versionBlockUI)
                    $scope.versionBlockUI[index].stop()

                if angular.isDefined($scope.myBlockUI)    
                    $scope.myBlockUI.stop()

                if angular.isDefined($scope.blockUI)        
                    $scope.blockUI.stop()

                $scope.alertMsg {msg: 'Successfully submitted apps, Redirecting after two(2) seconds.',success: true}
                $timeout () ->
                    window.location.href = $scope.link.submitapps_list
                , 2000


        $scope.$on '$destroy', () ->
            upload()
            uploadSingle()
            complete()
            abortData()
            $onImagePreview()



        $scope.update = () ->
           
            $scope.details.hash_id     = $scope.vars.hash_id;
            $scope.details.is_enabled  = if $scope.details.is_enabled is true then 1 else 0
            $scope.details.is_featured = if $scope.details.is_featured is true then 1 else 0

            if $scope.apkFiles.file.name or $scope.apkFiles.app_link
                $scope.details.apk_file_upload = $scope.apkFiles

            $scope.blockUI.start('Please Wait . . .')

            try
                sendData = $systemFactory.objectToFormData($scope.details)
                $uploaderFactory.upload $scope.link.app_update,sendData,[]


            catch e
                $scope.alertMsg {msg: e}


        $scope.create = () ->

            $scope.details.user_id     = APPMarket.user_id;
            $scope.details.hash_id     = $scope.vars.hash_id;
            $scope.details.is_enabled  = if $scope.details.is_enabled is true then 1 else 0
            $scope.details.is_featured = if $scope.details.is_featured is true then 1 else 0

            if $scope.apkFiles.file.name or $scope.apkFiles.app_link
                $scope.details.apk_file_upload = $scope.apkFiles

            $scope.blockUI.start('Please Wait . . .')

            try

                $systemFactory.validateObj $scope.details,['app_id','title','description','image_app','categories','user_id']


                sendData = $systemFactory.objectToFormData($scope.details)
                $uploaderFactory.upload $scope.link.lists,sendData,[]


                # window.location.reload()
            catch e
                $scope.alertMsg {msg: e}

                $scope.blockUI.stop()


        # END DETAIL START #


        # START appmarket googleplay #

        $scope.createApkItem = () ->

            if !$scope.apkFiles.app_link and !$scope.apkFiles.file
                $scope.alertMsg {msg: 'Apk Link URL download required or Upload your own apk file.'}
                return false;

            $scope.update()

        $scope.updateApkItem = (version,index) ->
            if $scope.apkFile.file.name
                version.apk_file_upload = $scope.apkFile


            if angular.isUndefined $scope.versionBlockUI
                $scope.versionBlockUI = []

            $scope.versionBlockUI[index] = $scope.blockui('version_'+index)

            $scope.versionBlockUI[index].start 'Updating APK Information. . .'
            sendData = $systemFactory.objectToFormData(version)
            $uploaderFactory.upload $scope.link.app_version_update,sendData,$scope.versionBlockUI,index
          

        $scope.removeApkItem = (version) ->

            opts = 
                title               :'Please Confirm'
                text                : _h.sprintf 'Do you want to delete this apk version (<strong>%s</strong>)?',version.app_version
                html                : true
                showCancelButton    : true
                cancelButtonText    : 'Cancel'
            $sweetAlertService.swal opts, (isConfirm) ->
                if(isConfirm)
                    if version.id
                        $scope.deleteFile $scope.link.app_remove_apk+'/'+version.id


        # DETAIL END #

        
        $scope.alertMsg = (opts) ->
            options =
                title : 'System Response'
                msg   : 'Problem in your request!'
            opt = angular.merge options,opts

            if opt.success is true
                return $sweetAlertService.success opt.title,opt.msg

            return $sweetAlertService.error opt.title,opt.msg


        $scope.removeItem = (file,index) ->

            if angular.isDefined index
                if index is 'apk-update'
                    $scope.apkFile.file = {}

            else
                if file.id
                    $scope.deleteFile $scope.link.app_remove_upload+'/'+file.id

                if file.upload_type is 'app-image'
                    $scope.details.app_image = ''

                index = $scope.details.screenshots.indexOf(file)
                $scope.details.screenshots.splice index,1

        $scope.deleteFile = (url) ->

            $apiFactory.sendRequest {}, url, "POST"
                .then (response) ->
                    window.location.reload()

                ,(response) ->
                    # temporary alert
                    alert response.data.message
                    $scope.myBlockUI.stop()


        $scope.blockui = (instanceName) ->
                return blockUI.instances.get(instanceName)

    new AppsController()

]