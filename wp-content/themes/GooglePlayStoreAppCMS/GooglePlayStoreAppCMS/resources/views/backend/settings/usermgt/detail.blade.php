@extends('backend.layouts.backend')

@section('menu') User Management
@stop

@section('content')


<div class="row" ng-controller="UserController">
    <div class="card">
        <div class="card-header ">
            <h4 class="card-title">
                <a class="btn btn-sm btn-default" href="{{ route('backend.setting.usermgt') }}">
                <i class="fa fa-arrow-left"></i> Go Back</a>
                |
                @if(isset($is_create) && $is_create == 1)
                Create New User
                @else
                Update User Information
                @endif
            </h4>
        </div>
        <div class="card-block">
            <div block-ui="blockui-effect" ng-cloak>
                <div class="card-block">
                    <div class="col-md-7">
                        <h4>User Information</h4>
                        <form>
                            <fieldset class="form-group">
                                <label for="exampleInputEmail1">
                                    Firstname
                                </label>
                                <input type="text" class="form-control" name="first_name" ng-model="details.first_name" placeholder="Firstname" >
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="exampleInputEmail1">
                                    Lastname
                                </label>
                                <input type="text" class="form-control" name="last_name" ng-model="details.last_name"placeholder="Lastname" >
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="exampleInputEmail1">
                                    Email address
                                </label>
                                <input type="email" class="form-control" name="email" ng-model="details.email" placeholder="Email Address" >
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="exampleInputEmail1">
                                    Username
                                </label>
                                <input type="text" class="form-control" name="username" ng-model="details.username" placeholder="Username" >
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="exampleInputEmail1">
                                    Password
                                </label>
                                <input type="password" class="form-control" name="password" ng-model="details.password" placeholder="*********" >
                            </fieldset>

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
                    <div class="col-md-5">
                        <h4>User Roles</h4>

                        <ul class="list-unstyled">
                            <li ng-repeat="group_type in group_list track by $index">
                                  <label class="form-checkbox form-normal form-success form-text"
                                         ng-class="{'active': group_type.selected}">
                                      <input type="checkbox"
                                         ng-model="group_type.selected"
                                         ng-change="updateChildCheckboxes(group_type)"> @{{ group_type.name.replace('_', ' ')  }}
                                  </label>
                                  {{-- <ul>
                                      <li ng-repeat="(key, value) in group_type.permissions">
                                          <label class="form-checkbox form-normal form-success form-text"
                                                 ng-class="{'active': group_type.permissions[key]}">
                                              <input type="checkbox"
                                                     ng-change="updateCheckbox(group_type.permissions[key], group_type)"
                                                     ng-model="group_type.permissions[key]"> @{{ key | remove_namespace:group_type.name | ucwords }}
                                          </label>
                                      </li>
                                  </ul> --}}
                            </li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@include('backend.settings.usermgt.partials.js')