###*
# FeaturedAppController
# __SHORT_DESCRIPTION__
#
# @class        FeaturedAppController
# @package      APPMarket.Backend.BackendApp
# @author       Anthony Pillos <me@anthonypillos.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

APPMarket.Backend.BackendApp.controller "FeaturedAppController",
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

    class FeaturedAppController

        ###*
        #
        # @return
        ###
        constructor : () ->
            
            $scope.resources    = APPMarket.Resources
            $scope.vars         = APPMarket.Vars
            $scope.link         =
                root                 : $scope.resources.root
                lists                : $scope.resources.index
                addToFeaturedItem    : $scope.resources.addToFeaturedItem
                removeToFeaturedItem : $scope.resources.removeToFeaturedItem
                
            $scope.blockUI       = $scope.blockui('blockui-effect')
            $scope.blockSearchUI = $scope.blockui('search-result')
            $scope.details       = {}
            $scope.per_page      = 50
            $scope.letters       = $scope.vars.alpha
        
            
            $scope.details = 
                per_page : 50
                search   : ''
                letter   : ''

            $scope.pagePresetKey = 'appmarket-page'
            $scope = angular.extend $scope, $listingService, {
                getCollections: (pageNum) -> $scope.getOrderLists(pageNum)
            }
            $scope.loadCollections()

            

 
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
            featured  = '&is_featured=yes'

            routes = $scope.link.lists+'?page='+pageNum+search+letter+perpage+featured

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


        $scope.addAllSelected = () ->

            featuredItems = []
            angular.forEach $scope.data, (val,index) ->
                if val.is_featured is true
                    featuredItems.push val.id

            $apiFactory.sendRequest {items: featuredItems}, $scope.link.addToFeaturedItem,'POST'
            .then (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}
                    $scope.blockUI.stop()
                else
                    
                    window.location.reload()

                    $scope.blockUI.stop()
            .catch (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: 'No query results found, You will be redirected back in 2 seconds...'}
                    



        $scope.delete = (id) ->
            
            $apiFactory.sendRequest {id: id}, $scope.link.removeToFeaturedItem,'POST'
            .then (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: response.data.message}
                    $scope.blockUI.stop()
                else
                    
                    window.location.reload()

                    $scope.blockUI.stop()
            .catch (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: 'No query results found, You will be redirected back in 2 seconds...'}

        
        $scope.alertMsg = (opts) ->
            options =
                title : 'System Response'
                msg   : 'Problem in your request!'
            opt = angular.merge options,opts

            if opt.success is true
                return $sweetAlertService.success opt.title,opt.msg

            return $sweetAlertService.error opt.title,opt.msg


        $scope.search = () ->
            $scope.loadCollections()

        $scope.clearAll = () ->
            $scope.details = 
                search   : ''
                letter   : ''
                per_page : 50

            $scope.loadCollections()

        $scope.perPageChange = (page) ->
            $scope.details.per_page = page
            $scope.loadCollections()

        $scope.letterFilter = (letter) ->
            $scope.details.letter = letter

            $scope.loadCollections()

        $scope.blockui = (instanceName) ->
                return blockUI.instances.get(instanceName)

    new FeaturedAppController()

]