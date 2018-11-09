@if($citySelect != '' && $citySelect == 'all')
    <h2 class="uk-heading-line uk-text-center">All Cities</h2>
@elseif($citySelect != '' && $citySelect != 'all')
    <h2 class="uk-heading-line uk-text-center">{{$citySelect}}</h2>
@endif

@if($citySelect == '' && $regionSelect == '')
    <p class="uk-text-center uk-margin-top uk-text-muted">There are {{ $totalCount }} wineries waiting to be discovered.</p>
@elseif($citySelect != '')
    <p class="uk-text-center uk-text-muted">
        @if($cityCount == 1)
            1 winery was found.</p>
        @elseif($cityCount > 1) 
            {{$cityCount}} wineries were found.</p>
        @elseif($cityCount < 1) 
            No wineries were found.</p>
        @endif
@endif

{{ $cityWineries->appends(request()->except('page'))->links() }}
    
@if($cityCount <= 1)
    <div class="uk-child-width uk-margin-remove" uk-grid>
@else
    <div class="uk-child-width-1-2@l uk-padding-small uk-margin-remove" uk-grid>
@endif
    @foreach($cityWineries as $winery)
        <div class="uk-card" id="div_{{$winery->id}}">
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
                                    @if($winery)
                                        <span class="uk-text-muted uk-padding-small uk-float-right" title="You have visited this winery." uk-icon="icon: check"></span>
                                    @endif
                                @endauth

                                @if($winery->sub_name)
                                    <p class="uk-text uk-margin-remove">{{ $winery->sub_name }}</p>
                                @endif
                            </a>
                            <div class="uk-padding-top">
                                @auth
                                    @if($winery)
                                        <form class="uk-form uk-display-inline" action="/favorite" method="post">
                                            @csrf
                                            <input type="hidden" name="winery-id" value="{{$winery->id}}">
                                            <button type="submit" class="uk-button uk-button-text" title="Favorite">
                                                <span uk-icon="icon: heart; ratio:2"></span>
                                                <span>7</span>
                                            </button>
                                        </form>
                                    @else
                                        <form class="uk-form uk-display-inline" action="/unfavorite/{{$winery->id}}" method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete" />
                                            <button type="submit" class="uk-button uk-button-text" title="Favorite">
                                                <span uk-icon="icon: heart; ratio:2"></span>
                                                <span>7</span>
                                            </button>
                                        </form>
                                    @endif
                                    @if($winery)
                                        <form class="uk-form uk-display-inline" action="/wishlist" method="post">
                                            @csrf
                                            <input type="hidden" name="winery-id" value="{{$winery->id}}">
                                            <button type="submit" class="uk-button uk-button-text uk-margin-left" title="Wishlist">
                                                <span uk-icon="icon: star; ratio:2"></span>
                                                <span>60</span>
                                            </button>
                                        </form>
                                    @else
                                        <form class="uk-form uk-display-inline" action="/unwishlist/{{$winery->id}}" method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete" />
                                            <button type="submit" class="uk-button uk-button-text uk-margin-left" title="Wishlist">
                                                <span uk-icon="icon: star; ratio:2"></span>
                                                <span>60</span>
                                            </button>
                                        </form>
                                    @endif
                                    @if($winery)
                                        <form class="uk-form uk-display-inline" action="/planner/add" method="post">
                                            @csrf
                                            <input type="hidden" name="winery-id" value="{{$winery->id}}">
                                            <button type="submit" class="uk-button uk-button-text uk-margin-left" title="Planner">
                                                <span uk-icon="icon: plus-circle; ratio:2"></span>        
                                                <span>14</span>
                                            </button>
                                        </form>
                                    @else
                                        <form class="uk-form uk-display-inline" action="/planner/remove/{{$winery->id}}" method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete" />
                                            <button type="submit" class="uk-button uk-button-text uk-margin-left" title="Planner">
                                                <span uk-icon="icon: plus-circle; ratio:2"></span>        
                                                <span>14</span>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                                @guest
                                    <div class="uk-button" title="Favorite">
                                        <span uk-icon="icon: heart"></span>
                                        <span>7</span>
                                    </div>   
                                    <div class="uk-button" title="Wishlist">
                                        <span uk-icon="icon: star"></span>
                                        <span>60</span>
                                    </div>
                                    <div class="uk-button uk-padding-remove-left" title="Planner">
                                        <span uk-icon="icon: plus-circle"></span>        
                                        <span>14</span>
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
                        <a class="uk-link uk-display-block" href="{!! str_replace(' ', '+', $directionLink) !!}" target="_blank">
                            <span uk-icon="icon:location"></span>
                            Directions</a>

                        <a class="time-box uk-link uk-display-inline-block" uk-toggle="target: #times-modal">
                            <span class="uk-margin-small-right" uk-icon="icon: clock"></span>
                            
                            @if($winery->time->monday = 'closed')
                                <span class="closed">M
                            @elseif($winery->time->monday == 'appt')
                                <span class="appt">M
                            @else
                                <span class="open">M
                            @endif
                            </span>
                            @if($winery->time->tuesday = 'closed')
                                <span class="closed">Tu 
                            @elseif($winery->time->tuesday = 'appt')
                                <span class="appt">Tu
                            @else
                                <span class="open">Tu
                            @endif
                            </span>                           
                            @if($winery->time->wednesday === 'closed')
                                <span class="closed">W 
                            @elseif($winery->time->wednesday === 'appt')
                                <span class="appt">W
                            @else
                                <span class="open">W
                            @endif
                            </span>
                            @if($winery->time->thursday === 'closed')
                                <span class="closed">Th 
                            @elseif($winery->time->thursday === 'appt')
                                <span class="appt">Th
                            @else
                                <span class="open">Th
                            @endif
                            </span>
                            @if($winery->time->friday === 'closed')
                                <span class="closed">F 
                            @elseif($winery->time->friday === 'appt')
                                <span class="appt">F
                            @else
                                <span class="open">F
                            @endif
                            </span>
                            @if($winery->time->saturday === 'closed')
                                <span class="closed">Sa 
                            @elseif($winery->time->saturday === 'appt')
                                <span class="appt">Sa
                            @else
                                <span class="open">Sa
                            @endif
                            </span>
                            @if($winery->time->sunday === 'closed')
                                <span class="closed">Su 
                            @elseif($winery->time->sunday === 'appt')
                                <span class="appt">Su
                            @else
                                <span class="open">Su
                            @endif
                            </span>                                       
                        </a>
                </address>
                {{-- Times Modal --}} 
                <div id="times-modal" uk-modal>
                    <div class="uk-modal-dialog uk-modal-body">
                        <h2 class="uk-modal-title uk-heading-line">Business Hours</h2>
                        <h3>{{$winery->name}}</h3>
                        <p>Monday: {{$winery->time->monday}}</p>
                        <p>Tuesday {{$winery->time->tuesday}}</p>
                        <p>Wednesday: {{$winery->time->wednesday}}</p>
                        <p>Thursday: {{$winery->time->thursday}}</p>
                        <p>Friday: {{$winery->time->friday}}</p>
                        <p>Saturday: {{$winery->time->saturday}}</p>
                        <p>Sunday: {{$winery->time->sunday}}</p>
                        <button class="uk-button uk-button-default uk-modal-close" type="button"><span uk-icon="close"></span></button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{ $cityWineries->appends(request()->except('page'))->links() }}




