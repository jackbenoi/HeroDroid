###*
# Frontend App Start
#
# @class        DetailApp
# @package      APPMarket.Frontend.DetailApp
# @author       Anthony Pillos <dev.anthonypillos@gmail.com>
# @copyright    Copyright (c) 2017 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

class DetailApp

    constructor: () ->
        app = angular.module('DetailApp', ['ApiFactory'
                                            'SystemFactory'
                                            'ui.bootstrap'
                                            'blockUI'
                                            'sn.addthis'
                                            ])


        app.config  ['blockUIConfig', (blockUIConfig) ->

            blockUIConfig.message   = 'Please Wait...'
            blockUIConfig.autoBlock = false
        ]

        app.run ['$rootScope', ($rootScope) ->

        ]
        return app

window.APPMarket.Frontend.DetailApp = new DetailApp