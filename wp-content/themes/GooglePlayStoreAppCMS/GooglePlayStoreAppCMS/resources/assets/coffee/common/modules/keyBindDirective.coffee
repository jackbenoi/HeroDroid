###*
# Key Bind
#
# @author       Anthony Pillos <dev.anthonypillos@gmail.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
#
# Ex. 
# esc : 'clear()' instead of esc : clear()
# <input key-bind="{ enter: 'go()', esc: 'clear()' }" type="text"
#
###

angular.module('KeyBindDirective',[])

.constant('keyCodes',
  esc       : 27
  space     : 32
  enter     : 13
  tab       : 9
  backspace : 8
  shift     : 16
  ctrl      : 17
  alt       : 18
  capslock  : 20
  numlock   : 144
)
.directive 'keyBind', [
  'keyCodes'
  (keyCodes) ->

    map = (obj) ->
      mapped = {}
      for key of obj
        action = obj[key]
        if keyCodes.hasOwnProperty(key)
          mapped[keyCodes[key]] = action
      mapped

    (scope, element, attrs) ->
      bindings = map(scope.$eval(attrs.keyBind))
      element.bind 'keyup', (event) ->
        if bindings.hasOwnProperty(event.which)
            scope.$apply () ->
                scope.$eval bindings[event.which]
]