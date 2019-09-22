
/**
 * AppsController
 * __SHORT_DESCRIPTION__
 *
 * @class        AppsController
 * @package      APPMarket.Backend.BackendApp
 * @author       Anthony Pillos <me@anthonypillos.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  APPMarket.Backend.BackendApp.controller("AppsController", [
    '$scope', '$rootScope', '$timeout', 'blockUI', 'ApiFactory', 'ListingService', 'SystemFactory', 'SweetAlertService', 'UploaderFactory', function($scope, $rootScope, $timeout, blockUI, $apiFactory, $listingService, $systemFactory, $sweetAlertService, $uploaderFactory) {
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
          } else if ($scope.vars.is_google_play === 1) {
            $scope.categories = $scope.vars.categories;
            $scope.appLists = [];
            $scope.details = {
              search: '',
              letter: ''
            };
          } else {
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
              versions: [],
              custom: []
            };
            $scope.tempInputOptions = {
              identifier: 'text',
              key: '',
              value: ''
            };
            $scope.inputTypes = ['text', 'textarea'];
            if ($scope.vars.is_create === 0) {
              $scope.getDetail();
            }
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
          var letter, perpage, routes, search;
          pageNum = pageNum || 1;
          $scope.blockUI.start('Please Wait . . .');
          _h.set($scope.pagePresetKey, pageNum);
          $scope.details.per_page = angular.isUndefined($scope.details.per_page) ? $scope.per_page : $scope.details.per_page;
          $scope.details.search = angular.isUndefined($scope.details.search) ? '' : $scope.details.search;
          search = '&search=' + $scope.details.search;
          perpage = '&per_page=' + $scope.details.per_page;
          letter = '&letter=' + $scope.details.letter;
          routes = $scope.link.lists + '?page=' + pageNum + search + letter + perpage;
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
              window.location.href = $scope.link.root;
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

        $scope.grabDetailAndSave = function(appId) {
          $scope.blockUI.start('Please Wait . . .');
          $scope.details.user_id = APPMarket.user_id;
          return $apiFactory.sendRequest({
            app_id: appId,
            is_save: true
          }, $scope.link.app_android_detail, 'POST').then(function(response) {
            var dataObj;
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
              return $scope.blockUI.stop();
            } else {
              dataObj = response.data.data;
              console.log(dataObj);
              return $scope.blockUI.stop();
            }
          });
        };

        $scope.addCustomOptions = function() {
          var temp;
          console.log('$scope.details.custom', $scope.details.custom);
          console.log('_.size($scope.tempInputOptions)', _.size($scope.tempInputOptions));
          if (_.size($scope.tempInputOptions) > 0) {
            temp = {
              identifier: 'text',
              key: '',
              value: ''
            };
            return $scope.details.custom.push(temp);
          }
        };

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
              if ($scope.details.custom === '') {
                $scope.details.custom = [];
              }
              $scope.details.custom = JSON.parse($scope.details.custom);
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
                reviews: dataObj.reviews,
                ratings: dataObj.rate_score,
                ratings_total: dataObj.ratings_total,
                published_date: dataObj.published_date,
                rating_histogram: dataObj.rating_histogram,
                installs: dataObj.installs,
                required_android: dataObj.required_android,
                image_app: {}
              };
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
          console.log(resp);
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
          if (angular.isDefined(resp.data.backend_detail_url)) {
            return window.location.href = resp.data.backend_detail_url;
          }
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
            sendData = $systemFactory.objectToFormData($scope.details);
            return $uploaderFactory.upload($scope.link.lists, sendData, []);
          } catch (error) {
            e = error;
            return $scope.alertMsg({
              msg: e
            });
          }
        };

        $scope.searchFromGooglePlay = function() {
          $scope.blockSearchUI.start('Please Wait . . .');
          $scope.isSearching = true;
          return $apiFactory.sendRequest($scope.details, $scope.link.app_search, 'POST').then(function(response) {
            var result;
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
            } else {
              result = response.data.data;
              $scope.appLists = result;
              $scope.paginate = result.paginate;
            }
            $scope.isSearching = false;
            return $scope.blockSearchUI.stop();
          });
        };

        $scope.importApp = function(item) {
          var catIds, k;
          if ($scope.categoryObj.list.length < 1) {
            $scope.alertMsg({
              msg: 'Please select atleast one category where to import your apps / games.'
            });
            return false;
          }
          $scope.blockSearchUI.start('Please Wait . . .');
          catIds = [];
          k = 0;
          while (k < $scope.categoryObj.list.length) {
            catIds[k] = $scope.categoryObj.list[k].id;
            k++;
          }
          item.user_id = APPMarket.user_id;
          return $apiFactory.sendRequest({
            data: item,
            categories: catIds
          }, $scope.link.app_import, 'POST').then(function(response) {
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: response.data.message
              });
            } else {
              $scope.alertMsg({
                msg: response.data.message,
                success: true
              });
            }
            return $scope.blockSearchUI.stop();
          }, function(response) {
            if (response.data.status === 'error') {
              $scope.alertMsg({
                msg: res.data.message
              });
              return $scope.blockSearchUI.stop();
            }
          });
        };

        $scope.searchBulkAction = function() {
          var appIds, catIds, i, k, obj, opts;
          if ($scope.categoryObj.list.length < 1) {
            $scope.alertMsg({
              msg: 'Please select atleast one category where to import your apps / games.'
            });
            return false;
          }
          appIds = [];
          i = 0;
          while (i < $scope.appLists.length) {
            if ($scope.appLists[i].is_checked === true) {
              obj = $scope.appLists[i];
              obj.user_id = APPMarket.user_id;
              appIds[i] = obj;
            }
            i++;
          }
          catIds = [];
          k = 0;
          while (k < $scope.categoryObj.list.length) {
            catIds[k] = $scope.categoryObj.list[k].id;
            k++;
          }
          opts = {
            title: 'Please Confirm',
            text: 'Do you want to import all app/games selected?',
            html: true,
            showCancelButton: true,
            cancelButtonText: 'Cancel'
          };
          return $sweetAlertService.swal(opts, function(isConfirm) {
            if (isConfirm) {
              $scope.blockSearchUI.start('Please Wait . . .');
              return $apiFactory.sendRequest({
                data: appIds,
                categories: catIds,
                is_bulk: true
              }, $scope.link.app_import, 'POST').then(function(response) {
                if (response.data.status === 'error') {
                  $scope.alertMsg({
                    msg: response.data.message
                  });
                } else {
                  $scope.alertMsg({
                    msg: response.data.message,
                    success: true
                  });
                  $scope.appLists = [];
                }
                return $scope.blockSearchUI.stop();
              }, function(response) {
                if (response.data.status === 'error') {
                  $scope.alertMsg({
                    msg: res.data.message
                  });
                  return $scope.blockSearchUI.stop();
                }
              });
            }
          });
        };

        $scope.searchSelectAll = function() {
          var i, results;
          i = 0;
          results = [];
          while (i < $scope.appLists.length) {
            $scope.appLists[i].is_checked = $scope.details.allItemsSelected;
            results.push(i++);
          }
          return results;
        };

        $scope.searchSelectedItem = function() {
          var i;
          i = 0;
          while (i < $scope.appLists.length) {
            if ($scope.appLists[i].is_checked === false) {
              $scope.details.allItemsSelected = false;
            }
            i++;
          }
          return $scope.details.allItemsSelected = true;
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

        return AppsController;

      })();
      return new AppsController();
    }
  ]);

}).call(this);

//# sourceMappingURL=apps.js.map
