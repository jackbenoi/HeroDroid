<div class="card">
    <div class="card-header">
        <div class="pull-left">
            <strong><i class="fa fa-list"></i> Featured Categories</strong>
        </div>

        <div class="pull-right">
            <ul class="nav nav-tabs card-header-tabs">
                @if(isset($featuredCategories) && count($featuredCategories) > 0)
                    @foreach($featuredCategories as $index => $pCat)

                        {{--*/ $active = ($pCat == reset($featuredCategories)) ? 'active' : ''; /*--}}
                        <li class="nav-item">
                            <a data-toggle="tab" role="tab" class="nav-link {{ $active }}" href="#{{ $index }}">{{ $pCat['title'] }}</a>
                        </li>
                    @endforeach
                @else
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Setup Category</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="card-block">

        <!-- Tab panes -->
        <div class="tab-content">
            @if(isset($featuredCategories) && count($featuredCategories) > 0)
                @foreach($featuredCategories as $index => $pCat)
                    {{--*/ $active = ($pCat == reset($featuredCategories)) ? 'active' : ''; /*--}}
                    <div class="tab-pane  {{ $active }}" id="{{ $index }}" role="tabpanel">
                        <ul class="list-unstyled">
                        @foreach($pCat['categories'] as $cat)
                            <li>
                                <a href="{{ $cat['detail_url'] }}" class="btn btn-block btn-icon btn-outline-success m-r-xs m-b-xs">
                                  <i class="fa fa-{{ @$cat['icon'] != '' ? @$cat['icon'] : 'android' }}"></i>
                                  <span>
                                    {{ $cat['title'] }}
                                  </span> 
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                 @endforeach
            @endif
        </div>

    </div>
</div>