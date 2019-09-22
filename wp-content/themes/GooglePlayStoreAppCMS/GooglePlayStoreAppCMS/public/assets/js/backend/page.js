
/**
 * PageController
 * __SHORT_DESCRIPTION__
 *
 * @class        PageController
 * @package      APPMarket.Backend.BackendApp
 * @author       Anthony Pillos <me@anthonypillos.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  APPMarket.Backend.BackendApp.controller("PageController", [
    '$scope', '$timeout', 'blockUI', 'ApiFactory', 'ListingService', 'SystemFactory', 'SweetAlertService', function($scope, $timeout, blockUI, $apiFactory, $listingService, $systemFactory, $sweetAlertService) {
      var PageController;
      PageController = (function() {

        /**
         *
         * @return
         */
        function PageController() {
          $scope.resources = APPMarket.Resources;
          $scope.vars = APPMarket.Vars;
          $scope.link = {
            root: $scope.resources.root,
            lists: $scope.resources.index,
            bulk_deletion: $scope.resources.bulk_deletion
          };
          $scope.blockUI = $scope.blockui('blockui-effect');
          $scope.details = {};
          $scope.per_page = 20;
          $scope.parent_page_lists = $scope.vars.page_lists;
          $scope.status_lists = $scope.vars.status_lists;
          $scope.details.parent_page = _.findWhere($scope.vars.page_lists, {
            id: 0
          });
          if ($scope.vars.hash_id === 0 && $scope.vars.is_create === 0) {
            $scope.pagePresetKey = 'APPMarket-page';
            $scope = angular.extend($scope, $listingService, {
              getCollections: function(pageNum) {
                return $scope.getOrderLists(pageNum);
              }
            });
            $scope.loadCollections();
            $scope.details.allItemsSelected = false;
            $scope.dd_actions = {};
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
            $systemFactory.validateObj($scope.details, ['title', 'content', 'user_id']);
            $scope.details.is_draft = angular.isDefined(isDraft) ? isDraft : 0;
            $scope.details.is_enabled = $scope.details.is_enabled === true ? 1 : 0;
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

        return PageController;

      })();
      $scope.update = function(isDraft) {
        var e;
        try {
          $scope.details.user_id = APPMarket.user_id;
          $systemFactory.validateObj($scope.details, ['title', 'slug', 'content', 'user_id']);
          $scope.details.is_draft = angular.isDefined(isDraft) ? isDraft : 0;
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
      $scope.search = function() {
        return $scope.loadCollections();
      };
      $scope.clearAll = function() {
        $scope.details = {
          search: '',
          letter: '',
          per_page: 20
        };
        return $scope.loadCollections();
      };
      $scope._slug = function(str) {
        return str.toString().toLowerCase().replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, '');
      };
      $scope.perPageChange = function() {
        return $scope.loadCollections();
      };
      $scope.statusChange = function() {
        return $scope.isEdit = false;
      };
      $scope.blockui = function(instanceName) {
        return blockUI.instances.get(instanceName);
      };
      return new PageController();
    }
  ]);

}).call(this);

//# sourceMappingURL=page.js.map
