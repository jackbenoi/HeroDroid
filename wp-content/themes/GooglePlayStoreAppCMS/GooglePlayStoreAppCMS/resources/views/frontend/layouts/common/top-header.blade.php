<nav class="header navbar">
    <div class="header-inner">
        <div class="navbar-item navbar-spacer-right brand hidden-lg-up">
            <!-- toggle offscreen menu -->
            <a href="javascript:;" data-toggle="sidebar" class="toggle-offscreen">
                <i class="material-icons">menu</i>
            </a>
            <!-- /toggle offscreen menu -->
            <!-- logo -->
            <a class="brand-logo hidden-xs-down">
                <img src="{{ $image_logo }}" class="avatar img-circle" alt="user" title="user">
            </a>
            <!-- /logo -->
        </div>
        @if($image_logo)
            <a class="brand-logo navbar-item navbar-spacer-right navbar-heading hidden-md-down" href="{{ url('/') }}">
                <img src="{{ $image_logo }}" class="avatar" style="max-height: 30px;" alt="{{ @$configuration['cms_name'] }}" title="{{ @$configuration['cms_name'] }}">
            </a>
        @else
            <a class="navbar-item navbar-spacer-right navbar-heading hidden-md-down" href="{{ url('/') }}">
                <span>{{ @$configuration['cms_name'] }}</span>
            </a>
        @endif
        @include('frontend.layouts.common.partials.search')
        <div class="navbar-item nav navbar-nav">

            @if(isset($dbLocale))
                <div class="nav-item nav-link dropdown">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <span><i class="fa fa-language"></i> {{ trans('frontend.common.translate') }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach($dbLocale as $locale)
                            <a class="dropdown-item text-uppercase" href="{{ route('frontend.translate',$locale) }}">{{ $locale }}</a>
                        @endforeach
                    </div>

                </div>
            @endif
            
            	@if(isset($userDetail))
	                <div class="nav-item nav-link dropdown">
	                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
	                        <span> {{ $userDetail->full_name }}</span> <i class="fa fa-chevron-down"></i>
	                    </a>
	                    <div class="dropdown-menu dropdown-menu-right">
                            @if(isset($isAdmin) && $isAdmin)
	                        <a class="dropdown-item" href="{{ route('backend.index.index') }}"><i class="fa fa-lock"></i> {{ trans('frontend.header.admin') }}</a>
                            @endif
	                        @if(isset($isSuperAdmin) && $isSuperAdmin)
	                            <a class="dropdown-item" href="{{ route('backend.index.index') }}"><i class="fa fa-lock"></i> {{ trans('frontend.header.admin') }}</a>
	                        @endif
	                        @if(isset($configuration['enable_submit_apps']))
	                            <a class="dropdown-item" href="{{ route('frontend.submitapps.list') }}"><i class="fa fa-android"></i> {{ trans('frontend.header.submit_apps') }}</a>
	                        @endif
	                        <a class="dropdown-item" href="{{ route('frontend.profile') }}"><i class="fa fa-user"></i> {{ trans('frontend.header.my_profile') }}</a>
	                        <a class="dropdown-item" href="{{ route('frontend.logout') }}"><i class="fa fa-sign-out"></i> {{ trans('frontend.header.logout') }}</a>
	                    </div>
	                </div>
                @else
                    <div class="nav-item nav-link dropdown">
                        <a href="{{ route('frontend.login') }}" class="dropdown-toggle">
                            <i class="fa fa-user"></i> <span> {{ trans('frontend.header.login_register') }}</span>
                        </a>
                    </div>
                @endif
        </div>
    </div>
</nav>