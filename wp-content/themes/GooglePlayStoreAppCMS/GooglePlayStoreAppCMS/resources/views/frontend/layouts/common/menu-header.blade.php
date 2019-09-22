<nav class="header-secondary navbar bg-faded shadow">
    <div class="navbar-collapse">
        <a class="navbar-heading hidden-md-down"  href="{{ url('/') }}">
            <span>{{ $configuration['cms_description'] }}</span>
        </a>
        <ul class="nav navbar-nav pull-xs-right">
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('/') }}"><i class="fa fa-home"></i> {{ trans('frontend.common.home') }}</a>
            </li>

            @if(isset($parentCatCollections))
                @foreach($parentCatCollections as $category)
                    <div class="nav-item nav-link dropdown">
                        <i class="fa fa-{{ @$category->icon != '' ? $category->icon : 'android' }}"></i> <a href="{{ $category->detail_url}}" title="{{ $category->title }}"> {{ $category->title }}</a>
                    </div>
                @endforeach
            @endif

        </ul>
    </div>
</nav>