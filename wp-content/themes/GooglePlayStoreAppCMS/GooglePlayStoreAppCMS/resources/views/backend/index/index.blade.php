@extends('backend.layouts.backend')


@section('content')

<h3 class="text-center"> <i class="fa fa-android 5x"></i> Welcome to {{ @$configuration['site_title'] }}</h3>
<hr/>
<div class="row">

	 <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="card card-block">
        	<h5 class="m-b-0 v-align-middle text-overflow">
        		Application Tools
        	</h5>
        	<hr/>
            <a href="{{ route('backend.index.cache-clear') }}" class="btn btn-danger btn-round m-r-xs m-b-xs">
                <i class="fa fa-wrench"></i> Clear App Cache/Session
            </a>
            <a  href="{{ route('backend.index.clear-views') }}" class="btn btn-danger btn-round m-r-xs m-b-xs">
                <i class="fa fa-wrench"></i> Clear Cache Views
            </a>
            <a  href="{{ route('backend.index.clear-session') }}" class="btn btn-danger btn-round m-r-xs m-b-xs">
                <i class="fa fa-wrench"></i> Clear All Sessions
            </a>

            <a  href="{{ route('backend.index.clear-logs') }}" class="btn btn-danger btn-round m-r-xs m-b-xs">
                <i class="fa fa-wrench"></i> Clear System Logs
            </a>
             <a  href="{{ route('backend.index.translation-reset') }}" class="btn btn-primary btn-round m-r-xs m-b-xs">
                <i class="fa fa-language"></i> Translation Reset & Import
            </a>
        </div>
    </div>

    <div class="col-sm-6 col-md-3 col-lg-3">
        <div class="card card-block">
            <h5 class="m-b-0 v-align-middle text-overflow">
                <span class="small pull-xs-right">
                	<i class="fa fa-users fa-3x"></i>
                </span>
                <span>{{ @$totalUsers }}</span>
            </h5>
            <div class="small text-overflow text-muted">
                Total Users
            </div>
        </div>
    </div>

  
    @if(isset($marketStats))

    @foreach($marketStats as $stat)
	    <div class="col-sm-6 col-md-3 col-lg-3">
	        <div class="card card-block">
	            <h5 class="m-b-0 v-align-middle text-overflow">
	                <span class="small pull-xs-right">

	                	@if($stat->identifier == 'game')
	                		<i class="fa fa-gamepad fa-3x"></i>
	                	@elseif($stat->identifier == 'theme')
	                		<i class="fa fa-mobile fa-3x"></i>
	                	@else
	                		<i class="fa fa-android fa-3x"></i>
	                	@endif
	                </span>
	                <span>{{ $stat->total }}</span>
	            </h5>
	            <div class="small text-overflow text-muted">
	                Total {{ str_plural($stat->title) }}
	            </div>
	        </div>
	    </div>
    @endforeach

    @endif

</div>

<div class="row">
    <div class="col-sm-6 col-md-4 col-lg-4">
		<div class="card">
		    <div class="card-header no-bg b-a-0">
		        <i class="fa fa-android fa-2x"></i> Most Popular Apps/Games
		    </div>
		    <div class="card-block">
		        <table class="table ">
		        	<thead>
		        		<th>Image</th>
		        		<th>Name</th>
		        		<th>Views</th>
		        	</thead>
		        	<tbody>
						@foreach($popularApps as $item)
			        		@if(isset($item->app))
			        		<tr>
			        			<td><img src="{{ isset($item->app->appImage) ? $item->app->appImage->image_link : $item->app->image_url }}" alt="{{ $item->app->title }}" width="30px" class="img-fluid"> </td>
				        		<td><i class="fa fa-android"></i> {{ truncate($item->app->title,20) }}</td>
				        		<td><i class="fa fa-eye"></i> {{ countFormat($item->views) }}</td>
			        		</tr>
			        		@endif
		        		@endforeach


		        	</tbody>
		        </table>
		    </div>
		</div>
	</div>

	<div class="col-sm-6 col-md-4 col-lg-4">
		<div class="card">
		    <div class="card-header no-bg b-a-0">
		        <i class="fa fa-list fa-2x"></i> Most Popular Categories
		    </div>
		    <div class="card-block">
		        <table class="table ">
		        	<thead>
		        		<th>Name</th>
		        		<th class="text-center">Views</th>
		        	</thead>
		        	<tbody>
		        		@foreach($popularCategories as $item)
		        		<tr>
			        		<td><i class="fa fa-2x fa-list-ul"></i> {{ $item->category->title }} </td>
			        		<td class="text-center"><i class="fa fa-eye"></i> {{ countFormat($item->views ) }}</td>
		        		</tr>
		        		@endforeach
		        	</tbody>
		        </table>
		    </div>
		</div>
	</div>

	<div class="col-sm-6 col-md-4 col-lg-4">
		<div class="card">
		    <div class="card-header no-bg b-a-0">
		        <i class="fa fa-users fa-2x"></i> Users
		    </div>
		    <div class="card-block">
		        <table class="table ">
		        	<thead>
		        		<th>Name</th>
		        		<th class="text-center"> Total Apps</th>
		        	</thead>
		        	<tbody>
		        		@foreach($recentUsers as $item)
		        		<tr>
			        		<td><i class="fa fa-user"></i> {{ $item->full_name }}</td>
			        		<td class="text-center"><i class="fa fa-android"></i> {{ $item->appMarkets->count() }}</td>
		        		</tr>
		        		@endforeach

		        	</tbody>
		        </table>
		    </div>
		</div>
	</div>
</div>

@stop