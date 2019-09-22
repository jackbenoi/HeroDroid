###*
# Only Number Input
#
# @category     ToggleDirective
# @author       Anthony Pillos <dev.anthonypillos@gmail.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

angular.module('ToggleDirective',[])

.directive "toggle", ['$rootScope', ($rootScope) ->

    restrict: 'A'
    link: (scope, element, attrs) ->
      if attrs.toggle == 'tooltip'
        $(element).tooltip()
      if attrs.toggle == 'popover'
        $(element).popover()
      return
]