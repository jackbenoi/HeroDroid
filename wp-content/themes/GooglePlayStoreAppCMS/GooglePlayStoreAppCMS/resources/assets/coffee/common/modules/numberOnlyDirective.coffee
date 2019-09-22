###*
# Only Number Input
#
# @author       Anthony Pillos <dev.anthonypillos@gmail.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

angular.module('NumberOnlyDirective',[])

.directive "numberOnly", () ->

    restrict : "A"
    require  : 'ngModel'
    link: ($scope, $element, $attrs, $model) ->

        filter = /[^0-9]/g

        if angular.isDefined $attrs.allowDecimal
            filter = /[^0-9.]/g

        $model.$parsers.push (inputValue) ->
            if inputValue == undefined
                return ''
            transformedInput = inputValue.replace filter, ''
            if transformedInput != inputValue
                $model.$setViewValue transformedInput
                $model.$render()
            transformedInput
        return