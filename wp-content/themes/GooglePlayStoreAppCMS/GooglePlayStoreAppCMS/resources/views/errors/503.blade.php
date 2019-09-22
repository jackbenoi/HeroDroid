<!doctype html>
<html lang="en">
    <head>
        
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1"/>
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="application-name" content="500 Error Page">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="500 Error Page">
        <meta name="theme-color" content="#4C7FF0">
        <meta name="_token" content="{{ csrf_token() }}">

        <meta name="keywords" content="@yield('meta_keywords',@$configuration['site_keywords'])"/>
        <meta name="description" content="@yield('meta_description',@$configuration['site_description'])"/>
        <meta name="author" content="@yield('author',@$configuration['site_author'])"/>

        <title>Maintenance Mode On - Be Right Back</title>

        <link rel="stylesheet" href="{{ elixit('assets/css/app.css') }}"/>
        <link rel="stylesheet" href="{{ elixit('assets/css/common.css') }}"/>
        
        @yield('stylesheets')

    </head>
    <body>
        <div class="app skin-1 fixed-header horizontal">
            <!-- content panel -->
            <div class="main-panel">
                <!-- top header -->
                @include('frontend.layouts.common.top-header')
                <!-- /top header -->
               
                <!-- main area -->
                <div class="main-content">
                    <div class="content-view">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="">Be Right Back</a>
                                </div>
                                <div class="card-block">
                                    <h5 class="text-center">Maintenance Mode On</h5>
                                    <p class="text-xs-center">Please check back in a couple of minutes.</p>
                                   <hr />
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <!-- /main area -->
            </div>
            <!-- /content panel -->
        </div>
        
        <script type="text/javascript" src="{{ elixit('assets/js/app.js') }}"></script>

        @yield('scripts')
    </body>
</html>