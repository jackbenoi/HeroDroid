<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content=""/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1"/>
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="application-name" content="Milestone">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="Milestone">
        <meta name="theme-color" content="#4C7FF0">
        <title>@yield('site_title',@$configuration['site_title'])</title>
       
        <link rel="stylesheet" href="{{ elixit('assets/css/app.css') }}"/>
        <style type="text/css">
            .app {
                background: #dadada;
            }
        </style>
    </head>
    <body>
        <div class="app no-padding no-footer layout-static">
            <div class="session-panel">
                <div class="session">
                    <div class="session-content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        
        <script type="text/javascript" src="{{ elixit('assets/js/app.js') }}"></script>
    </body>
</html>