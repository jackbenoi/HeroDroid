<div class="content-footer">
    <nav class="footer-right">
        <ul class="nav">
            <li>
                <a href="{{ route('frontend.contact') }}"><i class="fa fa-envelope"></i> {{ trans('frontend.contact_us.title') }}</a>
            </li>
            <li class="hidden-md-down">
                <a href="{{ route('frontend.rss') }}"  title="{{ trans('frontend.index.rss_feeds') }}">
                    <i class="fa fa-rss"></i>  {{ trans('frontend.index.rss_feeds') }}
                </a>
            </li>
            <li class="hidden-md-down">
                <a href="{{ url('sitemap/sitemap.xml') }}"  title="{{ trans('frontend.index.sitemap') }}">
                    <i class="fa fa-sitemap"></i>  {{ trans('frontend.index.sitemap') }}
                </a>
            </li>
        </ul>
    </nav>
    <nav class="footer-left">
        <ul class="nav">
            <li>
                <a href="{{ url('/') }}">
                    <strong>
                    {!! trans('frontend.common.copyright') !!} <i class="fa fa-copyright"></i> {{ Carbon\Carbon::now()->format('Y') }} - {{ $configuration['site_title'] }}</strong>
                </a>
            </li>

            @if(isset($pages))
                @foreach($pages as  $page)
                    <li class="hidden-md-down">
                        <a href="{{ $page['detail_url'] }}" title="{{ $page['title'] }}">{{ $page['title'] }}</a>
                    </li>
                @endforeach
            @endif
            <li class="hidden-md-down">
                <a href="{{ route('frontend.index.report-app') }}"  title="{{ trans('frontend.report_title') }}">
                    <i class="fa fa-warning"></i>  {{ trans('frontend.report_title') }}
                </a>
            </li>
            @if(isset($configuration['enable_submit_apps']))
                <li>
                    <a href="{{ route('frontend.submitapps.index') }}" title="{{ trans('frontend.common.submit_apps') }}">
                        <i class="fa fa-android"></i> {{ trans('frontend.common.submit_apps') }}
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>