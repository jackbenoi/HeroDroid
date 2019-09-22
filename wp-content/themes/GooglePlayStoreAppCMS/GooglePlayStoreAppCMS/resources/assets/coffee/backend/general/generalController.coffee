###*
# GeneralController
# __SHORT_DESCRIPTION__
#
# @class        GeneralController
# @package      APPMarket.Backend.BackendApp
# @author       Anthony Pillos <me@anthonypillos.com>
# @copyright    Copyright (c) 2017 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

APPMarket.Backend.BackendApp.controller "GeneralController",
['$scope'
'$timeout'
'$rootScope'
'ApiFactory'
'ListingService'
'SystemFactory'
'blockUI'
'SweetAlertService'
'UploaderFactory'
($scope
$timeout
$rootScope
$apiFactory
$listingService
$systemFactory
blockUI
$sweetAlertService
$uploaderFactory) ->

    class GeneralController

        ###*
        #
        # @return
        ###
        constructor : () ->

            $scope.resources 	= APPMarket.Resources
            $scope.vars         = APPMarket.Vars
            $scope.link         =
                lists       : $scope.resources.index
                validateApi : $scope.resources.validateApi
                uploadLogo  : $scope.resources.uploadLogo

            $scope.blockUI = $scope.blockui('blockui-effect')
            $scope.details = []
            $scope.upload  = {}

            $scope.lists()


        uploadSingle = $rootScope.$on 'file:uploading', (evt,fileObj,identifier,isMultiple) ->

            # validation
            $timeout () ->

                if identifier is 'app-image'
                    $scope.upload.file = fileObj

        complete = $rootScope.$on 'upload:complete', (evt, data, index)->
                
                resp = JSON.parse $uploaderFactory.dataObj[index].xhr.response

                if resp.status is 'error'
                    $scope.alertMsg {msg: resp.message}

                    if angular.isDefined($scope.blockUI)    
                        $scope.blockUI.stop()

                    return true

                $scope.alertMsg {msg: resp.message,success:true}
                window.location.reload()
                            
        $scope.uploadImage = ($image_key) ->

            if angular.isUndefined($scope.upload.image_key)
                $scope.upload.image_key = {}

            $scope.upload.image_key = $image_key

            sendData = $systemFactory.objectToFormData($scope.upload)
            $uploaderFactory.upload $scope.link.uploadLogo,sendData,[]


        $scope.deleteImage = (detail) ->
            $scope.blockUI.start('Please Wait . . .')
            $apiFactory.sendRequest detail, $scope.link.uploadLogo,'POST'
            .then (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}
                    $scope.blockUI.stop()
                else
                    window.location.reload()
                    $scope.blockUI.stop()

        $scope.lists = () ->
            $scope.blockUI.start('Please Wait . . .')
            $apiFactory.sendRequest {}, $scope.link.lists,'GET'
            .then (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}
                    $scope.blockUI.stop()
                else
                    dataObj        = response.data.data
                    $scope.details = dataObj

                    $scope.blockUI.stop()

        $scope.update = (details) ->

            obj = {}
            angular.forEach details, (input) ->
                _.each input.lists, (item) ->
                    obj[item.key] = item.value

            $scope.blockUI.start('Please Wait . . .')
            $apiFactory.sendRequest obj, $scope.link.lists+'/saving','PUT'
            .then (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}
                    $scope.blockUI.stop()
                else
                    dataObj        = response.data.data
                    $scope.alertMsg {msg: response.data.message,success:true}

                $scope.blockUI.stop()

        $scope.validatePurchaseCode = () ->
            apiLists = $scope.details.apk_download_via_api.lists

            puchaseCode   = ''
            buyerUsername = ''

            _.each apiLists, (data) ->

                if data.key is 'purchase_code'
                    puchaseCode = data['value']

                if data.key is 'buyer_username'
                    buyerUsername = data['value']


            if puchaseCode and buyerUsername

                obj = 
                    purchase_code: puchaseCode
                    buyer_username: buyerUsername

                $scope.blockUI.start('Please Wait . . .')
                $apiFactory.sendRequest obj, $scope.link.validateApi,'POST'
                .then (response) ->
                    if response.data.status is 'error'
                        $scope.alertMsg {msg: response.data.message}
                        $scope.blockUI.stop()
                    else
                        dataObj = response.data.data

                        _.each apiLists, (data) ->
                            if data.key is 'download_api_url'
                                data['value'] = dataObj.api
                                return

                        $scope.details.apk_download_via_api.lists = apiLists

                        $scope.alertMsg {msg: response.data.message,success:true}

                    $scope.blockUI.stop()
            else
                $scope.alertMsg {msg: "No purchase code and buyer username found"}

            
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
    new GeneralController()

]