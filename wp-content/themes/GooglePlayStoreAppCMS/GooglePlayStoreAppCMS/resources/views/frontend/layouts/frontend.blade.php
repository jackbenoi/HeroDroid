<!doctype html>
<html lang="en">
    <head>
        
        @include('frontend.layouts.common.meta-tags')
        <link rel="stylesheet" href="{{ elixit('assets/css/app.css') }}"/>
        <link rel="stylesheet" href="{{ elixit('assets/css/common.css') }}"/>

        @if(isset($configuration['enable_rtl_support']) && $configuration['enable_rtl_support'] == 'yes')
            <link rel="stylesheet" href="{{ elixit('assets/css/rtl/app.css') }}"/>
            <link rel="stylesheet" href="{{ elixit('assets/css/rtl/common.css') }}"/>
        @endif
        
        @yield('stylesheets')

        @if($isDemo)
            <style type="text/css">
                .float{
                    position: fixed;
                    width: 200px;
                    height: 65px;
                    bottom: 40px;
                    right: 23px;
                    background-color: #d26d54;
                    color: #FFF;
                    border-radius: 0px;
                    text-align: center;
                    box-shadow: 2px 2px 3px #999;
                }

                .my-float{
                    font-size:24px;
                    margin-top:18px;
                }

                a.float + div.label-container {
                    visibility: hidden;
                    opacity: 0;
                    transition: visibility 0s, opacity 0.5s ease;
                }

                a.float:hover + div.label-container{
                    visibility: visible;
                  orphanspacity: 1;
                }


                a.float:hover {
                    text-decoration: none;
                    color: #f5f3f3;
                }
            </style>
        @endif

        @if(isset($configuration['custom_css']) && $configuration['custom_css'] != '')
            <style type="text/css">
                {{ $configuration['custom_css'] }}
            </style>
        @endif

        @include('frontend.layouts.common.analytics')
    </head>
    <body>
        <div class="app skin-1 fixed-header horizontal">
            <!-- content panel -->
            <div class="main-panel">
                <!-- top header -->
                @include('frontend.layouts.common.top-header')
                <!-- /top header -->
                <!-- menu header -->
                @include('frontend.layouts.common.menu-header')
                <!-- /menu header -->
                <!-- main area -->
                <div class="main-content">
                    <div class="content-view {{ (isset($is_index)) ? 'is_index' : 'is_detail' }}">

                        <div class="col-lg-8">
                            
                            <div class="card text-center">
                                <div class="card-block">
                                    {!! showAds('leaderboard') !!}
                                </div>
                            </div>
                            @yield('content')

                            @if(isset($is_index))
                                <div class="card text-center">
                                    <div class="card-block">
                                        {!! showAds('footer_ads') !!}
                                    </div>
                                </div>
                            @endif
                            
                        </div>
                        <div class="col-lg-4">
                            @include('frontend.layouts.common.sidebar')
                        </div>
                        
                    </div>
                    <!-- bottom footer -->
                    @include('frontend.layouts.common.footer')
                    <!-- /bottom footer -->
                </div>
                <!-- /main area -->
            </div>
            <!-- /content panel -->
        </div>

        @if( $isDemo )
            <a href="https://codecanyon.net/item/google-play-app-store-cms/20614679?ref=ianthonypillos" class="float" title="@yield('site_title',@$configuration['site_title'])">
                <i class="fa fa-usd my-float"></i><u>BUY MY SCRIPT</u>
            </a>
        @endif
        @include('frontend.layouts.common.vars')
        <script type="text/javascript" src="{{ elixit('assets/js/app.js') }}"></script>
        <script type="text/javascript" src="{{ elixit('assets/js/frontend/search.js') }}"></script>
        
        @yield('scripts')

        <script type="text/javascript">
            $(document).ready(function() {
                $('.my-ratings').ratings('disable');
            });
        </script>
        @if(isset($configuration['custom_js']) && $configuration['custom_js'] != '')
            <script type="text/javascript">
                {{ $configuration['custom_js'] }}
            </script>
        @endif

    </body>
</html>