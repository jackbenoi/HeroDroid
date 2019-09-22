###*
# ParentCategoryController
# __SHORT_DESCRIPTION__
#
# @class        ParentCategoryController
# @package      APPMarket.Backend.BackendApp
# @author       Anthony Pillos <me@anthonypillos.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

APPMarket.Backend.BackendApp.controller "ParentCategoryController",
['$scope'
'$timeout'
'blockUI'
'ApiFactory'
'ListingService'
'SystemFactory'
'SweetAlertService'
(
    $scope
    $timeout
    blockUI
    $apiFactory
    $listingService
    $systemFactory
    $sweetAlertService
) ->

    class ParentCategoryController

        ###*
        #
        # @return
        ###
        constructor : () ->
            

            $scope.resources    = APPMarket.Resources
            $scope.vars         = APPMarket.Vars
            $scope.link         =
                root          : $scope.resources.root
                lists         : $scope.resources.index

            $scope.blockUI  = $scope.blockui('blockui-effect')
            $scope.details  = {}
            $scope.per_page = 20
            $scope.letters = $scope.vars.alpha

            

            if $scope.vars.hash_id is 0 and $scope.vars.is_create is 0
                
                $scope.pagePresetKey = 'appmarket-parent-category-page'
                $scope = angular.extend $scope, $listingService, {
                    getCollections: (pageNum) -> $scope.getOrderLists(pageNum)
                }
                $scope.loadCollections()

            else

                $scope.details.is_enabled = true
                # if is create = 0, it means we just need to load the details
                if $scope.vars.is_create is 0
                    $scope.getDetail()

       #  # DETAIL START #
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
                    dataObj                   = response.data.data
                    $scope.details            = dataObj
                    $scope.details.is_enabled = if $scope.details.is_enabled is 1 then true else false

                    $scope.blockUI.stop()
            .catch (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: 'No query results found, You will be redirected back in 2 seconds...'}
                    $timeout () ->
                        window.location.href = $scope.link.root
                    ,2000


       #  # DETAIL END #

        $scope.create = (isDraft) ->

            try
                # assign user_id
                $scope.details.user_id = APPMarket.user_id
                $systemFactory.validateObj $scope.details,['title','description','user_id']
                $scope.details.is_enabled = if $scope.details.is_enabled is true or $scope.details.is_enabled is 1 then 1 else 0

                $scope.blockUI.start('Please Wait . . .')
                $apiFactory.sendRequest $scope.details, $scope.link.lists,'POST'
                .then (response) ->

                    if response.data.status is 'error'
                        $scope.alertMsg {msg: response.data.message}
                        $scope.blockUI.stop()
                    else
                        dataObj = response.data
                        window.location.href = dataObj.data.backend_detail_url
                        $scope.blockUI.stop()
            catch e
                $scope.alertMsg {msg: e}

       $scope.update = () ->
            try
                # assign user_id
                $scope.details.user_id = APPMarket.user_id
                $systemFactory.validateObj $scope.details,['title','description','user_id']
                $scope.details.is_enabled = if $scope.details.is_enabled is true then 1 else 0

                $scope.blockUI.start('Please Wait . . .')
                $apiFactory.sendRequest $scope.details, $scope.link.lists+'/'+$scope.vars.hash_id,'PUT'
                .then (response) ->

                    if response.data.status is 'error'
                        $scope.alertMsg {msg: response.data.message}
                        $scope.blockUI.stop()
                    else
                        dataObj = response.data
                        window.location.reload()
                        $scope.blockUI.stop()
            catch e
                $scope.alertMsg {msg: e}

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

            routes = $scope.link.lists+'?page='+pageNum+search+perpage
            
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

        $scope.delRequest   = (data) ->

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

        $scope.delModal = (data) ->
            
            opts = 
                title               :'Please Confirm'
                text                : _h.sprintf 'Do you want to delete this page (<strong>%s</strong>)?',data.title
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


       #  $scope.search = () ->
       #      $scope.loadCollections()

       #  $scope.clearAll = () ->
       #      $scope.details = 
       #          search   : ''
       #          letter   : ''
       #          per_page : 50

       #      $scope.loadCollections()

       #  $scope._slug = (str) ->
       #      str.toString()
       #          .toLowerCase()
       #          .replace(/[^\w\s-]/g, '') #remove non-word [a-z0-9_], non-whitespace, non-hyphen characters
       #          .replace(/[\s_-]+/g, '-') #swap any length of whitespace, underscore, hyphen characters with a single -
       #          .replace(/^-+|-+$/g, ''); # remove leading, trailing -

       #  $scope.perPageChange = () ->
       #      $scope.loadCollections()

       #  $scope.statusChange = () ->
       #      $scope.isEdit = false

       #  $scope.letterFilter = (letter) ->
       #      $scope.details.letter = letter

       #      $scope.loadCollections()

        $scope.blockui = (instanceName) ->
                return blockUI.instances.get(instanceName)

    new ParentCategoryController()

]