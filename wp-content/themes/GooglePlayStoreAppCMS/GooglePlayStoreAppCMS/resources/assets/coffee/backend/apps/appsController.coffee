###*
# AppsController
# __SHORT_DESCRIPTION__
#
# @class        AppsController
# @package      APPMarket.Backend.BackendApp
# @author       Anthony Pillos <me@anthonypillos.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

APPMarket.Backend.BackendApp.controller "AppsController",
['$scope'
'$rootScope'
'$timeout'
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
                lists              : $scope.resources.index
                app_update         : $scope.resources.app_update
                app_version_update : $scope.resources.app_version_update
                app_search         : $scope.resources.app_search
                app_import         : $scope.resources.app_import
                app_android_detail : $scope.resources.app_android_detail
                app_remove_upload  : $scope.resources.app_remove_upload
                app_remove_apk     : $scope.resources.app_remove_apk

            $scope.blockUI       = $scope.blockui('blockui-effect')
            $scope.blockSearchUI = $scope.blockui('search-result')
            $scope.details       = {}
            $scope.per_page      = 50
            $scope.letters       = $scope.vars.alpha
            $scope.categoryObj   = 
                list: []
            
            if $scope.vars.hash_id is 0 and $scope.vars.is_create is 0
                
                $scope.details = 
                    per_page : 50
                    search   : ''
                    letter   : ''

                $scope.pagePresetKey = 'appmarket-page'
                $scope = angular.extend $scope, $listingService, {
                    getCollections: (pageNum) -> $scope.getOrderLists(pageNum)
                }
                $scope.loadCollections()

            else if $scope.vars.is_google_play is 1

                $scope.categories = $scope.vars.categories

                $scope.appLists = []
                $scope.details = 
                    search     : ''
                    letter     : ''

            else

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
                    custom         : []


                $scope.tempInputOptions = 
                    identifier : 'text'
                    key        : ''
                    value      : ''

                $scope.inputTypes       = ['text','textarea']

                # if is create = 0, it means we just need to load the details
                if $scope.vars.is_create is 0
                    $scope.getDetail()

 
        $scope.loadCollections = () ->
            $timeout () ->

                pageNum = _h.get($scope.pagePresetKey ) || 1
                if $scope.details.search != ''
                    pageNum = 1

                $scope.getCollections pageNum

        $scope.getOrderLists = (pageNum) ->
            pageNum = pageNum || 1
            $scope.blockUI.start('Please Wait . . .')
            
            _h.set $scope.pagePresetKey, pageNum


            $scope.details.per_page = if angular.isUndefined $scope.details.per_page then $scope.per_page  else $scope.details.per_page
            $scope.details.search = if angular.isUndefined $scope.details.search then '' else $scope.details.search


            search  = '&search='+$scope.details.search
            perpage = '&per_page='+$scope.details.per_page
            letter  = '&letter='+$scope.details.letter

            routes = $scope.link.lists+'?page='+pageNum+search+letter+perpage

            $scope.requestData routes, 'GET'
                .success (response) ->

                    if response.data?
                        angular.bind $scope, $scope.dataHandler response
                    else
                        _h.set $scope.pagePresetKey, 1
                        $scope.data       = []
                        $scope.range      = []
                        $scope.totalPages = 0

                    $timeout () ->
                      $scope.blockUI.stop()
                    ,500

        $scope.delRequest   = (data,type) ->

            $scope.blockUI.start('Please Wait . . .')
            $apiFactory.sendRequest {}, $scope.link.lists+'/'+data.id, 'DELETE'
            .then (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}
                else
                    $scope.alertMsg {msg: response.data.message,success:true}
                    # $scope.loadCollections()
                    window.location.href = $scope.link.root

                $scope.blockUI.stop()

        $scope.delModal = (data,type) ->
            
            opts = 
                title               :'Please Confirm'
                text                : _h.sprintf 'Do you want to delete this page (<strong>%s</strong>)?',data.title
                html                : true
                showCancelButton    : true
                cancelButtonText    : 'Cancel'
            $sweetAlertService.swal opts, (isConfirm) ->
                if(isConfirm)
                    $scope.delRequest data,type

        $scope.grabDetailAndSave = (appId) ->
            $scope.blockUI.start('Please Wait . . .')

            # assign user_id
            $scope.details.user_id = APPMarket.user_id

            $apiFactory.sendRequest {app_id: appId,is_save : true}, $scope.link.app_android_detail,'POST'
            .then (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}
                    $scope.blockUI.stop()
                else
                    dataObj     = response.data.data

                    console.log dataObj
                    $scope.blockUI.stop()


        # DETAIL START #
        $scope.addCustomOptions = () ->

            console.log '$scope.details.custom',$scope.details.custom
            console.log '_.size($scope.tempInputOptions)',_.size($scope.tempInputOptions)

            if _.size($scope.tempInputOptions) > 0
                temp =
                    identifier : 'text'
                    key        : ''
                    value      : ''

                $scope.details.custom.push temp


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


                    if($scope.details.custom == '')
                        $scope.details.custom = []

                    $scope.details.custom = JSON.parse $scope.details.custom

                    $scope.blockUI.stop()
            .catch (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: 'No query results found, You will be redirected back in 2 seconds...'}
                    $timeout () ->
                        window.location.href = $scope.link.root
                    ,2000

        $scope.grabAndroidDetail = () ->
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
                        is_enabled       : true
                        app_id           : dataObj.app_id
                        title            : dataObj.title
                        description      : dataObj.description
                        image_url        : dataObj.cover_image
                        link             : dataObj.app_link
                        developer_link   : dataObj.developer.link
                        developer_name   : dataObj.developer.name
                        screenshots      : screenshots
                        reviews          : dataObj.reviews
                        ratings          : dataObj.rate_score
                        ratings_total    : dataObj.ratings_total
                        published_date   : dataObj.published_date
                        rating_histogram : dataObj.rating_histogram
                        installs         : dataObj.installs
                        required_android : dataObj.required_android
                        image_app        : {}


                    angular.extend $scope.details,details


                    $scope.blockUI.stop()
            .catch (response) ->
                msgInfo = 'No results found'
                if response.data.status is 'error'
                    msgInfo = response.data?.message

                $scope.alertMsg {msg: msgInfo}
                $scope.blockUI.stop()
                    


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

                console.log resp
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

                if angular.isDefined resp.data.backend_detail_url
                    window.location.href = resp.data.backend_detail_url


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

                sendData = $systemFactory.objectToFormData($scope.details)
                $uploaderFactory.upload $scope.link.lists,sendData,[]


                # window.location.reload()
            catch e
                $scope.alertMsg {msg: e}


        # END DETAIL START #


        # START appmarket googleplay #

        $scope.searchFromGooglePlay = () ->

            $scope.blockSearchUI.start('Please Wait . . .')
            $scope.isSearching = true
            $apiFactory.sendRequest $scope.details, $scope.link.app_search, 'POST'
                .then (response) ->
                    if response.data.status is 'error'
                        $scope.alertMsg {msg: response.data.message}
                    else
                        
                        result          = response.data.data
                        $scope.appLists = result
                        $scope.paginate = result.paginate

                    $scope.isSearching = false
                    $scope.blockSearchUI.stop()

        $scope.importApp = (item) ->

            if $scope.categoryObj.list.length < 1
                $scope.alertMsg {msg: 'Please select atleast one category where to import your apps / games.'}
                return false

            $scope.blockSearchUI.start('Please Wait . . .')

            catIds = []
            k = 0
            while k < $scope.categoryObj.list.length
                catIds[k] = $scope.categoryObj.list[k].id
                k++

            item.user_id = APPMarket.user_id

            $apiFactory.sendRequest {data:item,categories: catIds}, $scope.link.app_import, 'POST'
            .then (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}
                else
                    $scope.alertMsg {msg: response.data.message,success:true}
                    # window.location.href = $scope.link.root
                $scope.blockSearchUI.stop()

            ,(response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: res.data.message}
                    $scope.blockSearchUI.stop()

        $scope.searchBulkAction = () ->

            if $scope.categoryObj.list.length < 1
                $scope.alertMsg {msg: 'Please select atleast one category where to import your apps / games.'}
                return false

            appIds = []
            i = 0
            while i < $scope.appLists.length
                if $scope.appLists[i].is_checked is true
                    obj = $scope.appLists[i]
                    obj.user_id = APPMarket.user_id
                    appIds[i] = obj
                i++

            catIds = []
            k = 0
            while k < $scope.categoryObj.list.length
                catIds[k] = $scope.categoryObj.list[k].id
                k++

            
            opts = 
                title               :'Please Confirm'
                text                : 'Do you want to import all app/games selected?'
                html                : true
                showCancelButton    : true
                cancelButtonText    : 'Cancel'

            $sweetAlertService.swal opts, (isConfirm) ->
                if(isConfirm)
                   
                    $scope.blockSearchUI.start('Please Wait . . .')
                    $apiFactory.sendRequest {data:appIds,categories: catIds,is_bulk: true}, $scope.link.app_import, 'POST'
                    .then (response) ->
                        if response.data.status is 'error'
                            $scope.alertMsg {msg: response.data.message}
                        else
                            $scope.alertMsg {msg: response.data.message,success:true}
                            # window.location.href = $scope.link.root
                            $scope.appLists = []
                        $scope.blockSearchUI.stop()

                    ,(response) ->
                        if response.data.status is 'error'
                            $scope.alertMsg {msg: res.data.message}
                            $scope.blockSearchUI.stop()

        $scope.searchSelectAll = () ->

            i = 0
            while i < $scope.appLists.length
                $scope.appLists[i].is_checked = $scope.details.allItemsSelected
                i++


        $scope.searchSelectedItem = () ->
            i = 0
            while i < $scope.appLists.length
                if $scope.appLists[i].is_checked is false
                    $scope.details.allItemsSelected = false
                i++
            $scope.details.allItemsSelected = true


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


        $scope.search = () ->
            $scope.loadCollections()

        $scope.clearAll = () ->
            $scope.details = 
                search   : ''
                letter   : ''
                per_page : 50

            $scope.loadCollections()

        $scope._slug = (str) ->
            str.toString()
                .toLowerCase()
                .replace(/[^\w\s-]/g, '') #remove non-word [a-z0-9_], non-whitespace, non-hyphen characters
                .replace(/[\s_-]+/g, '-') #swap any length of whitespace, underscore, hyphen characters with a single -
                .replace(/^-+|-+$/g, ''); # remove leading, trailing -

        $scope.perPageChange = (page) ->
            $scope.details.per_page = page
            $scope.loadCollections()

        $scope.statusChange = () ->
            $scope.isEdit = false

        $scope.letterFilter = (letter) ->
            $scope.details.letter = letter

            $scope.loadCollections()

        $scope.blockui = (instanceName) ->
                return blockUI.instances.get(instanceName)

    new AppsController()

]