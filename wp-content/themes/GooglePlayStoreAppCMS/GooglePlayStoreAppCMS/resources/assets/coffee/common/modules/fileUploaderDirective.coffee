###*
# Provide Drag and Drop Capability using this file-uploader directive
#
# Inside of your controller you can listen to this events( $scope.$on('listener_name') )
# - file:unknown
# - file:uploading
#
# Example:
#   * For Single Upload with identifier
#   * Note: identifier is just a name, for your upload
#        in case you have 2 different uploads,
#        identifier serve as your unique name for each upload.
#        if you omit the identifier, it will show "fileupload" as default name
#
#       <div file-uploader is-multiple="false" identifier="front"></div>
#
#   * For Upload with inside array
#   * Make sure you pass, the whole object from my-file and the $index, so you have control in your controller
#        <div ng-repeat="file in uploadFiles track by $index">
#            <div file-uploader my-file="file" index="$index"></div>
#        </div>
#
#
# @class fileUploader Directives
# @package AngularModules
# @author       Anthony Pillos <dev.anthonypillos@gmail.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

angular.module('FileUploaderDirective',[])

.directive "fileUploader", ['$rootScope', ($rootScope) ->

    restrict: "A"
    scope:
        imagePreview: '='
        isMultiple: '='
        myFile: '='
        index: '='

    link: (scope, element, attrs) ->

        onDragOver = (e) ->
            e.preventDefault()
            element.addClass "dragOver"
            return

        onDragEnd = (e) ->
            e.preventDefault()
            element.removeClass "dragOver"
            return

        loadFile = (fileObj) ->
            # if fileObj is empty
            isMultiple = false
            if not fileObj
                throw 'File Unknown'
                # we can use emit for this, but i disable for the mean time..
                # return scope.$emit 'file:unknown', 'File Unknown'

            # allow multiple files to upload
            if scope.isMultiple
                isMultiple = true
                multipleUpload = []
                angular.forEach fileObj, (file,key) ->
                    file.isMultiple = 1

                    # if scope.imagePreview
                    #     _fileReader file
                    multipleUpload.push file

                fileObjectData = multipleUpload
            else
                # if scope.imagePreview
                #     _fileReader fileObj[0]

                fileObjectData = fileObj[0]

            # added default value for status
            fileObjectData.status = 0

            if angular.isUndefined attrs.identifier
                attrs.identifier = "fileupload"

            if angular.isUndefined(scope.myFile) and angular.isUndefined(scope.index)
                return $rootScope.$emit 'file:uploading',fileObjectData,attrs.identifier,isMultiple

            scope.myFile.file = fileObjectData
            # notify controller that the customer drag a file inside our directives
            # and now, you can do the validation from your controller once you
            # listen in this event
            $rootScope.$emit 'file:upload-in-array',scope.myFile,scope.index


        _fileReader = (file) ->
            if window.File and window.FileReader and window.FileList and window.Blob
                reader = new FileReader
                reader.onload = (evt) ->
                    file.image_url = reader.result
                reader.readAsDataURL file
            else
                file.image_url = '#'

        element.bind 'change', (e) ->
            loadFile e.originalEvent.target.files
            e?.preventDefault()
            e?.stopPropagation()
            return

        element.bind("dragover", onDragOver).bind("dragleave", onDragEnd).bind "drop", (e) ->
            onDragEnd e
            loadFile e.originalEvent.dataTransfer.files
            e?.preventDefault()
            e?.stopPropagation()
            return

        return
]