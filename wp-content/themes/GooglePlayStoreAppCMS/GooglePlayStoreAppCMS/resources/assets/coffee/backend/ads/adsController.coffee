###*
# AdsController
# __SHORT_DESCRIPTION__
#
# @class        AdsController
# @package      APPMarket.Backend.BackendApp
# @author       Anthony Pillos <me@anthonypillos.com>
# @copyright    Copyright (c) 2017 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

APPMarket.Backend.BackendApp.controller "AdsController",
['$scope'
'$rootScope'
'$timeout'
'ApiFactory'
'ListingService'
'blockUI'
'SystemFactory'
'UploaderFactory'
'SweetAlertService'
($scope
$rootScope
$timeout
$apiFactory
$listingService
blockUI
$systemFactory
$uploaderFactory
$sweetAlertService) ->

    class AdsController

        ###*
        #
        # @return
        ###
        constructor : () ->

            $scope.resources    = APPMarket.Resources
            $scope.vars         = APPMarket.Vars
            $scope.link         =
                lists  : $scope.resources.index
                save  : $scope.resources.save

            $scope.blockUITable = $scope.blockui('blockui-table')
            $scope.blockUINew   = $scope.blockui('blockui-new')
            $scope.blockui      = $scope.blockui('blockui-effect')

            # object model
            $scope.details = {}
            $scope.isEdit  = false

            # listing
            $scope.pagePresetKey = 'iqcms-ads'
            $scope = angular.extend $scope, $listingService, {
                getCollections: (pageNum) -> $scope.getOrderLists(pageNum)
            }
            $scope.loadCollections()

            $scope.adsBlockLists = []
            $scope.adsPlacements = {}

            $scope.adsArray     = $scope.vars.adsArray
            $scope.adsPlacement = $scope.vars.adsPlacement


        $scope.$watch 'adsBlockLists', (newVal, oldVal) ->
            if newVal != oldVal
                angular.forEach $scope.adsArray, (ads,key) ->

                    blockLists = _.findWhere $scope.adsBlockLists, {id: ads.advertisement_blocks_id}
                    $scope.adsPlacements[ads.identifier] = blockLists

        $scope.loadAdsBlock = () ->

            $scope.blockui.start 'Please wait...'
            routes = $scope.link.lists+'?return=all'
            $apiFactory.sendRequest {},routes,'GET'
                .success (response) ->
                    if response.status is 'error'
                        console.log 'error'
                    else
                        $scope.adsBlockLists = response.data

                    $scope.blockui.stop()



        $scope.loadCollections = () ->
            $timeout () ->

                pageNum = _h.get($scope.pagePresetKey ) || 1
                if $scope.details.search != '' || $scope.details.letter != ''
                    pageNum = 1
                $scope.getCollections pageNum

        $scope.getOrderLists = (pageNum) ->
            pageNum = pageNum || 1
            $scope.blockUITable.start('Please Wait . . .')

            _h.set $scope.pagePresetKey, pageNum

            perpage = '&per_page=30'
            routes = $scope.link.lists+'?page='+pageNum+perpage

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
                        $scope.blockUITable.stop()
                    ,500


       $scope.clearBlock = () ->
            $scope.details  = {}
            $scope.isEdit   = false

        $scope.updateData = (blockObj) ->
            $scope.blockUINew.start('Please Wait . . .')

            $apiFactory.sendRequest $scope.details, $scope.link.lists+'/'+blockObj.id, 'PUT'
            .then (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}
                else
                    window.location.reload()

                $scope.blockUINew.stop()

        $scope.editData = (blockObj) ->
            $scope.isEdit  = true
            $scope.details = blockObj


        $scope.addData = () ->
            $scope.blockUINew.start('Please Wait . . .')
            routes = $scope.link.adsBlockUrl

            $apiFactory.sendRequest $scope.details, $scope.link.lists, 'POST'
            .then (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}
                else
                    window.location.reload()

                $scope.blockUINew.stop()
            , (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}

                $scope.blockUINew.stop()

        $scope.delRequest   = (data) ->

            $scope.blockUITable.start('Please Wait . . .')
            $apiFactory.sendRequest {}, $scope.link.lists+'/'+data.id, 'DELETE'
            .then (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}
                else
                    $scope.alertMsg {msg: response.data.message,success: true}
                    $scope.loadCollections()

                $scope.blockUITable.stop()

        $scope.delModal = (data) ->
            
            opts = 
                title               :'Please Confirm'
                text                : _h.sprintf 'Do you want to delete this block (<strong>%s</strong>)?',data.title
                html                : true
                showCancelButton    : true
                cancelButtonText    : 'Cancel'
            $sweetAlertService.swal opts, (isConfirm) ->
                if(isConfirm)
                    $scope.delRequest data


        $scope.alertMsg = (opts) ->
            options =
                title : 'System Response'
                msg   : 'Problem in your request!'
            opt = angular.merge options,opts

            if opt.success is true
                return $sweetAlertService.success opt.title,opt.msg
            return $sweetAlertService.error opt.title,opt.msg

        $scope.blockui = (instanceName) ->
                return blockUI.instances.get(instanceName)

    new AdsController()

]