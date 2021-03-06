
/**
 * Frontend App Start
 *
 * @class        FrontendApp
 * @package      APPMarket.Frontend.FrontendApp
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2017 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  var FrontendApp;

  FrontendApp = (function() {
    function FrontendApp() {
      var app;
      app = angular.module('FrontendApp', ['ApiFactory', 'SystemFactory', 'ui.bootstrap', 'ui.tinymce', 'localytics.directives', 'ListingService', 'NumberOnlyDirective', 'blockUI', 'PaginationDirective', 'FileUploaderDirective', 'UploadFactory', 'SweetAlertService', 'SystemFilter', 'KeyBindDirective', 'ngAnimate', 'ngTagsInput']);
      app.config([
        'blockUIConfig', function(blockUIConfig) {
          blockUIConfig.message = 'Please Wait...';
          return blockUIConfig.autoBlock = false;
        }
      ]);
      app.run([
        '$rootScope', function($rootScope) {
          $rootScope.perPageArray = [20, 30, 50, 100, 500, 1000];
          return $rootScope.tinymceOptions = {
            height: 250,
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor colorpicker textpattern imagetools codesample toc',
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
            toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
            image_advtab: true,
            imagetools_cors_hosts: ['appmarketcms.dev'],
            themes: 'modern',
            force_p_newlines: false,
            force_br_newlines: true,
            forced_root_block: ''
          };
        }
      ]);
      return app;
    }

    return FrontendApp;

  })();

  window.APPMarket.Frontend.FrontendApp = new FrontendApp;

}).call(this);

//# sourceMappingURL=app.js.map
