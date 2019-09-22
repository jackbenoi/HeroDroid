###*
# Provide Drag and Drop Capability using this file-uploader directive
#
#
# @class fileUploader Directives
# @package AngularModules
# @author       Anthony Pillos <dev.anthonypillos@gmail.com>
# @copyright    Copyright (c) 2016 Anthony Pillos. (http://anthonypillos.com,http://iapdesign.com,http://developers.ph)
# @version      v1
###

angular.module('AddThisDirective',[])

.directive 'addthisShare', ->
  restrict: 'E'
  replace: true
  template: """
    <div class="addthis_sharing_toolbox addthis_default_style addthis_32x32_style">
      <div id="atstbx" class="at-resp-share-element at-style-responsive addthis-smartlayers addthis-animated at4-show">
        <fb></fb>
        <twit></twit>
        <googleplus></googleplus>
        <email></email>
        <more></more>
        </div>
    </div>
  """
  link: (scope, elem, attrs) -> 
    addthis.init()
    addthis.toolbox elem.get()
    
.directive 'fb', ->
  restrict: 'E'
  replace: true
  template: '<a href class="addthis_button_facebook at-icon-wrapper at-share-btn" style="background-color: rgb(59, 89, 152); border-radius: 2px;"></a>'
  
.directive 'twit', ->
  restrict: 'E'
  replace: true
  template: '<a class="addthis_button_twitter at-icon-wrapper at-share-btn" style="background-color: rgb(29, 161, 242); border-radius: 2px;"></a>'

.directive 'googleplus', ->
  restrict: 'E'
  replace: true
  template: '<a class="addthis_button_google_plusone_share at-icon-wrapper at-share-btn" style="background-color: rgb(220, 78, 65); border-radius: 2px;"></a>'

.directive 'email', ->
  restrict: 'E'
  replace: true
  template: '<a class="addthis_button_email at-icon-wrapper at-share-btn" style="background-color: rgb(132, 132, 132); border-radius: 2px;"></a>'

.directive 'more', ->
  restrict: 'E'
  replace: true
  template: '<a class="addthis_button_compact at-icon-wrapper at-share-btn" style="background-color: rgb(255, 101, 80); border-radius: 2px;"></a>'