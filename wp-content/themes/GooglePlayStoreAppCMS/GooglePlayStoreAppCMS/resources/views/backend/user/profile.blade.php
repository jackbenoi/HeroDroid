@extends('backend.layouts.backend')


@section('content')

<div class="card">
    <div class="card-header no-bg b-a-0">
        <h2>Profile Page</h2>
    </div>
    <div class="card-block">
        <p>
           Edit your information below
        </p>

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
        {{ Form::open(['accept-charset'=>'UTF-8', 'url' => route('backend.profile.update') , 'method' => 'POST']) }}
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


            @if($isDemo)
                 @include('backend.layouts.common.demo-btn')
            @else
                <input type="hidden" class="form-control" name="token_id" value="{{ @$userDetail->id }}" >
                <button type="submit" class="btn btn-primary">
                    Update
                </button>
            @endif
            
        </form>
    </div>
</div>

@stop