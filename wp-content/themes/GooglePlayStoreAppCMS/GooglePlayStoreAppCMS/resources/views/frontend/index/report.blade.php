@extends('frontend.layouts.frontend')


@section('site_title')
{{ trans('frontend.report_title') }} | {{ @$configuration['site_title'] }}@stop


@section('meta_description'){{ trans('frontend.report_title') }}@stop


@section('content')

<div class="card">
    <div class="card-header">
        <div class="pull-left">
            <a href="{{ url('/') }}">{{ trans('frontend.common.home') }} <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
            <a href="#">{{ trans('frontend.report_title') }} </a>
        </div>
       
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

    @if(Session::get('report-message'))
        <div class="alert alert-success fade in text-left">
           {{ session('report-message') }}
        </div>
    @endif

    {{ Form::open(['accept-charset'=>'UTF-8','method' => 'POST','url' => route('fd.report.app') ]) }}
    <div class="card-block">

        <fieldset class="form-group">
            <label for="content_name">
            @if($app_id) {{ trans('frontend.report_content_name') }} @else {{ trans('frontend.report_content_url') }} @endif
            </label>

            @if(isset($detail->app_id))
                <input type="text" class="form-control " readonly name="content_name" placeholder="Content Name" value="{{ $detail->title }}">
                <input type="hidden" class="form-control " readonly name="app_id" value="{{ $detail->app_id }}">
            @else
                <input type="text" class="form-control " name="content_name" placeholder="Ex. {{ route('frontend.index.detail',str_slug('facebook')).'?id=com.facebook.katana' }}" >
            @endif
        </fieldset>
        <fieldset class="form-group">
            <label for="your_name">
                {{ trans('frontend.common.name') }}
            </label>
            <input type="hidden" class="form-control" name="token_id" value="{{ @$userDetail->id}}" >
            <input type="text" class="form-control" name="name" value="{{ @$userDetail->full_name}}" placeholder="{{ trans('frontend.common.name_placeholder') }}">
        </fieldset>


        <fieldset class="form-group">
            <label for="your_name">
            {{ trans('frontend.common.email_add') }}
            </label>
            <input type="text" class="form-control" name="email_address" value="{{ @$userDetail->email }}" placeholder="{{ trans('frontend.common.email_add_placeholder') }}">
        </fieldset>

        <fieldset class="form-group">
            <label for="your_name">
            {{ trans('frontend.report_heading') }}:
            </label>
            <p class="col-md-12">
                @foreach(trans('frontend.report_reasons') as $reason)
                    <label>
                        <input type="checkbox" value="{{ $reason }}" name="report_reason[]"> 
                        {{ $reason }}
                    </label>
                    <br/>
                @endforeach
            </p>
        </fieldset>

        <fieldset class="form-group">
            <label for="message">
            {{ trans('frontend.common.message') }}
            </label>
            <textarea class="form-control" name="message" rows="3" placeholder="{{ trans('frontend.report_message') }}"></textarea>
        </fieldset>
    </div>

    <div class="card-footer text-muted">
        <div class="row no-gutters">
            <div class="col-12 col-md-6" style="text-align: left;">
                <button type="submit" class="btn btn-sm btn-success">
                    <i class="fa fa-flag-o"></i> {{ trans('frontend.report_btn') }}
                </button>
            </div>
        </div>
    </div>

    </form>
</div>

@stop