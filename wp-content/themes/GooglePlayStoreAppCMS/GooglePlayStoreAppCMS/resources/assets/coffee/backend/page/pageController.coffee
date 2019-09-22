###*
# PageController
# __SHORT_DESCRIPTION__
#
# @class        PageController
# @package      APPMarket.Backend.BackendApp
# @author       Anthony Pillos <me@anthonypillos.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

APPMarket.Backend.BackendApp.controller "PageController",
['$scope'
'$timeout'
'blockUI'
'ApiFactory'
'ListingService'
'SystemFactory'
'SweetAlertService'
($scope
$timeout
blockUI
$apiFactory
$listingService
$systemFactory
$sweetAlertService) ->

    class PageController

        ###*
        #
        # @return
        ###
        constructor : () ->

            $scope.resources 	= APPMarket.Resources
            $scope.vars         = APPMarket.Vars
            $scope.link         =
                root          : $scope.resources.root
                lists         : $scope.resources.index
                bulk_deletion : $scope.resources.bulk_deletion

            $scope.blockUI  = $scope.blockui('blockui-effect')
            $scope.details  = {}
            $scope.per_page = 20

            $scope.parent_page_lists = $scope.vars.page_lists
            $scope.status_lists      = $scope.vars.status_lists

            $scope.details.parent_page = _.findWhere $scope.vars.page_lists, {id: 0}


            if $scope.vars.hash_id is 0 and $scope.vars.is_create is 0
                $scope.pagePresetKey = 'APPMarket-page'
                $scope = angular.extend $scope, $listingService, {
                    getCollections: (pageNum) -> $scope.getOrderLists(pageNum)
                }
                $scope.loadCollections()
                $scope.details.allItemsSelected = false


                $scope.dd_actions = {}

            else

                $scope.details.is_enabled = true
                # if is create = 0, it means we just need to load the details
                if $scope.vars.is_create is 0
                    $scope.getDetail()

        # DETAIL START #
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
                    $scope.details             = dataObj

                    $scope.details.is_enabled =  if $scope.details.is_enabled is 1 then true else false

                    $scope.blockUI.stop()
            .catch (response) ->
                if response.data.status is 'error'
                    $scope.alertMsg {msg: 'No query results found, You will be redirected back in 2 seconds...'}
                    $timeout () ->
                        window.location.href = $scope.link.root
                    ,2000


        # DETAIL END #

        # $scope.bulkAction = () ->
        #     if $scope.dd_actions.code is 'delete'
        #         deleteObjects = []

        #         i = 0
        #         while i < $scope.data.length
        #             if $scope.data[i].is_checked is true
        #                 deleteObjects[i] = $scope.data[i].id
        #             i++
                
        #         if deleteObjects.length > 0
        #             opts = 
        #                 title               :'Please Confirm'
        #                 text                : 'Do you want to delete this page(s)?'
        #                 html                : true
        #                 showCancelButton    : true
        #                 cancelButtonText    : 'Cancel'
        #             $sweetAlertService.swal opts, (isConfirm) ->
        #                 if(isConfirm)
                            
        #                     $scope.blockUI.start('Please Wait . . .')
        #                     $apiFactory.sendRequest {ids: deleteObjects}, $scope.link.bulk_deletion, 'POST'
        #                     .then (response) ->
        #                         if response.data.status is 'error'
        #                             $scope.alertMsg {msg: response.data.message}
        #                         else
        #                             # $scope.alertMsg {msg: response.data.message,success:true}
        #                             $scope.loadCollections()
        #                             # window.location.href = $scope.link.root

        #                         $scope.blockUI.stop()

        # $scope.selectAll = () ->
        #     i = 0
        #     while i < $scope.data.length
        #         $scope.data[i].is_checked = $scope.details.allItemsSelected
        #         i++


        # $scope.selectedItem = () ->
        #     i = 0
        #     while i < $scope.data.length
        #         if $scope.data[i].is_checked is false
        #             $scope.details.allItemsSelected = false
        #         i++
        #     $scope.details.allItemsSelected = true


        $scope.create = (isDraft) ->

            try
                # assign user_id
                $scope.details.user_id = APPMarket.user_id
                $systemFactory.validateObj $scope.details,['title','content','user_id']
                $scope.details.is_draft = if angular.isDefined(isDraft) then isDraft else 0

                $scope.details.is_enabled =  if $scope.details.is_enabled is true then 1 else 0

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

       $scope.update = (isDraft) ->
            try
                # assign user_id
                $scope.details.user_id  = APPMarket.user_id
                $systemFactory.validateObj $scope.details,['title','slug','content','user_id']
                $scope.details.is_draft = if angular.isDefined(isDraft) then isDraft else 0

                $scope.details.is_enabled =  if $scope.details.is_enabled is true then 1 else 0
                
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


        $scope.search = () ->
            $scope.loadCollections()

        $scope.clearAll = () ->
            $scope.details = 
                search   : ''
                letter   : ''
                per_page : 20

            $scope.loadCollections()

        $scope._slug = (str) ->
            str.toString()
                .toLowerCase()
                .replace(/[^\w\s-]/g, '') #remove non-word [a-z0-9_], non-whitespace, non-hyphen characters
                .replace(/[\s_-]+/g, '-') #swap any length of whitespace, underscore, hyphen characters with a single -
                .replace(/^-+|-+$/g, ''); # remove leading, trailing -

        $scope.perPageChange = () ->
            $scope.loadCollections()

        $scope.statusChange = () ->
            $scope.isEdit = false

        $scope.blockui = (instanceName) ->
                return blockUI.instances.get(instanceName)

    new PageController()

]