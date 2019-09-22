###*
# __DESCRIPTIONS__
# __SHORT_DESCRIPTION__
#
# @class        Pagination Directive
# @package      AngularModules
# @author       Anthony Pillos <dev.anthonypillos@gmail.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

angular.module('PaginationDirective',[]).directive "paginationDirective", ->
  restrict: "E"
  template : (tElem, tAttr)->
    if tAttr.mode == 'simple'
      '<ul class="pagination" ng-if="range.length > 1">'+
        '<li ng-class="currentPage == 1 ? \'disabled\' : \'\'">'+
        '<button class="btn paginate-directive-btn" ng-disabled="currentPage == 1" ng-click="getCollections(currentPage-1)">&lsaquo; Prev</button>'+
        '</li>'+
        '<li ng-class="currentPage == totalPages ? \'disabled\' : \'\'">'+
        '<button class="btn paginate-directive-btn" ng-disabled="currentPage == totalPages" ng-click="getCollections(currentPage+1)">Next &rsaquo;</button>'+
        '</li>'+
      '</ul>'
    else
      '<ul class="pagination" ng-if="range.length > 1">'+
        '<li class="page-item" ng-show="currentPage != 1"><a class="page-link" href="javascript:void(0)" ng-click="getCollections(1)">&laquo;</a></li>'+
        '<li class="page-item" ng-show="currentPage != 1"><a class="page-link" href="javascript:void(0)" ng-click="getCollections(currentPage-1)">&lsaquo; Prev</a></li>'+
        '<li class="page-item" ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
            '<a class="page-link" href="javascript:void(0)" ng-click="getCollections(i)">{{ i }}</a>'+
        '</li>'+
        '<li class="page-item" ng-show="currentPage != totalPages"><a class="page-link" href="javascript:void(0)" ng-click="getCollections(currentPage+1)">Next &rsaquo;</a></li>'+
        '<li class="page-item" ng-show="currentPage != totalPages"><a class="page-link" href="javascript:void(0)" ng-click="getCollections(totalPages)">&raquo;</a></li>'+
      '</ul>'