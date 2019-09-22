@if(isset($featuredItems) && !$featuredItems->isEmpty())
    <div class="card">
        <div class="card-header">
            <div class="pull-left">
                <a href="">{{ trans('frontend.index.editors_pick') }} <i class="fa fa-angle-double-right"></i></a>
            </div>
            @if(!isset($isViewAll))
            <div class="pull-right">
                <a href="{{ route('frontend.index.editors-pick') }}" > {{ trans('frontend.common.see_more') }}</a>
            </div>
            @endif
        </div>
        <div class="card-block">
            @include('frontend.index.partials.grid',['items' => $featuredItems])
        </div>
        @if(isset($isViewAll))
            <div>
                @include('pagination.default', ['paginate' => $featuredItems])
            </div>
        @endif
    </div>
@endif