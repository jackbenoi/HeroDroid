@extends('frontend.layouts.frontend')


@section('content')

<div class="card">
    
    <div class="card-block">
       
       
        <div class="text-xs-center m-b-3">
            <i class="text-success fa fa-android fa-5x"></i>
            <hr/>
            <h5>
                {{ $configuration['cms_name'] }}
            </h5>
            
        </div>

        @if(isset($is_register))
            <p>
               Create new account.
            </p>
        @else
            <p>
               Edit your information below
            </p>
        @endif

        @if($errors->has())
            <div class="alert alert-danger fade in text-left m-t-10">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                @foreach ($errors->all() as $error)
                    <p><i class="fa fa-warning"></i> {{ $error }}</p>
                @endforeach
            </div>

        @endif
        @if(Session::get('success'))

            <div class="alert alert-success fade in text-left m-t-10">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <p><i class="fa fa-check"></i> {{ Session::get('success') }}</p>
            </div>
        @endif
        @if(Session::get('error'))

            <div class="alert alert-danger fade in text-left m-t-10">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <p><i class="fa fa-check"></i> {{ Session::get('error') }}</p>
            </div>
        @endif
        {{ Form::open(['accept-charset'=>'UTF-8', 'url' => $url, 'method' => 'POST']) }}
            <fieldset class="form-group">
                <label for="exampleInputEmail1">
                Firstname
                </label>
                <input type="text" class="form-control" name="first_name" placeholder="Firstname" value="{{ @$userDetail->first_name }}">
            </fieldset>
            <fieldset class="form-group">
                <label for="exampleInputEmail1">
                Lastname
                </label>
                <input type="text" class="form-control" name="last_name" placeholder="Lastname" value="{{ @$userDetail->last_name }}">
            </fieldset>
            <fieldset class="form-group">
                <label for="exampleInputEmail1">
                Email address
                </label>
                <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ @$userDetail->email }}">
            </fieldset>

            <fieldset class="form-group">
                <label for="exampleInputEmail1">
                Username
                </label>
                <input type="text" class="form-control" name="username" placeholder="Username" value="{{ @$userDetail->username }}">
            </fieldset>

            <fieldset class="form-group">
                <label for="exampleInputEmail1">
                Password
                </label>
                <input type="password" class="form-control" name="password" placeholder="*********" >
            </fieldset>

            @if($configuration['enable_recaptcha'] == 'yes')
                <fieldset class="form-group">
                    <div class="g-recaptcha" data-sitekey="{{ $configuration['recaptcha_site_key'] }}"></div>
                </fieldset>
            @endif


            @if($isDemo)
                 @include('backend.layouts.common.demo-btn')
            @else

                @if(isset($is_register))
                    <button type="submit" class="btn btn-success">
                        Create Account
                    </button>
                @else
                    <input type="hidden" class="form-control" name="token_id" value="{{ @$userDetail->id }}" >
                    <button type="submit" class="btn btn-success">
                        Update
                    </button>
                @endif
            @endif
        
     {{ Form::close() }}
        
    </div>
</div>
@stop

@section('scripts')
    
    @if($configuration['enable_recaptcha'] == 'yes')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
@stop