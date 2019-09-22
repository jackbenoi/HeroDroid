
/**
 * Provide Drag and Drop Capability using this file-uploader directive
 *
 *
 * @class fileUploader Directives
 * @package AngularModules
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  angular.module('AddThisDirective', []).directive('addthisShare', function() {
    return {
      restrict: 'E',
      replace: true,
      template: "<div class=\"addthis_sharing_toolbox addthis_default_style addthis_32x32_style\">\n  <div id=\"atstbx\" class=\"at-resp-share-element at-style-responsive addthis-smartlayers addthis-animated at4-show\">\n    <fb></fb>\n    <twit></twit>\n    <googleplus></googleplus>\n    <email></email>\n    <more></more>\n    </div>\n</div>",
      link: function(scope, elem, attrs) {
        addthis.init();
        return addthis.toolbox(elem.get());
      }
    };
  }).directive('fb', function() {
    return {
      restrict: 'E',
      replace: true,
      template: '<a href class="addthis_button_facebook at-icon-wrapper at-share-btn" style="background-color: rgb(59, 89, 152); border-radius: 2px;"></a>'
    };
  }).directive('twit', function() {
    return {
      restrict: 'E',
      replace: true,
      template: '<a class="addthis_button_twitter at-icon-wrapper at-share-btn" style="background-color: rgb(29, 161, 242); border-radius: 2px;"></a>'
    };
  }).directive('googleplus', function() {
    return {
      restrict: 'E',
      replace: true,
      template: '<a class="addthis_button_google_plusone_share at-icon-wrapper at-share-btn" style="background-color: rgb(220, 78, 65); border-radius: 2px;"></a>'
    };
  }).directive('email', function() {
    return {
      restrict: 'E',
      replace: true,
      template: '<a class="addthis_button_email at-icon-wrapper at-share-btn" style="background-color: rgb(132, 132, 132); border-radius: 2px;"></a>'
    };
  }).directive('more', function() {
    return {
      restrict: 'E',
      replace: true,
      template: '<a class="addthis_button_compact at-icon-wrapper at-share-btn" style="background-color: rgb(255, 101, 80); border-radius: 2px;"></a>'
    };
  });

}).call(this);


/**
 * Api Factory
 *
 * @class        ApiFactory
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  angular.module('ApiFactory', []).factory("ApiFactory", [
    '$http', '$rootScope', '$q', function($http, $rootScope, $q) {
      return {
        sendRequest: function(DATA, URL, METHOD, Q_DEFER, isAJAX) {
          var httpDataRequest;
          if (!_h.isUndefined(METHOD)) {
            METHOD = 'POST';
          }
          this.$$additionalHTTPHeader();
          httpDataRequest = {
            method: METHOD,
            url: URL,
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            data: $.param(DATA)
          };
          if (Q_DEFER) {
            return this.$$qDeferRequest(httpDataRequest, Q_DEFER);
          }
          if (METHOD === 'GET') {
            return $http.get(URL);
          }
          return $http(httpDataRequest);
        },

        /*
         *   X-CSRF-Token   = Site X-CSRF-Token Token
         *   X-Requested-With = Set Http Request to AJAX FORMAT
         */
        $$additionalHTTPHeader: function() {
          $http.defaults.headers.common['X-CSRF-Token'] = angular.element("meta[name='_token']").attr('content');
          $http.defaults.headers.common['X-Requested-With'] = "XMLHttpRequest";
        },
        $$qDeferRequest: function(httpDataRequest, Q_DEFER) {
          var promise;
          if (angular.isUndefined(this.qRequest)) {
            this.qRequest = [];
          }
          this.qRequest.push(Q_DEFER);
          promise = $http(angular.extend(httpDataRequest, {
            timeout: Q_DEFER.promise
          }));
          promise["finally"]((function() {
            this.qRequest = _.filter(this.qRequest, function(request) {
              return request.url !== httpDataRequest.url;
            });
          }));
          return promise;
        },
        cancelRequest: function() {
          angular.forEach(this.qRequest, function(canceller) {
            canceller.resolve();
          });
          if (angular.isUndefined(this.qRequest)) {
            return this.qRequest = [];
          }
        }
      };
    }
  ]);

}).call(this);


/**
 * Provide Drag and Drop Capability using this file-uploader directive
 *
 * Inside of your controller you can listen to this events( $scope.$on('listener_name') )
 * - file:unknown
 * - file:uploading
 *
 * Example:
 *   * For Single Upload with identifier
 *   * Note: identifier is just a name, for your upload
 *        in case you have 2 different uploads,
 *        identifier serve as your unique name for each upload.
 *        if you omit the identifier, it will show "fileupload" as default name
 *
 *       <div file-uploader is-multiple="false" identifier="front"></div>
 *
 *   * For Upload with inside array
 *   * Make sure you pass, the whole object from my-file and the $index, so you have control in your controller
 *        <div ng-repeat="file in uploadFiles track by $index">
 *            <div file-uploader my-file="file" index="$index"></div>
 *        </div>
 *
 *
 * @class fileUploader Directives
 * @package AngularModules
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  angular.module('FileUploaderDirective', []).directive("fileUploader", [
    '$rootScope', function($rootScope) {
      return {
        restrict: "A",
        scope: {
          imagePreview: '=',
          isMultiple: '=',
          myFile: '=',
          index: '='
        },
        link: function(scope, element, attrs) {
          var _fileReader, loadFile, onDragEnd, onDragOver;
          onDragOver = function(e) {
            e.preventDefault();
            element.addClass("dragOver");
          };
          onDragEnd = function(e) {
            e.preventDefault();
            element.removeClass("dragOver");
          };
          loadFile = function(fileObj) {
            var fileObjectData, isMultiple, multipleUpload;
            isMultiple = false;
            if (!fileObj) {
              throw 'File Unknown';
            }
            if (scope.isMultiple) {
              isMultiple = true;
              multipleUpload = [];
              angular.forEach(fileObj, function(file, key) {
                file.isMultiple = 1;
                return multipleUpload.push(file);
              });
              fileObjectData = multipleUpload;
            } else {
              fileObjectData = fileObj[0];
            }
            fileObjectData.status = 0;
            if (angular.isUndefined(attrs.identifier)) {
              attrs.identifier = "fileupload";
            }
            if (angular.isUndefined(scope.myFile) && angular.isUndefined(scope.index)) {
              return $rootScope.$emit('file:uploading', fileObjectData, attrs.identifier, isMultiple);
            }
            scope.myFile.file = fileObjectData;
            return $rootScope.$emit('file:upload-in-array', scope.myFile, scope.index);
          };
          _fileReader = function(file) {
            var reader;
            if (window.File && window.FileReader && window.FileList && window.Blob) {
              reader = new FileReader;
              reader.onload = function(evt) {
                return file.image_url = reader.result;
              };
              return reader.readAsDataURL(file);
            } else {
              return file.image_url = '#';
            }
          };
          element.bind('change', function(e) {
            loadFile(e.originalEvent.target.files);
            if (e != null) {
              e.preventDefault();
            }
            if (e != null) {
              e.stopPropagation();
            }
          });
          element.bind("dragover", onDragOver).bind("dragleave", onDragEnd).bind("drop", function(e) {
            onDragEnd(e);
            loadFile(e.originalEvent.dataTransfer.files);
            if (e != null) {
              e.preventDefault();
            }
            if (e != null) {
              e.stopPropagation();
            }
          });
        }
      };
    }
  ]);

}).call(this);


/**
 * Key Bind
 *
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 *
 * Ex. 
 * esc : 'clear()' instead of esc : clear()
 * <input key-bind="{ enter: 'go()', esc: 'clear()' }" type="text"
 *
 */

(function() {
  angular.module('htmlBindDirective', []).directive('htmlBind', [
    '$compile', function($compile) {
      return {
        restrict: 'A',
        replace: true,
        scope: {
          dynamic: '=htmlBind'
        },
        link: function(scope, element, attrs) {
          scope.$watch('attrs.htmlBind', function(html) {
            element.html(scope.dynamic);
            $compile(element.contents())(scope);
          });
        }
      };
    }
  ]);

}).call(this);


/**
 * Key Bind
 *
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 *
 * Ex. 
 * esc : 'clear()' instead of esc : clear()
 * <input key-bind="{ enter: 'go()', esc: 'clear()' }" type="text"
 *
 */

(function() {
  angular.module('KeyBindDirective', []).constant('keyCodes', {
    esc: 27,
    space: 32,
    enter: 13,
    tab: 9,
    backspace: 8,
    shift: 16,
    ctrl: 17,
    alt: 18,
    capslock: 20,
    numlock: 144
  }).directive('keyBind', [
    'keyCodes', function(keyCodes) {
      var map;
      map = function(obj) {
        var action, key, mapped;
        mapped = {};
        for (key in obj) {
          action = obj[key];
          if (keyCodes.hasOwnProperty(key)) {
            mapped[keyCodes[key]] = action;
          }
        }
        return mapped;
      };
      return function(scope, element, attrs) {
        var bindings;
        bindings = map(scope.$eval(attrs.keyBind));
        return element.bind('keyup', function(event) {
          if (bindings.hasOwnProperty(event.which)) {
            return scope.$apply(function() {
              return scope.$eval(bindings[event.which]);
            });
          }
        });
      };
    }
  ]);

}).call(this);


/**
 * ListingService
 * Handle Collections of Data from AJAX Request
 *
 * @package 		ListingService
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  angular.module('ListingService', []).service("ListingService", [
    'ApiFactory', function(ApiFactory) {
      var options;
      options = {
        collections: [],
        data: [],
        range: [],
        totalPages: 0,
        currentPage: 1,
        requestData: function(requestURI, reqMethod, data, qDefer) {
          if (reqMethod != null) {
            reqMethod = reqMethod;
          } else {
            reqMethod = 'POST';
          }
          data = data != null ? data : {};
          return ApiFactory.sendRequest(data, requestURI, reqMethod, qDefer);
        },
        dataHandler: function(response, status) {
          var ceil, floor, i, max, pages;
          this.collections = response;
          this.totalPages = response.last_page;
          this.currentPage = response.current_page;
          this.data = response.data != null ? response.data : [];
          pages = [];
          ceil = Math.ceil((this.currentPage + 1) / 10) * 10;
          floor = Math.floor((this.currentPage + 1) / 10) * 10;
          if (ceil > this.totalPages) {
            floor = Math.floor((this.currentPage - 1) / 10) * 10;
            max = this.totalPages;
          } else {
            max = ceil;
          }
          if (ceil === floor) {
            floor -= 10;
          }
          i = floor > 0 ? floor : 1;
          while (i <= max) {
            pages.push(i);
            i++;
          }
          return this.range = pages;
        },
        getCollections: function() {}
      };
      return options;
    }
  ]);

}).call(this);


/**
 * Only Number Input
 *
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  angular.module('NumberOnlyDirective', []).directive("numberOnly", function() {
    return {
      restrict: "A",
      require: 'ngModel',
      link: function($scope, $element, $attrs, $model) {
        var filter;
        filter = /[^0-9]/g;
        if (angular.isDefined($attrs.allowDecimal)) {
          filter = /[^0-9.]/g;
        }
        $model.$parsers.push(function(inputValue) {
          var transformedInput;
          if (inputValue === void 0) {
            return '';
          }
          transformedInput = inputValue.replace(filter, '');
          if (transformedInput !== inputValue) {
            $model.$setViewValue(transformedInput);
            $model.$render();
          }
          return transformedInput;
        });
      }
    };
  });

}).call(this);


/**
 * __DESCRIPTIONS__
 * __SHORT_DESCRIPTION__
 *
 * @class        Pagination Directive
 * @package      AngularModules
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  angular.module('PaginationDirective', []).directive("paginationDirective", function() {
    return {
      restrict: "E",
      template: function(tElem, tAttr) {
        if (tAttr.mode === 'simple') {
          return '<ul class="pagination" ng-if="range.length > 1">' + '<li ng-class="currentPage == 1 ? \'disabled\' : \'\'">' + '<button class="btn paginate-directive-btn" ng-disabled="currentPage == 1" ng-click="getCollections(currentPage-1)">&lsaquo; Prev</button>' + '</li>' + '<li ng-class="currentPage == totalPages ? \'disabled\' : \'\'">' + '<button class="btn paginate-directive-btn" ng-disabled="currentPage == totalPages" ng-click="getCollections(currentPage+1)">Next &rsaquo;</button>' + '</li>' + '</ul>';
        } else {
          return '<ul class="pagination" ng-if="range.length > 1">' + '<li class="page-item" ng-show="currentPage != 1"><a class="page-link" href="javascript:void(0)" ng-click="getCollections(1)">&laquo;</a></li>' + '<li class="page-item" ng-show="currentPage != 1"><a class="page-link" href="javascript:void(0)" ng-click="getCollections(currentPage-1)">&lsaquo; Prev</a></li>' + '<li class="page-item" ng-repeat="i in range" ng-class="{active : currentPage == i}">' + '<a class="page-link" href="javascript:void(0)" ng-click="getCollections(i)">{{ i }}</a>' + '</li>' + '<li class="page-item" ng-show="currentPage != totalPages"><a class="page-link" href="javascript:void(0)" ng-click="getCollections(currentPage+1)">Next &rsaquo;</a></li>' + '<li class="page-item" ng-show="currentPage != totalPages"><a class="page-link" href="javascript:void(0)" ng-click="getCollections(totalPages)">&raquo;</a></li>' + '</ul>';
        }
      }
    };
  });

}).call(this);


/**
 * SweetAlertService
 * Handle SweetAlert Wrapper
 *
 * @package SweetAlertService
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  angular.module('SweetAlertService', []).service("SweetAlertService", [
    '$rootScope', function($rootScope) {
      var options;
      return options = {
        swal: function(arg1, arg2, arg3) {
          $rootScope.$evalAsync(function() {
            if (typeof arg2 === 'function') {
              swal(arg1, (function(isConfirm) {
                $rootScope.$evalAsync(function() {
                  arg2(isConfirm);
                });
              }), arg3);
            } else {
              swal(arg1, arg2, arg3);
            }
          });
        },
        success: function(title, message) {
          $rootScope.$evalAsync(function() {
            swal(title, message, 'success');
          });
        },
        error: function(title, message) {
          $rootScope.$evalAsync(function() {
            swal(title, message, 'error');
          });
        },
        warning: function(title, message) {
          $rootScope.$evalAsync(function() {
            swal(title, message, 'warning');
          });
        },
        info: function(title, message) {
          $rootScope.$evalAsync(function() {
            swal(title, message, 'info');
          });
        },
        showInputError: function(message) {
          $rootScope.$evalAsync(function() {
            swal.showInputError(message);
          });
        },
        close: function() {
          $rootScope.$evalAsync(function() {
            swal.close();
          });
        }
      };
    }
  ]);

}).call(this);


/**
 * SystemFactory
 *
 * @class SystemFactory
 * @package AngularModules
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  _.mixin({
    capitalize: function(string) {
      return string.charAt(0).toUpperCase() + string.substring(1).toLowerCase();
    }
  });

  angular.module('SystemFactory', []).factory("SystemFactory", [
    '$rootScope', function($rootScope) {
      return {

        /**
         * validateObj()
         *
         * @return
         */
        validateObj: function(obj, requiredFields) {
          if (_h.isEmptyObj(obj)) {
            throw 'Empty Input, Cannot Validate';
          }
          _.each(requiredFields, function(val, key) {
            if (angular.isUndefined(obj[val])) {
              throw 'Missing required input: ' + val;
            }
            if (obj[val] === '') {
              throw 'Empty input data for : ' + val;
            }
          });
          return true;
        },

        /**
         * Transform Object to FormData
         * Ex.
         * data = obj: 
         *            prop: 'property value'
         *           arr: [
         *             'one'
         *             'two'
         *             'three'
         *             new File([ '' ], '')
         *           ]
         *           file: new File([ '' ], '')
         * 
         * objectToFormData(data)
         *
         *
         * @param (object) obj
         * @param (object) form
         * @param (string) namespace
         * @return void
         */
        objectToFormData: function(obj, form, namespace) {
          var fd, formKey, property;
          fd = form || new FormData;
          formKey = void 0;
          for (property in obj) {
            if (obj.hasOwnProperty(property)) {
              if (namespace) {
                formKey = namespace + '[' + property + ']';
              } else {
                formKey = property;
              }
              if (typeof obj[property] === 'object' && !(obj[property] instanceof File)) {
                this.objectToFormData(obj[property], fd, formKey);
              } else {
                fd.append(formKey, obj[property]);
              }
            }
          }
          return fd;
        }
      };
    }
  ]);

}).call(this);


/**
 * systemFilter
 *
 * @package systemFilter
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  angular.module('SystemFilter', []).filter('groupBy', [
    '$parse', function($parse) {
      return _.memoize(function(items, field) {
        var getter;
        getter = $parse(field);
        return _.groupBy(items, function(item) {
          return getter(item);
        });
      });
    }
  ]).filter('format_bytes', function() {
    return function(bytes, si) {
      var thresh, u, units;
      si = 1024;
      thresh = si ? 1000 : 1024;
      if (bytes < thresh) {
        return bytes + ' B';
      }
      units = si ? ['KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'] : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
      u = -1;
      while (true) {
        bytes /= thresh;
        ++u;
        if (!(bytes >= thresh)) {
          break;
        }
      }
      return bytes.toFixed(1) + ' ' + units[u];
    };
  }).filter('truncateStr', function() {
    return function(value, max, wordwise, tail) {
      var lastspace;
      if (!value) {
        return '';
      }
      max = parseInt(max, 10);
      if (!max) {
        return value;
      }
      if (value.length <= max) {
        return value;
      }
      value = value.substr(0, max);
      if (wordwise) {
        lastspace = value.lastIndexOf(' ');
        if (lastspace !== -1) {
          value = value.substr(0, lastspace);
        }
      }
      return value + (tail || '...');
    };
  }).filter('truncateMiddle', function() {
    return function(str, length, separator) {
      var end, pad, start;
      if (length == null) {
        length = 20;
      }
      if (separator == null) {
        separator = '...';
      }
      if (str === null) {
        return '';
      }
      if (str === void 0) {
        return '';
      }
      if (str.length <= length) {
        return str;
      }
      pad = Math.round((length - separator.length) / 2);
      start = str.substr(0, pad);
      end = str.substr(str.length - pad);
      return [start, separator, end].join('');
    };
  }).filter('trusted_html', [
    '$sce', function($sce) {
      return function(text) {
        return $sce.trustAsHtml(text);
      };
    }
  ]).filter('remove_slash', function() {
    return function(str) {
      if (str) {
        return str.replace(/\\/g, '');
      }
    };
  });

}).call(this);


/**
 * Only Number Input
 *
 * @category     ToggleDirective
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  angular.module('ToggleDirective', []).directive("toggle", [
    '$rootScope', function($rootScope) {
      return {
        restrict: 'A',
        link: function(scope, element, attrs) {
          if (attrs.toggle === 'tooltip') {
            $(element).tooltip();
          }
          if (attrs.toggle === 'popover') {
            $(element).popover();
          }
        }
      };
    }
  ]);

}).call(this);


/**
 * __DESCRIPTIONS__
 * __SHORT_DESCRIPTION__
 *
 * @class UploadFactory
 * @package AngularModules
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  angular.module('UploadFactory', []).factory("UploaderFactory", [
    '$rootScope', '$timeout', function($rootScope, $timeout) {
      return {
        dataObj: [],
        xhr: [],
        defaultIndex: 0,

        /**
         * __DESCRIPTIONS
         *
         * @params void
         */
        httpRequest: function(index) {
          var ex;
          if (window.XMLHttpRequest) {
            try {
              return this.xhr[index] = new XMLHttpRequest;
            } catch (error) {
              ex = error;
              return this.xhr[index] = new window.ActiveXObject('Microsoft.XMLHTTP');
            }
          } else {
            return false;
          }
        },

        /**
         * __DESCRIPTIONS
         *
         * @params void
         */
        upload: function(url, formObj, dataObj, index) {
          var _this;
          if (angular.isUndefined(index)) {
            index = this.defaultIndex;
          }
          this.xhr[index] = this.httpRequest(index);
          if (!this.xhr[index]) {
            $rootScope.$emit('upload:bad');
            return false;
          }
          this.dataObj[index] = dataObj;
          this.xhr[index].open("POST", url);
          this.dataObj[index].xhr = this.xhr[index];
          this.xhr[index].setRequestHeader("X-CSRF-Token", angular.element("meta[name='_token']").attr('content'));
          this.xhr[index].setRequestHeader("X-Requested-With", 'XMLHttpRequest');
          _this = this;
          _this.xhr[index].upload.onprogress = function(evt) {
            return _this.progress(evt, index);
          };
          _this.xhr[index].onabort = function() {
            return _this.abort(index);
          };
          _this.xhr[index].onerror = function() {
            return _this.abort(index);
          };
          _this.xhr[index].onload = function(evt) {
            return _this.complete(evt, index);
          };
          _this.xhr[index].onreadystatechange = function(evt) {
            if (_this.xhr[index].readyState === 4) {
              return $timeout(function() {
                var ref;
                if ((ref = _this.xhr[index]) != null ? ref.response : void 0) {
                  _this.dataObj[index].response = JSON.parse(_this.xhr[index].response);
                  _this.dataObj[index].status = _this.dataObj[index].response.status === "error" ? 0 : 2;
                  return _this.dataObj[index].xhr[index] = false;
                }
              });
            }
          };
          return _this.xhr[index].send(formObj);
        },

        /**
         * __DESCRIPTIONS
         *
         * @params void
         */
        progress: function(evt, index) {
          var _this;
          _this = this;
          if (evt.type === 'progress') {
            return $timeout(function() {
              _this.dataObj[index].status = 1;
              if (evt.lengthComputable) {
                return _this.dataObj[index].progress = Math.round(evt.loaded * 100 / evt.total);
              } else {
                return _this.dataObj[index].progress = 0;
              }
            });
          }
        },

        /**
         * __DESCRIPTIONS
         *
         * @params void
         */
        abort: function(index) {
          var _this;
          _this = this;
          return $timeout(function() {
            _this.dataObj[index].status = 0;
            _this.dataObj[index].xhr.abort();
            return $rootScope.$emit('upload:abort', index);
          });
        },

        /**
         * __DESCRIPTIONS
         *
         * @params void
         */
        complete: function(evt, index) {
          return $rootScope.$emit('upload:complete', this.dataObj[index], index);
        }
      };
    }
  ]);

}).call(this);

//# sourceMappingURL=angular-modules.js.map
