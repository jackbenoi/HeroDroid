@extends('backend.layouts.login')


@section('content')

<div class="card card-block form-layout">

    {{ Form::open(['accept-charset'=>'UTF-8', 'url' => $url, 'method' => 'POST']) }}
        <div class="text-xs-center m-b-3">
            <i class="text-success fa fa-android fa-5x"></i>
            <hr/>
            <h5>
                Welcome to APPMarketCMS\Admin
            </h5>
            <p class="text-muted">
                Sign in with your username & password to continue.
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
        @if(Session::get('error-message'))

            <div class="alert alert-danger fade in text-left m-t-10">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <p><i class="fa fa-warning"></i> {{ Session::get('error-message') }}</p>
            </div>

        @endif
        <fieldset class="form-group">
            <label for="username">
            Enter your username
            </label>
            <input type="text" class="form-control form-control-lg" name="login" placeholder="username" required/>
        </fieldset>
        <fieldset class="form-group">
            <label for="password">
            Enter your password
            </label>
            <input type="password" class="form-control form-control-lg" name="password" placeholder="********" required/>
        </fieldset>
        
        <button class="btn btn-primary btn-block btn-lg" type="submit">
        Login
        </button>
        
     {{ Form::close() }}
</div>

@stop