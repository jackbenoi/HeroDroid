
/**
 * AppsController
 * __SHORT_DESCRIPTION__
 *
 * @class        AppsController
 * @package      APPMarket.Frontend.FrontendApp
 * @author       Anthony Pillos <me@anthonypillos.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  APPMarket.Frontend.FrontendApp.controller("AppsController", [
    '$scope', '$rootScope', '$timeout', '$filter', 'blockUI', 'ApiFactory', 'ListingService', 'SystemFactory', 'SweetAlertService', 'UploaderFactory', function($scope, $rootScope, $timeout, $filter, blockUI, $apiFactory, $listingService, $systemFactory, $sweetAlertService, $uploaderFactory) {
      var AppsController;
      AppsController = (function() {

        /**
         *
         * @return
         */
        var $onImagePreview, complete, upload, uploadSingle;

        function AppsController() {
          $scope.resources = APPMarket.Resources;
          $scope.vars = APPMarket.Vars;
          $scope.link = {
            root: $scope.resources.root,
            submitapps_list: $scope.resources.submitapps_list,
            lists: $scope.resources.index,
            app_update: $scope.resources.app_update,
            app_version_update: $scope.resources.app_version_update,
            app_search: $scope.resources.app_search,
            app_import: $scope.resources.app_import,
            app_android_detail: $scope.resources.app_android_detail,
            app_remove_upload: $scope.resources.app_remove_upload,
            app_remove_apk: $scope.resources.app_remove_apk
          };
          $scope.blockUI = $scope.blockui('blockui-effect');
          $scope.details = {};
          $scope.uploads = {};
          $scope.categories = $scope.vars.categories;
          $scope.apkFile = $scope.apkFiles = {
            app_version: '',
            signature: '',
            sha_1: '',
            description: '',
            app_link: '',
            file: {}
          };
          $scope.details = {
            image_app: {},
            screenshots: [],
            is_enabled: true,
            app_id: '',
            title: '',
            description: '',
            image_url: '',
            link: '',
            developer_link: '',
            developer_name: '',
            apk_files: [],
            versions: []
          };
          if ($scope.vars.is_create === 0) {
            $scope.getDetail();
          }
        }

        $scope.getDetail = function() {
          $scope.blockUI.start('Please Wait . . .');
          $scope.details.user_id = APPMarket.user_id;
          return $apiFactory.sendRequest({}, $scope.link.lists + '/' + $scope.vars.hash_id, 'GET').then(function(response) {
            var dataObj, screenshots;
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
              return $scope.blockUI.stop();
            } else {
              dataObj = response.data.data;
              screenshots = [];
              angular.forEach(dataObj.screenshots, function(value, key) {
                return screenshots[key] = {
                  id: value.id,
                  name: value.original_name,
                  link: value.image_link,
                  position: value.position
                };
              });
              dataObj.screenshots = screenshots;
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
                return window.location.href = $scope.link.root;
              }, 2000);
            }
          });
        };

        $scope.grabAndroidDetail = function() {
          var e;
          try {
            $systemFactory.validateObj($scope.details, ['app_id']);
            $scope.blockUI.start('Please Wait . . .');
            $scope.details.user_id = APPMarket.user_id;
            return $apiFactory.sendRequest({
              app_id: $scope.details.app_id
            }, $scope.link.app_android_detail, 'POST').then(function(response) {
              var dataObj, details, screenshots;
              if (response.data.status === 'error') {
                $scope.alertMsg({
                  msg: response.data.message
                });
                return $scope.blockUI.stop();
              } else {
                dataObj = response.data.data;
                screenshots = [];
                angular.forEach(dataObj.screenshots, function(value, key) {
                  return screenshots[key] = {
                    name: 'Screenshot From Google #' + ++key,
                    link: value,
                    position: key
                  };
                });
                details = {
                  is_enabled: true,
                  app_id: dataObj.app_id,
                  title: dataObj.title,
                  description: dataObj.description,
                  image_url: dataObj.cover_image,
                  link: dataObj.app_link,
                  developer_link: dataObj.developer.link,
                  developer_name: dataObj.developer.name,
                  screenshots: screenshots,
                  image_app: {}
                };
                if (dataObj.title) {
                  details.seo_title = dataObj.title;
                }
                if (dataObj.description) {
                  details.seo_descriptions = $filter('truncateStr')(dataObj.description, 155);
                }
                angular.extend($scope.details, details);
                return $scope.blockUI.stop();
              }
            })["catch"](function(response) {
              var msgInfo, ref;
              msgInfo = 'No results found';
              if (response.data.status === 'error') {
                msgInfo = (ref = response.data) != null ? ref.message : void 0;
              }
              $scope.alertMsg({
                msg: msgInfo
              });
              return $scope.blockUI.stop();
            });
          } catch (error) {
            e = error;
            return $scope.alertMsg({
              msg: e
            });
          }
        };

        uploadSingle = $rootScope.$on('file:uploading', function(evt, fileObj, identifier, isMultiple) {
          return $timeout(function() {
            if (identifier === 'app-image') {
              return $scope.details.image_app = fileObj;
            } else if (identifier === 'app-version') {
              if (angular.isUndefined($scope.apkFiles)) {
                $scope.apkFiles = {};
              }
              return $scope.apkFiles.file = fileObj;
            } else if (identifier === 'app-version-update') {
              if (angular.isUndefined($scope.apkFile)) {
                $scope.apkFile = {};
              }
              return $scope.apkFile.file = fileObj;
            }
          });
        });

        upload = $rootScope.$on('file:upload-in-array', function(evt, data, index) {
          return $timeout(function() {
            var files;
            files = data.file;
            if (angular.isUndefined($scope.details.screenshots)) {
              $scope.details.screenshots = [];
            }
            return angular.forEach(files, function(file, key) {
              var filereader, identifier;
              identifier = _h.randomKey(12);
              file.identifier = identifier;
              if (_.contains(["image/gif", "image/jpeg", "image/jpg", "image/png"], file.type)) {
                filereader = new FileReader();
                filereader.onload = function(e) {
                  return $rootScope.$emit('image:preview', e.target.result, identifier);
                };
                filereader.readAsDataURL(file);
                return $scope.details.screenshots.push(file);
              } else {
                return $scope.alertMsg({
                  msg: 'Upload Image only'
                });
              }
            });
          });
        });

        $onImagePreview = $rootScope.$on('image:preview', function(evt, image, identifier) {
          var uploadimage;
          uploadimage = _.findWhere($scope.details.screenshots, {
            identifier: identifier
          });
          uploadimage.preview = image;
          if (!$scope.$$phase) {
            $scope.$apply();
          }
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
            return false;
          }
          if (angular.isDefined($scope.versionBlockUI)) {
            $scope.versionBlockUI[index].stop();
          }
          if (angular.isDefined($scope.myBlockUI)) {
            $scope.myBlockUI.stop();
          }
          if (angular.isDefined($scope.blockUI)) {
            $scope.blockUI.stop();
          }
          $scope.alertMsg({
            msg: 'Successfully submitted apps, Redirecting after two(2) seconds.',
            success: true
          });
          return $timeout(function() {
            return window.location.href = $scope.link.submitapps_list;
          }, 2000);
        });

        $scope.$on('$destroy', function() {
          upload();
          uploadSingle();
          complete();
          abortData();
          return $onImagePreview();
        });

        $scope.update = function() {
          var e, sendData;
          $scope.details.hash_id = $scope.vars.hash_id;
          $scope.details.is_enabled = $scope.details.is_enabled === true ? 1 : 0;
          $scope.details.is_featured = $scope.details.is_featured === true ? 1 : 0;
          if ($scope.apkFiles.file.name || $scope.apkFiles.app_link) {
            $scope.details.apk_file_upload = $scope.apkFiles;
          }
          $scope.blockUI.start('Please Wait . . .');
          try {
            sendData = $systemFactory.objectToFormData($scope.details);
            return $uploaderFactory.upload($scope.link.app_update, sendData, []);
          } catch (error) {
            e = error;
            return $scope.alertMsg({
              msg: e
            });
          }
        };

        $scope.create = function() {
          var e, sendData;
          $scope.details.user_id = APPMarket.user_id;
          $scope.details.hash_id = $scope.vars.hash_id;
          $scope.details.is_enabled = $scope.details.is_enabled === true ? 1 : 0;
          $scope.details.is_featured = $scope.details.is_featured === true ? 1 : 0;
          if ($scope.apkFiles.file.name || $scope.apkFiles.app_link) {
            $scope.details.apk_file_upload = $scope.apkFiles;
          }
          $scope.blockUI.start('Please Wait . . .');
          try {
            $systemFactory.validateObj($scope.details, ['app_id', 'title', 'description', 'image_app', 'categories', 'user_id']);
            sendData = $systemFactory.objectToFormData($scope.details);
            return $uploaderFactory.upload($scope.link.lists, sendData, []);
          } catch (error) {
            e = error;
            $scope.alertMsg({
              msg: e
            });
            return $scope.blockUI.stop();
          }
        };

        $scope.createApkItem = function() {
          if (!$scope.apkFiles.app_link && !$scope.apkFiles.file) {
            $scope.alertMsg({
              msg: 'Apk Link URL download required or Upload your own apk file.'
            });
            return false;
          }
          return $scope.update();
        };

        $scope.updateApkItem = function(version, index) {
          var sendData;
          if ($scope.apkFile.file.name) {
            version.apk_file_upload = $scope.apkFile;
          }
          if (angular.isUndefined($scope.versionBlockUI)) {
            $scope.versionBlockUI = [];
          }
          $scope.versionBlockUI[index] = $scope.blockui('version_' + index);
          $scope.versionBlockUI[index].start('Updating APK Information. . .');
          sendData = $systemFactory.objectToFormData(version);
          return $uploaderFactory.upload($scope.link.app_version_update, sendData, $scope.versionBlockUI, index);
        };

        $scope.removeApkItem = function(version) {
          var opts;
          opts = {
            title: 'Please Confirm',
            text: _h.sprintf('Do you want to delete this apk version (<strong>%s</strong>)?', version.app_version),
            html: true,
            showCancelButton: true,
            cancelButtonText: 'Cancel'
          };
          return $sweetAlertService.swal(opts, function(isConfirm) {
            if (isConfirm) {
              if (version.id) {
                return $scope.deleteFile($scope.link.app_remove_apk + '/' + version.id);
              }
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

        $scope.blockui = function(instanceName) {
          return blockUI.instances.get(instanceName);
        };

        return AppsController;

      })();
      return new AppsController();
    }
  ]);

}).call(this);

//# sourceMappingURL=apps.js.map
