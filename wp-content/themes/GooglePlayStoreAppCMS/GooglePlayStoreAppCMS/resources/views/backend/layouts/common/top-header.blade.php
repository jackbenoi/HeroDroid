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
                <img src="images/logo_white.png" alt="logo"/>
            </a>
            <!-- /logo -->
        </div>
        @if($image_logo)
            <a class="brand-logo navbar-item navbar-spacer-right navbar-heading hidden-md-down" target="_blank" href="{{ url('/') }}">
                <img src="{{ $image_logo }}" class="avatar" style="max-height: 25px;" alt="{{ @$configuration['cms_name'] }}" title="{{ @$configuration['cms_name'] }}">
            </a>
        @else
            <a class="navbar-item navbar-spacer-right navbar-heading hidden-md-down" href="{{ url('/') }}">
                <span>{{ @$configuration['cms_name'] }}</span>
            </a>
        @endif
        @if(isset($userDetail))
            <div class="navbar-item nav navbar-nav">
                <div class="nav-item nav-link dropdown">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i> <span> Welcome, {{ $userDetail->full_name }} </span> <i class="fa fa-caret-down"></i> 
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('backend.profile') }}">{{ trans('frontend.header.my_profile') }}</a>
                        <a class="dropdown-item" href="{{ route('backend.logout') }}">{{ trans('frontend.header.logout') }}</a>
                    </div>
                </div>
                
            </div>
        @endif

    </div>
</nav>