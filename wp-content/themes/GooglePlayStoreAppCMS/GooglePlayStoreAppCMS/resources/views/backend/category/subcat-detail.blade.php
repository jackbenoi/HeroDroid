@extends('backend.layouts.backend')

@section('menu') @if(isset($is_create) && $is_create == 1) Create @else Edit @endif Category 
@stop
@section('content')


<div class="row" ng-controller="CategoryController">
        
<div class="card">
    <div class="card-header ">
        <h4 class="card-title">
            <a class="btn btn-sm btn-default" href="{{ route('backend.sub.category.index',@$parentCatId) }}">
            <i class="fa fa-arrow-left"></i> Go Back</a>
            |
            @if(isset($is_create) && $is_create == 1)
            Create New Categories
            @else
            Update Category Information
            @endif
        </h4>
    </div>
    <div class="card-block">

        <form block-ui="blockui-effect" ng-cloak>

            <fieldset class="form-group">
                <label for="title" >
                    <strong>Category is @{{ details.is_enabled == true ? 'Enabled' : 'Disabled' }} </strong>
                </label>
                
               <input type="checkbox" class="form-control" ng-model="details.is_enabled">
            </fieldset>

            <fieldset class="form-group">
                <label for="title">
                Icon (Font Awesome Icon)
                </label>
                <input type="text" class="form-control" id="title" placeholder="Enter font awesome name" ng-model="details.icon">
                <small>Ex. type: "android" and it will automatically display like this -> fa fa-android</small>
                
            </fieldset>
            
            <fieldset class="form-group">
                <label for="title" >
                    <strong>Set as Featured Category</strong>
                </label>
               <input type="checkbox" class="form-control" ng-model="details.is_featured">
            </fieldset>


            <fieldset class="form-group">
                <label for="title">
                Title
                </label>
                <input type="text" class="form-control" id="title" placeholder="Enter category title" ng-model="details.title">
                
            </fieldset>
            <fieldset class="form-group">
                <label for="description">
                Description
                </label>
                
                <textarea  class="form-control" placeholder="Enter category description" rows="6" ui-tinymce="tinymceOptions" ng-model="details.description"></textarea>

            </fieldset>


            
            @include('backend.layouts.common.seo')

            @if(isset($is_create) && $is_create == 1)

                @if($isDemo)
                   @include('backend.layouts.common.demo-btn')
                @else
                    <button type="button" class="btn btn-info" ng-click="create()"><i class="fa fa-user-plus"></i> Add New Category</button>
                @endif
            @else
                @if($isDemo)
                   @include('backend.layouts.common.demo-btn')
                @else
                    <button type="button" class="btn btn-info" ng-click="update()"><i class="fa fa-save"></i> Update Information</button>
                @endif

            @endif
        </form>
    </div>
</div>


</div>
@stop
@include('backend.category.partials.js')