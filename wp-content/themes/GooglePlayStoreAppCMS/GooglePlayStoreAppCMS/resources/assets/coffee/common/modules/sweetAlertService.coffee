###*
# SweetAlertService
# Handle SweetAlert Wrapper
#
# @package SweetAlertService
# @author       Anthony Pillos <dev.anthonypillos@gmail.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

angular.module('SweetAlertService',[]).service "SweetAlertService",
[
    '$rootScope',
    ($rootScope) ->

        return options =  
            swal: (arg1, arg2, arg3) ->
                $rootScope.$evalAsync ->
                  if typeof arg2 == 'function'
                    swal arg1, ((isConfirm) ->
                      $rootScope.$evalAsync ->
                        arg2 isConfirm
                        return
                      return
                    ), arg3
                  else
                    swal arg1, arg2, arg3
                  return
                return
            success: (title, message) ->
                $rootScope.$evalAsync ->
                  swal title, message, 'success'
                  return
                return
            error: (title, message) ->
                $rootScope.$evalAsync ->
                  swal title, message, 'error'
                  return
                return
            warning: (title, message) ->
                $rootScope.$evalAsync ->
                  swal title, message, 'warning'
                  return
                return
            info: (title, message) ->
                $rootScope.$evalAsync ->
                  swal title, message, 'info'
                  return
                return
            showInputError: (message) ->
                $rootScope.$evalAsync ->
                  swal.showInputError message
                  return
                return
            close: ->
                $rootScope.$evalAsync ->
                  swal.close()
                  return
                return

]