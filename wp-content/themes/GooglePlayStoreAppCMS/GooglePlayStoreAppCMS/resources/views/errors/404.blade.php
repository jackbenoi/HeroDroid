@extends('frontend.layouts.frontend')

@section('content')

<div class="card">
    <div class="card-header">
        <a href="">404 - Page Not Found</a>
    </div>
    <div class="card-block">
    	<h5 class="text-center">I'm sorry, we can't find what you're looking for.</h5>
		<p class="text-xs-center">
			Please check our homepage link: <a href="{{ url('/') }}" title="{{ $configuration['cms_name'] }}">{{ $configuration['cms_name'] }}</a>
		</p>
       <hr />
    </div>
</div>

@stop