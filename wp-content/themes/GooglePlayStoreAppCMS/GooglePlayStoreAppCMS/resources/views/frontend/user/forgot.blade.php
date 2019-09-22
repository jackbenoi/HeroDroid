@extends('frontend.layouts.frontend')


@section('content')

<div class="card">
    
    <div class="card-block">
       
       {{ Form::open(['accept-charset'=>'UTF-8', 'url' => $url, 'method' => 'POST']) }}
        <div class="text-xs-center m-b-3">
            <i class="text-success fa fa-android fa-5x"></i>
            <hr/>
            <h5>
                {{ $configuration['cms_name'] }}
            </h5>
            <p class="text-muted">
                Forgot Password
            </p>
        </div>
        {{-- Login Error Message Response --}}
        @if($errors->has())

            <div class="alert alert-danger fade in text-left">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                @foreach ($errors->all() as $error)
                    <p><i class="fa fa-warning"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif
        {{-- Login Success Message Response --}}
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
        <fieldset class="form-group">
            <label for="username">
            Enter your username
            </label>
            <input type="text" class="form-control form-control-md" name="login" placeholder="Enter your username"/>
        </fieldset>
        <fieldset class="form-group">
            <label for="username">
            Or
            </label>
        </fieldset>
        <fieldset class="form-group">
            <label for="email">
            Enter your email
            </label>
            <input type="text" class="form-control form-control-md" name="email" placeholder="Enter your email" />
        </fieldset>
        
        <button class="btn btn-success btn-md" type="submit">
            <i class="fa fa-user"></i> Reset Password
        </button>
       
      
        <div class="divider">
          <hr/>
        </div>

       
     {{ Form::close() }}
        
    </div>
</div>
@stop