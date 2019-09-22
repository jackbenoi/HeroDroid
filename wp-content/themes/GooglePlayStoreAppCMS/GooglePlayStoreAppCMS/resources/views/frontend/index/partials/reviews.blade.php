<div class="card">
    <div class="card-header">
        <div class="pull-left">
            <h5>{{ trans('frontend.common.user_review') }}</h5>
        </div>
    </div>
    <div class="card-block">
        <div class="row no-gutters">
            @if(isset($detail->histogram) && !$detail->histogram->isEmpty())
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 rating">
                        <span class="rating-num">{{ $detail->ratings }}</span>
                            <div class="rating-stars">
                              @for($i=1;$i<=5;$i++)
                                <span><i class="{{ $detail->ratings >= $i ? 'active' : '' }} icon-star"></i></span>
                              @endfor
                            </div>
                        <div style="position: relative;right: 42px;">
                          <span class="my-ratings" data-ratings='{"max": 5, "value": "{{ $detail->ratings }}" }'></span><br/>

                        </div>
                        <span><i class="fa fa-users"></i> {{ $detail->ratings_total }} {{ trans('frontend.app_detail.total') }}</span>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 histo">
                        @foreach(@$detail->histogram as $histo)

                          {{--*/ 
                            
                            switch ($histo->num) {
                              case '5':
                                  $className = 'five';
                                  break;
                              case '4':
                                  $className = 'four';
                                  break;
                              case '3':
                                  $className = 'three';
                                  break;
                              case '2':
                                  $className = 'two';
                                  break;
                              case '1':
                                  $className = 'one';
                                  break;
                              default:
                                  $className = '';
                                  break;
                          }

                          /*--}}
                          <div class="{{ $className }} histo-rate">
                            <span class="histo-star">
                              <i class="active icon-star"></i> {{ $histo->num }}
                            </span>
                            <span class="bar-block">
                              <span id="bar-{{ $className }}" class="bar" style="{{ $histo->bar_length }}">
                                <span>{{ $histo->bar_number }}</span>&nbsp;
                              </span> 
                            </span>
                          </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="col-12 col-sm-12 col-md-12" id="reviews">
                
                @if(isset($detail->reviews) && !$detail->reviews->isEmpty())

                    @foreach($detail->reviews as $key => $review)

                       <div class="profile-timeline-header">
                            <a href="{{ $detail->detail_url }}" title="{{ $review->author_name }}" class="profile-timeline-user">
                                <img  src="{{ $review->image_url }}" alt="{{ $review->author_name }}" class="img-rounded">
                            </a>
                            <div class="profile-timeline-user-details">
                                  <a href="{{ $detail->detail_url }}" title="{{ $review->author_name }}" class="bold">
                                    {{ $review->author_name }}
                                  </a>
                                <br>
                                <span class="text-muted small">
                                    {{ $review->published_at }}
                                </span>
                            </div>
                            <div class="profile-timeline-content">
                                <p>
                                    {!! nl2br($review->comments) !!}
                                </p>
                            </div>
                        </div>
                    @endforeach

                @else
                    <div class="card panel panel-default m-b-xs ">
                        <div class="card-header panel-heading" role="tab" id="no-result">
                            <h6 class="panel-title m-a-0 text-center">
                                {{ trans('frontend.common.no_review') }}
                            </h6>
                        </div>
                    </div>

                @endif

            </div>
        </div>
    </div>

</div>

{{-- <div class="score-container" itemprop="aggregateRating" itemscope="itemscope" itemtype="http://schema.org/AggregateRating"> 
  <meta content="{{ $detail->ratings }}" itemprop="ratingValue">
  <meta content="{{  $detail->ratings_total }}" itemprop="ratingCount"> 
</div> --}}