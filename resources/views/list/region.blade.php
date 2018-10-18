@if($regionSelect != 'default' && $regionSelect == 'all')
    <h2 class="uk-heading-line uk-text-center">All Regions</h2>
@elseif($regionSelect != '' && $regionSelect != 'all')
    <h2 class="uk-heading-line uk-text-center">{{$regionSelect}} Region</h2>
@endif

@if($regionSelect == 'default')
    <p class="uk-text-center uk-margin-top uk-text-muted">There are {{ $totalCount }} wineries waiting to be discovered.</p>
@elseif($regionSelect != '')
    <p class="uk-text-center uk-text-muted">
        @if($regionCount == 1)
            1 winery was found.</p>
        @elseif($regionCount > 1) 
            {{$regionCount}} wineries were found.</p>
        @elseif($regionCount < 1) 
            No wineries were found.</p>
        @endif
@endif


{{ $regionWineries->appends(request()->except('page'))->links() }}
    
@if($regionCount <= 1)
    <div class="uk-child-width uk-margin-remove" uk-grid>
@else
    <div class="uk-child-width-1-2@l uk-padding-small uk-margin-remove" uk-grid>
@endif    
    @foreach($regionWineries as $winery)
        <div class="uk-card uk-box-shadow-hover-medium">
            <div class="uk-card-header uk-padding-remove">                      
                <div class="uk-flex-center" uk-grid>
                    <div>
                        <a class="uk-link-heading" title="Click for Detail View" href="/guide/winery/{{$winery->id}}">   
                            <img class="winery_logo" src="{{'/img/logos/'.$winery->logo}}" alt="{{$winery->name}} Logo">
                        </a>
                    </div>
                    <div class="uk-flex uk-flex-middle">    
                        <div>
                            <a class="uk-link-reset" title="Click for Detail View" href="/guide/winery/{{$winery->id}}">
                                <h2 class="uk-card-title uk-display-inline uk-margin-remove-bottom uk-padding-left">{{ $winery->name }}
                                </h2>
                                <span class="uk-text-muted uk-float-right" uk-icon="icon: check"></span>
                                @if( $winery->sub_name )
                                    <p class="uk-text uk-margin-remove">{{ $winery->sub_name }}</p>
                                @endif
                            </a>
                            <div class="uk-padding-top">
                                <form class="uk-form uk-display-inline" action="/favorite/add/" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{$winery->id}}">
                                <button type="submit" class="uk-button uk-button-text" title="Favorite">
                                    <span uk-icon="icon: heart"></span>
                                    <span>7</span>
                                </button>
                                
                                </form>
                                <form class="uk-form uk-display-inline" action="/wishlist/add/" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{$winery->id}}">
                                    <button type="submit" class="uk-button uk-button-text uk-margin-left" title="Wishlist">
                                        <span uk-icon="icon: star"></span>
                                        <span>60</span>
                                    </button>
                                    
                                </form>
                                <form class="uk-form uk-display-inline" action="/planner/add/" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{$winery->id}}">
                                    <button type="submit" class="uk-button uk-button-text uk-margin-left" title="Planner">
                                        <span uk-icon="icon: plus-circle"></span>        
                                        <span>14</span>
                                    </button>
                                </form>
                            </div> 
                        </div>
                    </div>
                </div>
            </div> 
            <div class="uk-card-body uk-padding-small">
                @php
                    $directionLink = 'https://www.google.com/maps/dir//'.$winery->name.', '.$winery->street.', '.$winery->city.','.$winery->state.', '.$winery->zip;
                    str_replace(' ', '+', $directionLink);
                @endphp

                <address class="uk-flex-center" uk-grid>
                    <div class="uk-text-center">
                        <a class="uk-link-reset" href="/winery/{{$winery->id}}">{{ $winery->street }}<br>
                        {{ $winery->city }}, {{ $winery->state }}, {{ $winery->zip }}</a>
                    </div>
                    <div class="uk-flex-middle">
                        @if( $winery->phone )
                            <a class="uk-link uk-display-block" href="tel:{{$winery->phone}}">
                                <span uk-icon="icon:receiver"></span>
                            {{ $winery->phone }}</a>
                        @endif
                        @if($winery->web_url)
                            <a class="uk-link uk-display-inline-block" href="{{ $winery->web_url }}" target="_blank">
                            <span uk-icon="icon:link"></span>Visit Website</a>
                        @endif
                        <a class="uk-link uk-display-block" href="{{$directionLink}}" target="_blank">
                            <span uk-icon="icon:location"></span>
                            Directions</a>
                    </div>
                </address>
            </div>
        </div>
    @endforeach
</div>