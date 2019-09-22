
/**
 * AdsController
 * __SHORT_DESCRIPTION__
 *
 * @class        AdsController
 * @package      APPMarket.Backend.BackendApp
 * @author       Anthony Pillos <me@anthonypillos.com>
 * @copyright    Copyright (c) 2017 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  APPMarket.Backend.BackendApp.controller("AdsController", [
    '$scope', '$rootScope', '$timeout', 'ApiFactory', 'ListingService', 'blockUI', 'SystemFactory', 'UploaderFactory', 'SweetAlertService', function($scope, $rootScope, $timeout, $apiFactory, $listingService, blockUI, $systemFactory, $uploaderFactory, $sweetAlertService) {
      var AdsController;
      AdsController = (function() {

        /**
         *
         * @return
         */
        function AdsController() {
          $scope.resources = APPMarket.Resources;
          $scope.vars = APPMarket.Vars;
          $scope.link = {
            lists: $scope.resources.index,
            save: $scope.resources.save
          };
          $scope.blockUITable = $scope.blockui('blockui-table');
          $scope.blockUINew = $scope.blockui('blockui-new');
          $scope.blockui = $scope.blockui('blockui-effect');
          $scope.details = {};
          $scope.isEdit = false;
          $scope.pagePresetKey = 'iqcms-ads';
          $scope = angular.extend($scope, $listingService, {
            getCollections: function(pageNum) {
              return $scope.getOrderLists(pageNum);
            }
          });
          $scope.loadCollections();
          $scope.adsBlockLists = [];
          $scope.adsPlacements = {};
          $scope.adsArray = $scope.vars.adsArray;
          $scope.adsPlacement = $scope.vars.adsPlacement;
        }

        $scope.$watch('adsBlockLists', function(newVal, oldVal) {
          if (newVal !== oldVal) {
            return angular.forEach($scope.adsArray, function(ads, key) {
              var blockLists;
              blockLists = _.findWhere($scope.adsBlockLists, {
                id: ads.advertisement_blocks_id
              });
              return $scope.adsPlacements[ads.identifier] = blockLists;
            });
          }
        });

        $scope.loadAdsBlock = function() {
          var routes;
          $scope.blockui.start('Please wait...');
          routes = $scope.link.lists + '?return=all';
          return $apiFactory.sendRequest({}, routes, 'GET').success(function(response) {
            if (response.status === 'error') {
              console.log('error');
            } else {
              $scope.adsBlockLists = response.data;
            }
            return $scope.blockui.stop();
          });
        };

        $scope.loadCollections = function() {
          return $timeout(function() {
            var pageNum;
            pageNum = _h.get($scope.pagePresetKey) || 1;
            if ($scope.details.search !== '' || $scope.details.letter !== '') {
              pageNum = 1;
            }
            return $scope.getCollections(pageNum);
          });
        };

        $scope.getOrderLists = function(pageNum) {
          var perpage, routes;
          pageNum = pageNum || 1;
          $scope.blockUITable.start('Please Wait . . .');
          _h.set($scope.pagePresetKey, pageNum);
          perpage = '&per_page=30';
          routes = $scope.link.lists + '?page=' + pageNum + perpage;
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
              return $scope.blockUITable.stop();
            }, 500);
          });
        };

        return AdsController;

      })();
      $scope.clearBlock = function() {
        $scope.details = {};
        return $scope.isEdit = false;
      };
      $scope.updateData = function(blockObj) {
        $scope.blockUINew.start('Please Wait . . .');
        return $apiFactory.sendRequest($scope.details, $scope.link.lists + '/' + blockObj.id, 'PUT').then(function(response) {
          if (response.data.status === 'error') {
            $scope.alertMsg({
              msg: response.data.message
            });
          } else {
            window.location.reload();
          }
          return $scope.blockUINew.stop();
        });
      };
      $scope.editData = function(blockObj) {
        $scope.isEdit = true;
        return $scope.details = blockObj;
      };
      $scope.addData = function() {
        var routes;
        $scope.blockUINew.start('Please Wait . . .');
        routes = $scope.link.adsBlockUrl;
        return $apiFactory.sendRequest($scope.details, $scope.link.lists, 'POST').then(function(response) {
          if (response.data.status === 'error') {
            $scope.alertMsg({
              msg: response.data.message
            });
          } else {
            window.location.reload();
          }
          return $scope.blockUINew.stop();
        }, function(response) {
          if (response.data.status === 'error') {
            $scope.alertMsg({
              msg: response.data.message
            });
          }
          return $scope.blockUINew.stop();
        });
      };
      $scope.delRequest = function(data) {
        $scope.blockUITable.start('Please Wait . . .');
        return $apiFactory.sendRequest({}, $scope.link.lists + '/' + data.id, 'DELETE').then(function(response) {
          if (response.data.status === 'error') {
            $scope.alertMsg({
              msg: response.data.message
            });
          } else {
            $scope.alertMsg({
              msg: response.data.message,
              success: true
            });
            $scope.loadCollections();
          }
          return $scope.blockUITable.stop();
        });
      };
      $scope.delModal = function(data) {
        var opts;
        opts = {
          title: 'Please Confirm',
          text: _h.sprintf('Do you want to delete this block (<strong>%s</strong>)?', data.title),
          html: true,
          showCancelButton: true,
          cancelButtonText: 'Cancel'
        };
        return $sweetAlertService.swal(opts, function(isConfirm) {
          if (isConfirm) {
            return $scope.delRequest(data);
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
      $scope.blockui = function(instanceName) {
        return blockUI.instances.get(instanceName);
      };
      return new AdsController();
    }
  ]);

}).call(this);

//# sourceMappingURL=ads.js.map
