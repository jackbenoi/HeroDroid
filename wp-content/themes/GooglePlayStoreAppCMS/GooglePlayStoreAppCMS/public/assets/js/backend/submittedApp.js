
/**
 * SubmittedAppController
 * __SHORT_DESCRIPTION__
 *
 * @class        SubmittedAppController
 * @package      APPMarket.Backend.BackendApp
 * @author       Anthony Pillos <me@anthonypillos.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  APPMarket.Backend.BackendApp.controller("SubmittedAppController", [
    '$scope', '$rootScope', '$timeout', 'blockUI', 'ApiFactory', 'ListingService', 'SystemFactory', 'SweetAlertService', 'UploaderFactory', function($scope, $rootScope, $timeout, blockUI, $apiFactory, $listingService, $systemFactory, $sweetAlertService, $uploaderFactory) {
      var SubmittedAppController;
      SubmittedAppController = (function() {

        /**
         *
         * @return
         */
        function SubmittedAppController() {
          $scope.resources = APPMarket.Resources;
          $scope.vars = APPMarket.Vars;
          $scope.link = {
            root: $scope.resources.root,
            lists: $scope.resources.index
          };
          $scope.blockUI = $scope.blockui('blockui-effect');
          $scope.blockSearchUI = $scope.blockui('search-result');
          $scope.details = {};
          $scope.per_page = 50;
          $scope.letters = $scope.vars.alpha;
          $scope.categoryObj = {
            list: []
          };
          if ($scope.vars.hash_id === 0 && $scope.vars.is_create === 0) {
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
          } else {

          }
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
          var letter, perpage, routes, search, submittedAppType;
          pageNum = pageNum || 1;
          $scope.blockUI.start('Please Wait . . .');
          _h.set($scope.pagePresetKey, pageNum);
          $scope.details.per_page = angular.isUndefined($scope.details.per_page) ? $scope.per_page : $scope.details.per_page;
          $scope.details.search = angular.isUndefined($scope.details.search) ? '' : $scope.details.search;
          search = '&search=' + $scope.details.search;
          perpage = '&per_page=' + $scope.details.per_page;
          letter = '&letter=' + $scope.details.letter;
          submittedAppType = '&is_submitted=yes';
          routes = $scope.link.lists + '?page=' + pageNum + search + letter + perpage + submittedAppType;
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

        $scope.delRequest = function(data, type) {
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
              window.location.reload();
            }
            return $scope.blockUI.stop();
          });
        };

        $scope.delModal = function(data, type) {
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
              return $scope.delRequest(data, type);
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

        $scope.removeItem = function(file, index) {
          if (angular.isDefined(index)) {
            if (index === 'apk-update') {
              return $scope.apkFile.file = {};
            }
          } else {
            if (file.id) {
              $scope.deleteFile($scope.link.app_remove_upload + '/' + file.id);
            }
            if (file.upload_type === 'app-image') {
              $scope.details.app_image = '';
            }
            index = $scope.details.screenshots.indexOf(file);
            return $scope.details.screenshots.splice(index, 1);
          }
        };

        $scope.deleteFile = function(url) {
          return $apiFactory.sendRequest({}, url, "POST").then(function(response) {
            return window.location.reload();
          }, function(response) {
            alert(response.data.message);
            return $scope.myBlockUI.stop();
          });
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

        $scope._slug = function(str) {
          return str.toString().toLowerCase().replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, '');
        };

        $scope.perPageChange = function(page) {
          $scope.details.per_page = page;
          return $scope.loadCollections();
        };

        $scope.statusChange = function() {
          return $scope.isEdit = false;
        };

        $scope.letterFilter = function(letter) {
          $scope.details.letter = letter;
          return $scope.loadCollections();
        };

        $scope.blockui = function(instanceName) {
          return blockUI.instances.get(instanceName);
        };

        return SubmittedAppController;

      })();
      return new SubmittedAppController();
    }
  ]);

}).call(this);

//# sourceMappingURL=submittedApp.js.map
