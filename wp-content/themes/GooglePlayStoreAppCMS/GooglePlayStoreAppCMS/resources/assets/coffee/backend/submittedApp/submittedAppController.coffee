###*
# SubmittedAppController
# __SHORT_DESCRIPTION__
#
# @class        SubmittedAppController
# @package      APPMarket.Backend.BackendApp
# @author       Anthony Pillos <me@anthonypillos.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

APPMarket.Backend.BackendApp.controller "SubmittedAppController",
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

    class SubmittedAppController

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

            else

                # $scope.uploads    = {}
                # $scope.categories = $scope.vars.categories
                # $scope.apkFile = $scope.apkFiles = 
                #     app_version : ''
                #     signature   : ''
                #     sha_1       : ''
                #     description : ''
                #     app_link    : ''
                #     file        : {}

                # $scope.details  =
                #     image_app      : {}
                #     screenshots    : []
                #     is_enabled     : true
                #     app_id         : ''
                #     title          : ''
                #     description    : ''
                #     image_url      : ''
                #     link           : ''
                #     developer_link : ''
                #     developer_name : ''
                #     apk_files      : []
                #     versions       : []

                # # if is create = 0, it means we just need to load the details
                # if $scope.vars.is_create is 0
                #     $scope.getDetail()

 
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


            search              = '&search='+$scope.details.search
            perpage             = '&per_page='+$scope.details.per_page
            letter              = '&letter='+$scope.details.letter
            submittedAppType    = '&is_submitted=yes'

            routes = $scope.link.lists+'?page='+pageNum+search+letter+perpage+submittedAppType

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
                    window.location.reload()

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

    new SubmittedAppController()

]