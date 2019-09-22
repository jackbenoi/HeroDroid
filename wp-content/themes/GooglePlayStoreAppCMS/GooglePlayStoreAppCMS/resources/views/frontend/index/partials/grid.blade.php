@if(isset($items) && !$items->isEmpty())
    @foreach($items as $item)
        <div class="col-xs-6 col-sm-4 col-md-2">
            <div class="card">
            	<a href="{{ $item->detail_url }}" title="{{ $item->title }}">
                	<img  class="card-img-top img-fluid" src="{{ firefoxImage(isset($item->appImage) ? $item->appImage->image_link : $item->image_url) }}" alt="{{ $item->title }}" style="margin: 0 auto;padding: 5px;border-radius: 15px;">
                </a>
                <div class="card-block" style="padding: .5rem;background: #fff;white-space: nowrap;overflow: hidden;width: 95%;">
                    <p>
                        <a href="{{ $item->detail_url }}" title="{{ $item->title }}"><strong>{{ $item->title }}</strong></a>
                    </p>
                    <span class="my-ratings" data-ratings='{"max": 5, "value": "{{ $item->ratings }}" }'></span><br/>
                    <small class="pull-left">
                      	<a href="{{ $item->developer_link }}" style="color: #263238;" title="{{ $item->developer_name }}">
                       		{{ truncate($item->developer_name,12) }}
                      	</a>
                    </small>
                    <small class="text-success pull-right" >
                      	<a href="{{ $item->detail_url }}" title="{{ $item->title }}"> <i class="fa fa-download"></i></a>
                    </small>
                </div>
            </div>
        </div>
    @endforeach

@else
    @include('frontend.index.partials.no-setup')
@endif