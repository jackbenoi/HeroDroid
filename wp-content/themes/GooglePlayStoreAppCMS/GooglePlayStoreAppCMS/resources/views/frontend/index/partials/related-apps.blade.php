<div class="card">
    <div class="card-header">
        <div class="pull-left">
            <h5>{{ trans('frontend.app_detail.related_apps') }}</h5>
        </div>
    </div>
    <div class="card-block">
        <div class="row no-gutters">
            @include('frontend.index.partials.grid',['items' => $relatedApps])
        </div>
    </div>

</div>