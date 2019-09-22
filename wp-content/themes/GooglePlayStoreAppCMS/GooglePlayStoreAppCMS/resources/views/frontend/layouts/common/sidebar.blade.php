<div class="card">
    <div class="card-block">
        {{-- Sidebar Show Ads Here --}}
        <a class="btn btn-md btn-danger btn-block animated infinite pulse" href="{{ route('frontend.submitapps.index') }}" title="{{ trans('frontend.common.submit_apps') }}">
            <i class="fa fa-android"></i> {{ trans('frontend.common.submit_apps') }}
        </a>
    </div>
</div>

<div>
    {!! showAds('sidebar') !!}
</div>

@include('frontend.layouts.common.partials.featured-category')

@if(isset($popularCategories) && count($popularCategories) > 0)
    <div class="card">
        <div class="card-header">
            <div>
                <a href="#"><i class="fa fa-eye">
                              </i> {{ trans('frontend.common.most_popular_cat') }}</a>
            </div>
        </div>
        <div class="card-block">
                <ul class="list-unstyled text-left">
                    @foreach($popularCategories as $cat)
                        <li>
                            <a href="{{  $cat->category->detail_url }}" class="btn btn-block btn-icon btn-outline-success m-r-xs m-b-xs">
                              <i class="fa fa-{{ @$cat->category->icon != '' ? $cat->category->icon : 'android' }}"></i> <span>
                                {{ $cat->category->title }} 
                              </span> <small>({{ countFormat($cat->views) }})</small>
                            </a>
                        </li>
                    @endforeach
                </ul>
        </div>
    </div>
@endif


@if(!isset($is_index))
    @if(isset($popularApps) && count($popularApps) > 0)
        <div class="card">
            <div class="card-header">
                <div>
                    <i class="fa fa-eye"></i> {{ trans('frontend.common.most_popular_apps') }}
                </div>
            </div>
            <div class="card-block">
                @foreach($popularApps as $item)
                    <div class="card card-block">
                        <div class="profile-timeline-header">
                            <a href="{{ $item->app->detail_url }}" title="{{ $item->app->title }}" class="profile-timeline-user">
                                <img  src="{{ isset($item->app->appImage) ? $item->app->appImage->image_link : $item->app->image_url }}" alt="{{ $item->app->title }}" class="img-rounded">
                            </a>
                            <div class="profile-timeline-user-details">
                                  <a href="{{ $item->app->detail_url }}" title="{{ $item->app->title }}" class="bold">
                                    {{ $item->app->title }}
                                  </a>
                                <br>
                                <span class="text-muted small">
                                    {{ trans('frontend.app_detail.views') }} ({{ countFormat($item->views) }})
                                </span>
                            </div>
                            <div class="profile-timeline-content">
                                <p>
                                    {{ truncate($item->app->description,70) }}
                                </p>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    @endif
@endif

