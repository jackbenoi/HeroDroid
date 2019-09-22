@extends('backend.layouts.backend')

@section('menu') Featured Editor's Pick App Setup
@stop

@section('content')
<div class="row" ng-controller="FeaturedAppController">


    <div class="card">
        <div class="card-header ">
            <h5>Featured / Editor's Pick Apps</h5>
        </div>
        <div class="card-block">

            <div class="col-md-6 offset-md-3">

                <table class="table table-bordered">
                    
                    <thead class="thead-inverse">
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th style="text-align: center">Actions</th>
                        </tr>
                    </thead>
                    @if(isset($featuredItems) && !$featuredItems->isEmpty())
                        @foreach($featuredItems as $item)
                            <tr class="items" >
                                <td width="10">
                                     <div uib-tooltip="{{ $item->title }}" style="text-align: center;">
                                         <img src="{{  isset($item->appImage) ? $item->appImage->image_link :  $item->image_url  }}" width="30px">
                                     </div>
                                </td>
                                <td>
                                     <div uib-tooltip="{{ $item->title }}">{{ $item->title }}</div>
                                </td>
                                <td align="center">

                                    <button class="btn btn-danger btn-sm btn-icon-icon" ng-click="delete('{{ $item->id }}')"><i class="material-icons">delete</i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td  align="center" mode="simple" colspan="3">No Result Featured App Setup.</td>
                        </tr>
                    @endif
                </table>

                <nav style="text-align: center;">

                    {{--*/ $link_limit = 4; /*--}}
                    @if ($featuredItems->lastPage() > 1)
                        <ul class="pagination">
                            <li class="page-item {{ ($featuredItems->currentPage() == 1) ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $featuredItems->url(1) }}">First</a>
                             </li>

                            @for ($i = 1; $i <= $featuredItems->lastPage(); $i++)
                                <?php
                                $half_total_links = floor($link_limit / 2);
                                $from = $featuredItems->currentPage() - $half_total_links;
                                $to = $featuredItems->currentPage() + $half_total_links;
                                if ($featuredItems->currentPage() < $half_total_links) {
                                   $to += $half_total_links - $featuredItems->currentPage();
                                }
                                if ($featuredItems->lastPage() - $featuredItems->currentPage() < $half_total_links) {
                                    $from -= $half_total_links - ($featuredItems->lastPage() - $featuredItems->currentPage()) - 1;
                                }
                                ?>
                                @if ($from < $i && $i < $to)
                                    <li class="page-item {{ ($featuredItems->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $featuredItems->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor
                            <li class="page-item {{ ($featuredItems->currentPage() == $featuredItems->lastPage()) ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $featuredItems->url($featuredItems->lastPage()) }}">Last</a>
                            </li>
                        </ul>
                    @endif
                </nav>
            </div>


        </div>
    </div>

    <div class="card">
        <div class="card-header ">
            <h5 class="card-title">
                Select App to be featured in our homepage.
            </h5>
        </div>

        <div class="card-block">

            <div class="col-md-12">
                <div class="input-group">
                    <input class="form-control" ng-model="details.search" placeholder="Search for apps or games title" key-bind="{ enter: 'search()'}">
                    <span class="input-group-btn"> 
                        <button class="btn btn-primary" ng-click="search()" type="button">Go!</button> 
                        <button class="btn btn-default" ng-click="clearAll()" type="button">Clear All</button> 
                    </span> 
                </div> 

                <div class="input-group">
                    <div class="form-group">
                        <label for="data">Show Data Per Page</label>
                        <select class="form-control"
                            ng-options="page | number for page  in perPageArray "
                            data-placeholder="Show Data Per Page"
                            ng-model="details.per_page"
                            ng-change="perPageChange(details.per_page)">
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <strong>Filter by Letter</strong>
                    <div class="well well-sm" style="text-align: center;margin:5px 0px;padding: 20px;background: #f5f5f5;">
                        <div class="text-center" ng-cloak>
                            <a style="color: #ffffff;"  class="btn btn-success btn-circle" ng-click="letterFilter('')"> All </a>
                            <a style="color: #ffffff;" ng-repeat="letter in letters track by $index" ng-class="{'active': letter == details.letter}" class="btn btn-success btn-circle" ng-model="details.letter" ng-click="letterFilter(letter)"> @{{ letter }} </a>
                        </div>
                    </div>
                </div>
                <div class="input-group">

                        @if($isDemo)
                            <button type="button" class="btn btn-block btn-sm btn-warning">
                                Demo Mode Active
                            </button>
                        @else
                            <button class="btn bg-dark btn-block" ng-click="addAllSelected()" type="button"><i class="fa fa-plus"></i> Add all selected to featured item.</button> 
                        @endif
                        
                </div>
                <div class="input-group">
                    <div class="row">
                        
                        <div class="col-md-12">
                            <div class="col-md-4" ng-repeat="list in data track by $index">

                                <table class="table ">
                                    <tr class="items" >
                                        <td width="1">
                                            <label class="custom-control custom-checkbox">
                                              <input type="checkbox" class="custom-control-input" ng-model="list.is_featured">
                                              <span class="custom-control-indicator"></span>
                                              <span class="custom-control-description"> </span>
                                            </label>
                                        </td>
                                        <td width="10">
                                             <div uib-tooltip="@{{ list.title }}" style="text-align: center;">
                                                 <img src="@{{ list.image_url || list.app_image.image_link }}" width="30px">
                                             </div>
                                        </td>
                                        <td>
                                             <div uib-tooltip="@{{ list.title }}">@{{ list.title | truncateStr:8 }}</div>
                                        </td>
                                    </tr>
                                    <tr ng-if="data.length == 0">
                                        <td  align="center" mode="simple" colspan="2">No Result Found!</td>
                                    </tr>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
                <hr/>
                <nav class="pull-right">
                  <pagination-directive class="pull-right"></pagination-directive>
                </nav>
            </div>
            
        </div>
    </div>
</div>

@stop
@include('backend.settings.featured_app.partials.js')