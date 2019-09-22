@extends('frontend.layouts.frontend')


@section('content')


<div class="card">
    <div class="card-header">
        <div class="pull-left">
            {{ trans('frontend.contact_us.title') }}
        </div>
    </div>
    <div class="card-block">
       
        {{ Form::open(['accept-charset'=>'UTF-8', 'url' => route('frontend.contact-post'), 'method' => 'POST']) }}
		    <div id="tab1" class="col s12 white_bg plate_shadow">
		        <div class="panel-body">
		            <div class="form-group">
		                @if($errors->has())
		                    <div class="alert alert-danger fade in text-left m-t-10">
		                        @foreach ($errors->all() as $error)
		                            <p><i class="fa fa-warning"></i> {{ $error }}</p>
		                        @endforeach
		                    </div>

		                @endif
		                @if(Session::get('success'))

		                    <div class="alert alert-success fade in text-left m-t-10">
		                        <p><i class="fa fa-check"></i> {{ Session::get('success') }}</p>
		                    </div>
		                @endif
		            </div>
		            <div class="form-group">
					    <label for="otaku-name">{{ trans('frontend.contact_us.name') }}</label>
					    <input type="text" class="form-control" id="otaku-name" name="name" placeholder="{{ trans('frontend.contact_us.name') }}" required>
					</div>
					<div class="form-group">
					    <label for="email-address">{{ trans('frontend.contact_us.email') }}</label>
					    <input type="email" class="form-control" id="email-address" name="email" placeholder="{{ trans('frontend.contact_us.email') }}" required>
					</div>
					<div class="form-group">
					    <label for="email-address">{{ trans('frontend.contact_us.message') }}</label>
					    <textarea class="form-control vresize" rows="7" placeholder="{{ trans('frontend.contact_us.message') }}" name="message" required></textarea>
					</div>
					<button type="submit" class="btn btn-lg btn-default">{{ trans('frontend.contact_us.submit') }}</button>
		        </div>      
		    </div>

		{{ Form::close() }}
		
    </div>
</div>

@stop