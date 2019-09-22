
/**
 * FeaturedAppController
 * __SHORT_DESCRIPTION__
 *
 * @class        FeaturedAppController
 * @package      APPMarket.Backend.BackendApp
 * @author       Anthony Pillos <me@anthonypillos.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  APPMarket.Backend.BackendApp.controller("FeaturedAppController", [
    '$scope', '$rootScope', '$timeout', 'blockUI', 'ApiFactory', 'ListingService', 'SystemFactory', 'SweetAlertService', 'UploaderFactory', function($scope, $rootScope, $timeout, blockUI, $apiFactory, $listingService, $systemFactory, $sweetAlertService, $uploaderFactory) {
      var FeaturedAppController;
      FeaturedAppController = (function() {

        /**
         *
         * @return
         */
        function FeaturedAppController() {
          $scope.resources = APPMarket.Resources;
          $scope.vars = APPMarket.Vars;
          $scope.link = {
            root: $scope.resources.root,
            lists: $scope.resources.index,
            addToFeaturedItem: $scope.resources.addToFeaturedItem,
            removeToFeaturedItem: $scope.resources.removeToFeaturedItem
          };
          $scope.blockUI = $scope.blockui('blockui-effect');
          $scope.blockSearchUI = $scope.blockui('search-result');
          $scope.details = {};
          $scope.per_page = 50;
          $scope.letters = $scope.vars.alpha;
          $scope.details = {
            per_page: 50,
            search: '',
            letter: ''
          };
          $scope.pagePresetKey = 'appmarket-page';
          $scope = angular.extend($scope, $listingService, {
            getCollections: function(pageNum) {
              return $scope.getOrderLists(pageNum);
            }
          });
          $scope.loadCollections();
        }

        $scope.loadCollections = function() {
          return $timeout(function() {
            var pageNum;
            pageNum = _h.get($scope.pagePresetKey) || 1;
            if ($scope.details.search !== '') {
              pageNum = 1;
            }
            return $scope.getCollections(pageNum);
          });
        };

        $scope.getOrderLists = function(pageNum) {
          var featured, letter, perpage, routes, search;
          pageNum = pageNum || 1;
          $scope.blockUI.start('Please Wait . . .');
          _h.set($scope.pagePresetKey, pageNum);
          $scope.details.per_page = angular.isUndefined($scope.details.per_page) ? $scope.per_page : $scope.details.per_page;
          $scope.details.search = angular.isUndefined($scope.details.search) ? '' : $scope.details.search;
          search = '&search=' + $scope.details.search;
          perpage = '&per_page=' + $scope.details.per_page;
          letter = '&letter=' + $scope.details.letter;
          featured = '&is_featured=yes';
          routes = $scope.link.lists + '?page=' + pageNum + search + letter + perpage + featured;
          return $scope.requestData(routes, 'GET').success(function(response) {
            if (response.data != null) {
              angular.bind($scope, $scope.dataHandler(response));
            } else {
              _h.set($scope.pagePresetKey, 1);
              $scope.data = [];
              $scope.range = [];
              $scope.totalPages = 0;
            }
            return $timeout(function() {
              return $scope.blockUI.stop();
            }, 500);
          });
        };

        $scope.addAllSelected = function() {
          var featuredItems;
          featuredItems = [];
          angular.forEach($scope.data, function(val, index) {
            if (val.is_featured === true) {
              return featuredItems.push(val.id);
            }
          });
          return $apiFactory.sendRequest({
            items: featuredItems
          }, $scope.link.addToFeaturedItem, 'POST').then(function(response) {
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
              return $scope.blockUI.stop();
            } else {
              window.location.reload();
              return $scope.blockUI.stop();
            }
          })["catch"](function(response) {
            if (response.data.status === 'error') {
              return $scope.alertMsg({
                msg: 'No query results found, You will be redirected back in 2 seconds...'
              });
            }
          });
        };

        $scope["delete"] = function(id) {
          return $apiFactory.sendRequest({
            id: id
          }, $scope.link.removeToFeaturedItem, 'POST').then(function(response) {
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
              return $scope.blockUI.stop();
            } else {
              window.location.reload();
              return $scope.blockUI.stop();
            }
          })["catch"](function(response) {
            if (response.data.status === 'error') {
              return $scope.alertMsg({
                msg: 'No query results found, You will be redirected back in 2 seconds...'
              });
            }
          });
        };

        $scope.alertMsg = function(opts) {
          var opt, options;
          options = {
            title: 'System Response',
            msg: 'Problem in your request!'
          };
          opt = angular.merge(options, opts);
          if (opt.success === true) {
            return $sweetAlertService.success(opt.title, opt.msg);
          }
          return $sweetAlertService.error(opt.title, opt.msg);
        };

        $scope.search = function() {
          return $scope.loadCollections();
        };

        $scope.clearAll = function() {
          $scope.details = {
            search: '',
            letter: '',
            per_page: 50
          };
          return $scope.loadCollections();
        };

        $scope.perPageChange = function(page) {
          $scope.details.per_page = page;
          return $scope.loadCollections();
        };

        $scope.letterFilter = function(letter) {
          $scope.details.letter = letter;
          return $scope.loadCollections();
        };

        $scope.blockui = function(instanceName) {
          return blockUI.instances.get(instanceName);
        };

        return FeaturedAppController;

      })();
      return new FeaturedAppController();
    }
  ]);

}).call(this);

//# sourceMappingURL=featuredApp.js.map
