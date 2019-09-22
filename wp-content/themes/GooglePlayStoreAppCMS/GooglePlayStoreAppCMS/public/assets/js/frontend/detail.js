
/**
 * Frontend App Start
 *
 * @class        DetailApp
 * @package      APPMarket.Frontend.DetailApp
 * @author       Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright    Copyright (c) 2017 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
 * @version      v1
 */

(function() {
  var DetailApp;

  DetailApp = (function() {
    function DetailApp() {
      var app;
      app = angular.module('DetailApp', ['ApiFactory', 'SystemFactory', 'ui.bootstrap', 'blockUI', 'sn.addthis']);
      app.config([
        'blockUIConfig', function(blockUIConfig) {
          blockUIConfig.message = 'Please Wait...';
          return blockUIConfig.autoBlock = false;
        }
      ]);
      app.run(['$rootScope', function($rootScope) {}]);
      return app;
    }

    return DetailApp;

  })();

  window.APPMarket.Frontend.DetailApp = new DetailApp;

}).call(this);

//# sourceMappingURL=detail.js.map
