{{ $wineries->appends(request()->except('page'))->links() }}

<div class="uk-child-width-1-2@l uk-grid-collapse" uk-grid>
    @foreach($wineries as $winery)
        <div class="uk-card div-border uk-padding" id="div_{{$winery->id}}">
            <div class="uk-card-header uk-padding-remove">                     
                <div class="uk-flex-center" uk-grid>
                    <div>
                        <a class="uk-link-heading" title="Click for Detail View" href="/winery/{{$winery->id}}">   
                            <img class="winery_logo" src="{{'/img/logos/'.$winery->logo}}" alt="{{$winery->name}} Logo">
                        </a>
                    </div>
                    <div class="uk-flex uk-flex-middle">    
                        <div>
                            <a class="uk-link-reset" title="Click for Detail View" href="/winery/{{$winery->id}}">
                                <h3 class="uk-card-title uk-display-inline uk-margin-remove-bottom uk-padding-left">{{ $winery->name }}
                                </h3>
                                @auth
                                    @if($visits->contains('id', $winery->id))
                                        <span class="uk-card-badge"><span class="visited" uk-icon="icon: check"></span><span class="uk-text-meta">VISITED</span></span>
                                    @endif
                                @endauth

                                @if($winery->sub_name)
                                    <p class="uk-text uk-margin-remove">{{ $winery->sub_name }}</p>
                                @endif
                            </a>
                            <div class="uk-padding-top">
                                @auth
                                    @if($favorites->contains('id', $winery->id))
                                        <form class="uk-form uk-display-inline" action="/unfavorite/{{$winery->id}}" method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete" />
                                            <button type="submit" class="favorited uk-button" title="Favorite">
                                                <span uk-icon="icon: heart"></span>
                                    @else
                                         <form class="uk-form uk-display-inline" action="/favorite" method="post">
                                            @csrf
                                            <input type="hidden" name="winery_id" value="{{$winery->id}}">
                                            <button type="submit" class="not_favorited uk-button" title="Favorite">
                                                <span uk-icon="icon: heart"></span>
                                    @endif
                                            <span>({{ $allFavorites->where('winery_id', '==', $winery->id)->count() }})</span>
                                        </button>
                                    </form>

                                    @if($wishlists->contains('id', $winery->id))
                                        <form class="uk-form uk-display-inline" action="/unwishlist/{{$winery->id}}" method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete" />
                                            <button type="submit" class="wishlisted uk-button uk-button" title="Wishlist">
                                                <span class="wishlisted" uk-icon="icon: star"></span>
                                    @else    
                                        <form class="uk-form uk-display-inline" action="/wishlist" method="post">
                                            @csrf
                                            <input type="hidden" name="winery_id" value="{{$winery->id}}">
                                            <button type="submit" class="not_wishlisted uk-button" title="Wishlist">
                                                <span class="not_wishlisted" uk-icon="icon: star"></span>
                                    @endif
                                            <span>({{ $allWishlists->where('winery_id', '==', $winery->id)->count() }})</span>
                                        </button>
                                    </form>
                                @endauth
                                @guest
                                    <div class="uk-button uk-button-small uk-margin-left not_favorited" title="Favorite">
                                        <span uk-icon="icon: heart"></span>
                                        <span>({{ $allFavorites->where('winery_id', '==', $winery->id)->count() }})</span>
                                    </div>   
                                    <div class="uk-button uk-button-small uk-margin-left not_wishlisted" title="Wishlist">
                                        <span uk-icon="icon: star"></span>
                                        <span>({{ $allWishlists->where('winery_id', '==', $winery->id)->count() }})</span>
                                    </div>
                                @endguest
                            </div> 
                        </div>
                    </div>
                </div>
            </div> 
            <div class="uk-card-body uk-padding-small">
                @php
                    $directionLink = 'https://www.google.com/maps/dir//'.$winery->name.', '.$winery->street.', '.$winery->state.', '.$winery->zip;
                @endphp

                <address class="uk-flex-center" uk-grid>
                    <div class="uk-text-left">
                        <a class="uk-link-reset" href="/winery/{{$winery->id}}">{{ $winery->street }}<br>
                        {{ $winery->city }}, {{ $winery->state }}, {{ $winery->zip }}</a>
                    </div>
                    <div class="uk-flex-middle">
                        @if( $winery->phone )
                            <div class="uk-display-block uk-margin-small-bottom">
                                <span uk-icon="icon:receiver"></span>
                                <a class="uk-link" href="tel:{{$winery->phone}}">{{ $winery->phone }}</a>
                            </div>
                        @endif
                        @if($winery->web_url)
                            <div class="uk-display-block uk-margin-small-bottom">
                                <span uk-icon="icon:link"></span>
                                <a class="uk-link" href="{{ $winery->web_url }}" target="_blank"> Visit Website</a>
                            </div>
                        @endif
                        <div class="uk-display-block uk-margin-small-bottom">
                            <span uk-icon="icon:location"></span>
                            <a class="uk-link" href="{!! str_replace(' ', '+', $directionLink) !!}" target="_blank">Directions</a>
                        </div>
                        <div class="uk-display-block uk-margin-small-bottom">
                            <span uk-icon="icon: clock"></span>
                            <a class="time-box uk-link uk-display-inline-block" uk-toggle="target: #times-modal-{{$winery->id}}">                 
                                @if($winery->time->monday = 'Closed')
                                    <span class="closed"> M
                                @elseif($winery->time->monday == 'Appointment Only')
                                    <span class="appt"> M
                                @else
                                    <span class="open"> M
                                @endif
                                </span>
                                @if($winery->time->tuesday = 'Closed')
                                    <span class="closed">Tu 
                                @elseif($winery->time->tuesday = 'Appointment Only')
                                    <span class="appt">Tu
                                @else
                                    <span class="open">Tu
                                @endif
                                </span>                           
                                @if($winery->time->wednesday === 'Closed')
                                    <span class="closed">W 
                                @elseif($winery->time->wednesday === 'Appointment Only')
                                    <span class="appt">W
                                @else
                                    <span class="open">W
                                @endif
                                </span>
                                @if($winery->time->thursday === 'Closed')
                                    <span class="Closed">Th 
                                @elseif($winery->time->thursday === 'Appointment Only')
                                    <span class="appt">Th
                                @else
                                    <span class="open">Th
                                @endif
                                </span>
                                @if($winery->time->friday === 'Closed')
                                    <span class="Closed">F 
                                @elseif($winery->time->friday === 'Appointment Only')
                                    <span class="appt">F
                                @else
                                    <span class="open">F
                                @endif
                                </span>
                                @if($winery->time->saturday === 'Closed')
                                    <span class="closed">Sa 
                                @elseif($winery->time->saturday === 'Appointment Only')
                                    <span class="appt">Sa
                                @else
                                    <span class="open">Sa
                                @endif
                                </span>
                                @if($winery->time->sunday === 'Closed')
                                    <span class="closed">Su 
                                @elseif($winery->time->sunday === 'Appointment Only')
                                    <span class="appt">Su
                                @else
                                    <span class="open">Su
                                @endif
                                </span>                                       
                            </a>
                        </div>
                    </div>
                </address>
                {{-- Times Modal --}} 
                <div id="times-modal-{{$winery->id}}" uk-modal>
                    <div class="uk-modal-dialog uk-modal-body">
                        <div class="uk-text-right">
                            <button class="uk-text-right uk-modal-close uk-margin-remove-bottom" type="button" uk-close></button>
                        </div>
                        <h2 class="uk-modal-title uk-text-center uk-heading-line">Business Hours</h2>
                        <div class="uk-margin-left">
                            <h3 class="uk-text-center">{{$winery->name}}</h3>
                            <p>Monday: {{$winery->time->monday}}</p>
                            <p>Tuesday: {{$winery->time->tuesday}}</p>
                            <p>Wednesday: {{$winery->time->wednesday}}</p>
                            <p>Thursday: {{$winery->time->thursday}}</p>
                            <p>Friday: {{$winery->time->friday}}</p>
                            <p>Saturday: {{$winery->time->saturday}}</p>
                            <p>Sunday: {{$winery->time->sunday}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{ $wineries->appends(request()->except('page'))->links() }}