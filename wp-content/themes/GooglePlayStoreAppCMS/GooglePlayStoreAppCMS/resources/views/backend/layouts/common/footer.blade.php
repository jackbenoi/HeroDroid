<div class="content-footer">
    
    <nav class="footer-left">
        <ul class="nav">
            <li>
                <a href="{{ url('/') }}">
                    <strong>
                    {!! trans('frontend.common.copyright') !!} <i class="fa fa-copyright"></i> {{ Carbon\Carbon::now()->format('Y') }} - {{ $configuration['site_title'] }}</strong>
                </a>
            </li>
        </ul>
    </nav>
</div>