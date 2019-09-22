@if(isset($newestItemLists) && !$newestItemLists->isEmpty())
    <div class="card">
        <div class="card-header">
            <div class="pull-left">
                {{ trans('frontend.index.newly_added') }}
            </div>

            @if(!isset($isViewAll))
            <div class="pull-right">
                <a href="{{ route('frontend.index.newest-app') }}" > {{ trans('frontend.common.see_more') }}</a>
            </div>
            @endif
        </div>
        <div class="card-block">
            @include('frontend.index.partials.grid',['items' => $newestItemLists])
        </div>
    </div>

@else
    @include('frontend.index.partials.no-setup')
@endif





@if(isset($newestSubmittedAppLists) && !$newestSubmittedAppLists->isEmpty())
    <div class="card">
        <div class="card-header">
            <div class="pull-left">
                {{ trans('frontend.index.newly_submit') }}
            </div>
        </div>
        <div class="card-block">
            @include('frontend.index.partials.grid',['items' => $newestSubmittedAppLists])
        </div>
    </div>
@endif