
/**
 * GeneralController
 * __SHORT_DESCRIPTION__
 *
 * @class        GeneralController
 * @package      APPMarket.Backend.BackendApp
 * @author       Anthony Pillos <me@anthonypillos.com>
 * @copyright    Copyright (c) 2017 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  APPMarket.Backend.BackendApp.controller("GeneralController", [
    '$scope', '$timeout', '$rootScope', 'ApiFactory', 'ListingService', 'SystemFactory', 'blockUI', 'SweetAlertService', 'UploaderFactory', function($scope, $timeout, $rootScope, $apiFactory, $listingService, $systemFactory, blockUI, $sweetAlertService, $uploaderFactory) {
      var GeneralController;
      GeneralController = (function() {

        /**
         *
         * @return
         */
        var complete, uploadSingle;

        function GeneralController() {
          $scope.resources = APPMarket.Resources;
          $scope.vars = APPMarket.Vars;
          $scope.link = {
            lists: $scope.resources.index,
            validateApi: $scope.resources.validateApi,
            uploadLogo: $scope.resources.uploadLogo
          };
          $scope.blockUI = $scope.blockui('blockui-effect');
          $scope.details = [];
          $scope.upload = {};
          $scope.lists();
        }

        uploadSingle = $rootScope.$on('file:uploading', function(evt, fileObj, identifier, isMultiple) {
          return $timeout(function() {
            if (identifier === 'app-image') {
              return $scope.upload.file = fileObj;
            }
          });
        });

        complete = $rootScope.$on('upload:complete', function(evt, data, index) {
          var resp;
          resp = JSON.parse($uploaderFactory.dataObj[index].xhr.response);
          if (resp.status === 'error') {
            $scope.alertMsg({
              msg: resp.message
            });
            if (angular.isDefined($scope.blockUI)) {
              $scope.blockUI.stop();
            }
            return true;
          }
          $scope.alertMsg({
            msg: resp.message,
            success: true
          });
          return window.location.reload();
        });

        $scope.uploadImage = function($image_key) {
          var sendData;
          if (angular.isUndefined($scope.upload.image_key)) {
            $scope.upload.image_key = {};
          }
          $scope.upload.image_key = $image_key;
          sendData = $systemFactory.objectToFormData($scope.upload);
          return $uploaderFactory.upload($scope.link.uploadLogo, sendData, []);
        };

        $scope.deleteImage = function(detail) {
          $scope.blockUI.start('Please Wait . . .');
          return $apiFactory.sendRequest(detail, $scope.link.uploadLogo, 'POST').then(function(response) {
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
              return $scope.blockUI.stop();
            } else {
              window.location.reload();
              return $scope.blockUI.stop();
            }
          });
        };

        $scope.lists = function() {
          $scope.blockUI.start('Please Wait . . .');
          return $apiFactory.sendRequest({}, $scope.link.lists, 'GET').then(function(response) {
            var dataObj;
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
              return $scope.blockUI.stop();
            } else {
              dataObj = response.data.data;
              $scope.details = dataObj;
              return $scope.blockUI.stop();
            }
          });
        };

        $scope.update = function(details) {
          var obj;
          obj = {};
          angular.forEach(details, function(input) {
            return _.each(input.lists, function(item) {
              return obj[item.key] = item.value;
            });
          });
          $scope.blockUI.start('Please Wait . . .');
          return $apiFactory.sendRequest(obj, $scope.link.lists + '/saving', 'PUT').then(function(response) {
            var dataObj;
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
              $scope.blockUI.stop();
            } else {
              dataObj = response.data.data;
              $scope.alertMsg({
                msg: response.data.message,
                success: true
              });
            }
            return $scope.blockUI.stop();
          });
        };

        $scope.validatePurchaseCode = function() {
          var apiLists, buyerUsername, obj, puchaseCode;
          apiLists = $scope.details.apk_download_via_api.lists;
          puchaseCode = '';
          buyerUsername = '';
          _.each(apiLists, function(data) {
            if (data.key === 'purchase_code') {
              puchaseCode = data['value'];
            }
            if (data.key === 'buyer_username') {
              return buyerUsername = data['value'];
            }
          });
          if (puchaseCode && buyerUsername) {
            obj = {
              purchase_code: puchaseCode,
              buyer_username: buyerUsername
            };
            $scope.blockUI.start('Please Wait . . .');
            return $apiFactory.sendRequest(obj, $scope.link.validateApi, 'POST').then(function(response) {
              var dataObj;
              if (response.data.status === 'error') {
                $scope.alertMsg({
                  msg: response.data.message
                });
                $scope.blockUI.stop();
              } else {
                dataObj = response.data.data;
                _.each(apiLists, function(data) {
                  if (data.key === 'download_api_url') {
                    data['value'] = dataObj.api;
                  }
                });
                $scope.details.apk_download_via_api.lists = apiLists;
                $scope.alertMsg({
                  msg: response.data.message,
                  success: true
                });
              }
              return $scope.blockUI.stop();
            });
          } else {
            return $scope.alertMsg({
              msg: "No purchase code and buyer username found"
            });
          }
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

        return GeneralController;

      })();
      return new GeneralController();
    }
  ]);

}).call(this);

//# sourceMappingURL=general.js.map
