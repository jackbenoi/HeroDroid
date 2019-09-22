###*
# SystemFactory
#
# @class SystemFactory
# @package AngularModules
# @author       Anthony Pillos <dev.anthonypillos@gmail.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

# extend underscore
_.mixin capitalize: (string) ->
  string.charAt(0).toUpperCase() + string.substring(1).toLowerCase()


angular.module('SystemFactory',[]).factory "SystemFactory",
    ['$rootScope',
        ($rootScope) ->

            
            ###*
            # validateObj()
            #
            # @return
            ###
            validateObj : (obj,requiredFields) ->

                if _h.isEmptyObj obj
                    throw 'Empty Input, Cannot Validate'

                _.each requiredFields, (val, key) ->
                    if angular.isUndefined obj[val]
                        throw 'Missing required input: ' + val

                    if obj[val] is ''
                        throw 'Empty input data for : ' + val

                return true

            ###*
            # Transform Object to FormData
            # Ex.
            # data = obj: 
            #            prop: 'property value'
            #           arr: [
            #             'one'
            #             'two'
            #             'three'
            #             new File([ '' ], '')
            #           ]
            #           file: new File([ '' ], '')
            # 
            # objectToFormData(data)
            #
            #
            # @param (object) obj
            # @param (object) form
            # @param (string) namespace
            # @return void
            ###
            objectToFormData: (obj, form, namespace) ->
                fd = form or new FormData
                formKey = undefined
                for property of obj
                    if obj.hasOwnProperty(property)
                        if namespace
                            formKey = namespace + '[' + property + ']'
                        else
                            formKey = property
                        # if the property is an object, but not a File,
                        # use recursivity.
                        if typeof obj[property] == 'object' and !(obj[property] instanceof File)
                            @objectToFormData obj[property], fd, formKey
                        else
                            # if it's a string or a File object
                            fd.append formKey, obj[property]
                fd
]
