
/**
 * CategoryController
 * __SHORT_DESCRIPTION__
 *
 * @class        CategoryController
 * @package      APPMarket.Backend.BackendApp
 * @author       Anthony Pillos <me@anthonypillos.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  APPMarket.Backend.BackendApp.controller("CategoryController", [
    '$scope', '$timeout', 'blockUI', 'ApiFactory', 'ListingService', 'SystemFactory', 'SweetAlertService', function($scope, $timeout, blockUI, $apiFactory, $listingService, $systemFactory, $sweetAlertService) {
      var CategoryController;
      CategoryController = (function() {

        /**
         *
         * @return
         */
        function CategoryController() {
          $scope.resources = APPMarket.Resources;
          $scope.vars = APPMarket.Vars;
          $scope.link = {
            root: $scope.resources.root,
            subCatRoot: $scope.resources.subCatRoot,
            lists: $scope.resources.subindex,
            bulk_deletion: $scope.resources.bulk_deletion
          };
          $scope.blockUI = $scope.blockui('blockui-effect');
          $scope.details = {};
          $scope.per_page = 20;
          $scope.letters = $scope.vars.alpha;
          $scope.details.parent_category_id = $scope.vars.parentCatId;
          if ($scope.vars.hash_id === 0 && $scope.vars.is_create === 0) {
            $scope.pagePresetKey = 'appmarket-parent-category-page';
            $scope = angular.extend($scope, $listingService, {
              getCollections: function(pageNum) {
                return $scope.getOrderLists(pageNum);
              }
            });
            $scope.loadCollections();
          } else {
            $scope.details.is_enabled = true;
            if ($scope.vars.is_create === 0) {
              $scope.getDetail();
            }
          }
        }

        $scope.getDetail = function() {
          $scope.blockUI.start('Please Wait . . .');
          $scope.details.user_id = APPMarket.user_id;
          return $apiFactory.sendRequest({}, $scope.link.lists + '/' + $scope.vars.hash_id + '?parent_category_id=' + $scope.vars.parentCatId, 'GET').then(function(response) {
            var dataObj;
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
              return $scope.blockUI.stop();
            } else {
              dataObj = response.data.data;
              $scope.details = dataObj;
              $scope.details.is_enabled = $scope.details.is_enabled === 1 ? true : false;
              $scope.details.is_featured = $scope.details.is_featured === 1 ? true : false;
              return $scope.blockUI.stop();
            }
          })["catch"](function(response) {
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: 'No query results found, You will be redirected back in 2 seconds...'
              });
              return $timeout(function() {
                return window.location.href = $scope.link.subCatRoot + '/' + $scope.vars.parentCatId;
              }, 2000);
            }
          });
        };

        $scope.create = function(isDraft) {
          var e;
          try {
            $scope.details.user_id = APPMarket.user_id;
            $systemFactory.validateObj($scope.details, ['title', 'description', 'user_id']);
            $scope.details.is_enabled = $scope.details.is_enabled === true ? 1 : 0;
            $scope.blockUI.start('Please Wait . . .');
            return $apiFactory.sendRequest($scope.details, $scope.link.lists + '?parent_category_id=' + $scope.vars.parentCatId, 'POST').then(function(response) {
              var dataObj;
              if (response.data.status === 'error') {
                $scope.alertMsg({
                  msg: response.data.message
                });
                return $scope.blockUI.stop();
              } else {
                dataObj = response.data;
                window.location.href = dataObj.data.backend_detail_url;
                return $scope.blockUI.stop();
              }
            });
          } catch (error) {
            e = error;
            return $scope.alertMsg({
              msg: e
            });
          }
        };

        return CategoryController;

      })();
      $scope.update = function(isDraft) {
        var e;
        try {
          $scope.details.user_id = APPMarket.user_id;
          $systemFactory.validateObj($scope.details, ['title', 'identifier', 'description', 'user_id']);
          $scope.details.is_draft = angular.isDefined(isDraft) ? isDraft : 0;
          $scope.details.is_enabled = $scope.details.is_enabled === true ? 1 : 0;
          $scope.details.is_featured = $scope.details.is_featured === true ? 1 : 0;
          $scope.blockUI.start('Please Wait . . .');
          return $apiFactory.sendRequest($scope.details, $scope.link.lists + '/' + $scope.vars.hash_id + '?parent_category_id=' + $scope.vars.parentCatId, 'PUT').then(function(response) {
            var dataObj;
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
              return $scope.blockUI.stop();
            } else {
              dataObj = response.data;
              window.location.reload();
              return $scope.blockUI.stop();
            }
          });
        } catch (error) {
          e = error;
          return $scope.alertMsg({
            msg: e
          });
        }
      };
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
        var parent_cat_id, perpage, routes, search;
        pageNum = pageNum || 1;
        $scope.blockUI.start('Please Wait . . .');
        _h.set($scope.pagePresetKey, pageNum);
        $scope.details.per_page = angular.isUndefined($scope.details.per_page) ? $scope.per_page : $scope.details.per_page;
        $scope.details.search = angular.isUndefined($scope.details.search) ? '' : $scope.details.search;
        search = '&search=' + $scope.details.search;
        perpage = '&per_page=' + $scope.details.per_page;
        parent_cat_id = '&parent_category_id=' + $scope.details.parent_category_id;
        routes = $scope.link.lists + '?page=' + pageNum + search + perpage + parent_cat_id;
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
      $scope.delRequest = function(data) {
        $scope.blockUI.start('Please Wait . . .');
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
            window.location.href = $scope.link.subCatRoot + '/' + $scope.vars.parentCatId;
          }
          return $scope.blockUI.stop();
        });
      };
      $scope.delModal = function(data) {
        var opts;
        opts = {
          title: 'Please Confirm',
          text: _h.sprintf('Do you want to delete this page (<strong>%s</strong>)?', data.title),
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
      return new CategoryController();
    }
  ]);

}).call(this);


/**
 * ParentCategoryController
 * __SHORT_DESCRIPTION__
 *
 * @class        ParentCategoryController
 * @package      APPMarket.Backend.BackendApp
 * @author       Anthony Pillos <me@anthonypillos.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  APPMarket.Backend.BackendApp.controller("ParentCategoryController", [
    '$scope', '$timeout', 'blockUI', 'ApiFactory', 'ListingService', 'SystemFactory', 'SweetAlertService', function($scope, $timeout, blockUI, $apiFactory, $listingService, $systemFactory, $sweetAlertService) {
      var ParentCategoryController;
      ParentCategoryController = (function() {

        /**
         *
         * @return
         */
        function ParentCategoryController() {
          $scope.resources = APPMarket.Resources;
          $scope.vars = APPMarket.Vars;
          $scope.link = {
            root: $scope.resources.root,
            lists: $scope.resources.index
          };
          $scope.blockUI = $scope.blockui('blockui-effect');
          $scope.details = {};
          $scope.per_page = 20;
          $scope.letters = $scope.vars.alpha;
          if ($scope.vars.hash_id === 0 && $scope.vars.is_create === 0) {
            $scope.pagePresetKey = 'appmarket-parent-category-page';
            $scope = angular.extend($scope, $listingService, {
              getCollections: function(pageNum) {
                return $scope.getOrderLists(pageNum);
              }
            });
            $scope.loadCollections();
          } else {
            $scope.details.is_enabled = true;
            if ($scope.vars.is_create === 0) {
              $scope.getDetail();
            }
          }
        }

        $scope.getDetail = function() {
          $scope.blockUI.start('Please Wait . . .');
          $scope.details.user_id = APPMarket.user_id;
          return $apiFactory.sendRequest({}, $scope.link.lists + '/' + $scope.vars.hash_id, 'GET').then(function(response) {
            var dataObj;
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
              return $scope.blockUI.stop();
            } else {
              dataObj = response.data.data;
              $scope.details = dataObj;
              $scope.details.is_enabled = $scope.details.is_enabled === 1 ? true : false;
              return $scope.blockUI.stop();
            }
          })["catch"](function(response) {
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: 'No query results found, You will be redirected back in 2 seconds...'
              });
              return $timeout(function() {
                return window.location.href = $scope.link.root;
              }, 2000);
            }
          });
        };

        $scope.create = function(isDraft) {
          var e;
          try {
            $scope.details.user_id = APPMarket.user_id;
            $systemFactory.validateObj($scope.details, ['title', 'description', 'user_id']);
            $scope.details.is_enabled = $scope.details.is_enabled === true || $scope.details.is_enabled === 1 ? 1 : 0;
            $scope.blockUI.start('Please Wait . . .');
            return $apiFactory.sendRequest($scope.details, $scope.link.lists, 'POST').then(function(response) {
              var dataObj;
              if (response.data.status === 'error') {
                $scope.alertMsg({
                  msg: response.data.message
                });
                return $scope.blockUI.stop();
              } else {
                dataObj = response.data;
                window.location.href = dataObj.data.backend_detail_url;
                return $scope.blockUI.stop();
              }
            });
          } catch (error) {
            e = error;
            return $scope.alertMsg({
              msg: e
            });
          }
        };

        return ParentCategoryController;

      })();
      $scope.update = function() {
        var e;
        try {
          $scope.details.user_id = APPMarket.user_id;
          $systemFactory.validateObj($scope.details, ['title', 'description', 'user_id']);
          $scope.details.is_enabled = $scope.details.is_enabled === true ? 1 : 0;
          $scope.blockUI.start('Please Wait . . .');
          return $apiFactory.sendRequest($scope.details, $scope.link.lists + '/' + $scope.vars.hash_id, 'PUT').then(function(response) {
            var dataObj;
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
              return $scope.blockUI.stop();
            } else {
              dataObj = response.data;
              window.location.reload();
              return $scope.blockUI.stop();
            }
          });
        } catch (error) {
          e = error;
          return $scope.alertMsg({
            msg: e
          });
        }
      };
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
        var perpage, routes, search;
        pageNum = pageNum || 1;
        $scope.blockUI.start('Please Wait . . .');
        _h.set($scope.pagePresetKey, pageNum);
        $scope.details.per_page = angular.isUndefined($scope.details.per_page) ? $scope.per_page : $scope.details.per_page;
        $scope.details.search = angular.isUndefined($scope.details.search) ? '' : $scope.details.search;
        search = '&search=' + $scope.details.search;
        perpage = '&per_page=' + $scope.details.per_page;
        routes = $scope.link.lists + '?page=' + pageNum + search + perpage;
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
      $scope.delRequest = function(data) {
        $scope.blockUI.start('Please Wait . . .');
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
            window.location.href = $scope.link.root;
          }
          return $scope.blockUI.stop();
        });
      };
      $scope.delModal = function(data) {
        var opts;
        opts = {
          title: 'Please Confirm',
          text: _h.sprintf('Do you want to delete this page (<strong>%s</strong>)?', data.title),
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
      return new ParentCategoryController();
    }
  ]);

}).call(this);

//# sourceMappingURL=category.js.map
