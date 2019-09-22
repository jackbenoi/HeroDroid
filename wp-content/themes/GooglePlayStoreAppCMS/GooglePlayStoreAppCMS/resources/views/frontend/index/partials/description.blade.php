<div class="card">
    <div class="card-header">
        <div class="pull-left">
            <h5>{{ trans('frontend.common.description') }}</h5>
        </div>
    </div>
    <div class="card-block">
        <div class="row no-gutters">
            <div class="col-12 col-sm-12 col-md-12" >
                <p class="description">
                    {!! nl2br(@$detail->description) !!}
                </p>
            </div>
        </div>
    </div>

</div>