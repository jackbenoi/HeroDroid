
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

angular.module('htmlBindDirective',[])
.directive 'htmlBind',['$compile', ($compile) ->
	{
	restrict: 'A'
	replace: true
	scope: dynamic: '=htmlBind'
	link: (scope, element, attrs) ->
	  scope.$watch 'attrs.htmlBind', (html) ->
	    element.html scope.dynamic
	    $compile(element.contents()) scope
	    return
	  return

	}
]