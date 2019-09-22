@extends('frontend.layouts.frontend')


@section('site_title')
My Submitted Apps / Games | {{ @$configuration['site_title'] }}@stop

@section('content')

<div class="card">
    <div class="card-header">
        <div class="pull-left">
            <a href="">My Submitted Apps / Games</a>
        </div>
        
    </div>
    <div class="card-block">

        <div class="card-block">
                
                    <table class="table table-bordered table-striped m-b-0">
                        <thead>
                            <tr>
                                <th width="10">
                                </th>
                                <th width="100">
                                    AppName
                                </th>
                                <th width="50">
                                    Status
                                </th>
                                <th width="100" class="text-center" align="center"  style="text-align: center;">
                                   Action
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody block-ui="blockui-effect">
                            
                            @if(isset($itemLists) and !$itemLists->isEmpty())
                                @foreach($itemLists as $item)
                                    <tr class="items">
                                        <td width="10">
                                             <div uib-tooltip="{{ $item->title }}" style="text-align: center;">
                                                 <img src="{{ isset($item->appImage->image_url) ? $item->appImage->image_url : $item->image_url }}"  width="30px">
                                             </div>
                                        </td>
                                       
                                        <td width="200">
                                             <div uib-tooltip="{{ $item->title }}">{{ $item->title }}</div>
                                        </td>
                                      
                                        <td width="10">
                                            <div uib-tooltip="{{ $item->is_enabled == '1' ? 'Approve' : 'Pending'}}">
                                                <button class="btn btn-sm btn-{{ $item->is_enabled == '1' ? 'success' : 'danger'}}">
                                                    {{ $item->is_enabled == '1' ? 'Approve' : 'Pending'}}
                                                </button>
                                            </div>
                                        </td>
                                        <td align="center" width="10"> 

                                            @if($item->is_enabled == 1)
                                                <a href="{{ route('frontend.submitapps.detail',$item->app_id) }}" class="btn btn-sm  btn-info">
                                                     <i class="fa fa-pencil"></i>
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-sm  btn-default">
                                                    Waiting for Review
                                                </a>
                                            @endif
                                           {{--  <button tooltip="Delete {{ $item->title }}" class="btn btn-sm  btn-danger">
                                               <i class="fa fa-remove"></i>
                                             </button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td  align="center" mode="simple" colspan="6">No Result Found!</td>
                                </tr>
                            @endif
                            
                        </tbody>
                    </table>

                    <nav class="pull-right">
                      <pagination-directive class="pull-right"></pagination-directive>
                    </nav>
            </div>
    </div>
    
</div>

@stop
@section('scripts')


@stop