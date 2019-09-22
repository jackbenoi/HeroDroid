###*
# __DESCRIPTIONS__
# __SHORT_DESCRIPTION__
#
# @class UploadFactory
# @package AngularModules
# @author       Anthony Pillos <dev.anthonypillos@gmail.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###


angular.module('UploadFactory',[]).factory "UploaderFactory",
['$rootScope'
'$timeout'
($rootScope
$timeout) ->

    dataObj : []
    xhr     : []

    defaultIndex: 0

    ###*
    # __DESCRIPTIONS
    #
    # @params void
    ###
    httpRequest: (index) ->

        if window.XMLHttpRequest
          try
            @xhr[index] = new XMLHttpRequest
          catch ex
            @xhr[index] = new (window.ActiveXObject)('Microsoft.XMLHTTP')
        else
            # for the mean time..
            return false

    ###*
    # __DESCRIPTIONS
    #
    # @params void
    ###
    upload: (url,formObj,dataObj,index) ->

        if angular.isUndefined index
            index = @defaultIndex

        @xhr[index] = @httpRequest(index)
        if !@xhr[index]
            $rootScope.$emit 'upload:bad'
            return false

        @dataObj[index] = dataObj
        @xhr[index].open "POST",url
        @dataObj[index].xhr = @xhr[index]

        @xhr[index].setRequestHeader("X-CSRF-Token", angular.element("meta[name='_token']").attr('content'))
        @xhr[index].setRequestHeader("X-Requested-With", 'XMLHttpRequest')

        _this = @
        _this.xhr[index].upload.onprogress = (evt) ->
            _this.progress evt,index

        _this.xhr[index].onabort = () ->
            _this.abort index

        _this.xhr[index].onerror = () ->
            _this.abort index

        _this.xhr[index].onload = (evt) ->
            _this.complete evt,index

        _this.xhr[index].onreadystatechange = (evt) ->
            if _this.xhr[index].readyState is 4
                $timeout () ->
                    if _this.xhr[index]?.response
                        _this.dataObj[index].response   = JSON.parse _this.xhr[index].response
                        _this.dataObj[index].status     = if _this.dataObj[index].response.status is "error" then 0 else 2
                        _this.dataObj[index].xhr[index] = false

        _this.xhr[index].send formObj

    ###*
    # __DESCRIPTIONS
    #
    # @params void
    ###
    progress: (evt,index) ->
        _this = @
        if evt.type is 'progress'
            $timeout () ->
                _this.dataObj[index].status = 1
                if evt.lengthComputable
                    _this.dataObj[index].progress = Math.round(evt.loaded * 100 / evt.total)
                else
                    _this.dataObj[index].progress = 0


    ###*
    # __DESCRIPTIONS
    #
    # @params void
    ###
    abort: (index) ->
        _this = @
        $timeout () ->
            _this.dataObj[index].status = 0
            _this.dataObj[index].xhr.abort()
            # hook in, abort function
            $rootScope.$emit 'upload:abort', index

    ###*
    # __DESCRIPTIONS
    #
    # @params void
    ###
    complete: (evt,index) ->
        $rootScope.$emit 'upload:complete',@dataObj[index],index

]