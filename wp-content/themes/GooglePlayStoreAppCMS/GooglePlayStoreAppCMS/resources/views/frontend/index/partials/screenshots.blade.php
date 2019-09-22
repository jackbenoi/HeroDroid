<div class="col-xs-12">
    <hr>
    <p class="description">
    </p>
    <h5>{{ trans('frontend.common.screenshot') }}</h5>
    <div class="row no-gutters">
        <div style="max-width: 900px;margin: 0 auto;">
            
            <div id="screenshots" class="owl-carousel owl-theme" >
                @foreach($detail->screenshots as $img)
                    <div class="item">
                        <a data-fancybox="gallery" title="{{ $detail->title }}" href="{{ $img->image_url | $img->image_link }}">
                            <img class="img-fluid" src="{{ firefoxImage($img->image_url | $img->image_link) }}" title="{{ $detail->title }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="card text-xs-center">
        <div class="card-block">
            {!! showAds('ads_content') !!}
        </div>
    </div>
</div>