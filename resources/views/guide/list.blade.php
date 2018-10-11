@extends('layouts.master')

@section('title')
    Winery Guide
@endsection

@section('header')
    Winery Guide
@endsection

@section('content')
    <form method='get' action='/guide/list' name="guideForm" id="guideForm" class=" uk-grid-small uk-padding-large" uk-grid>
        <div class="uk-width-1-2@s">
            <label class="uk-label" for="citySelect">Location</label>
            <select name="citySelect" id="citySelect" class="uk-select">
                <option value='all' {{ $citySelect == 'all' ? 'SELECTED' : '' }}>All</option>
                @foreach($cityOptions as $cityOption)
                    <option value='{{$cityOption}}' {{ $citySelect == $cityOption ? 'SELECTED' : '' }}>{{$cityOption}}</option>
                @endforeach
            </select>
            {{--<label class="uk-label" for="regionSelect">Location</label>
            <select name="regionSelect" id="regionSelect" class="uk-select">
                <option value='all'>All</option>
                @foreach($regionOptions as $regionOption)
                    <option value='{{$regionOption}}' {{ $regionSelect == $regionOption ? 'SELECTED' : '' }}>{{$regionOption}}</option>
                @endforeach
            </select>--}}
        </div>
        <div class="uk-width-1-2@s">
            <label class="uk-label" for="sortSelect">Sort By</label>
            <select name="sortSelect" id="sortSelect" class="uk-select">
                <option value='a-z' {{ $sortSelect == "a-z" ? 'SELECTED' : '' }}>Alphabetical (A-Z)</option>
                <option value='z-a' {{ $sortSelect == "z-a" ? 'SELECTED' : '' }}>Alphabetical (Z-A)</option>
            {{--<option>Most Favorited</option>
                <option>Most Visited</option>
                <option>Average Rating</option>--}}             
            </select>
        </div>
        <br>
        <div class="uk-width-1-2@s">
            <button id="advanced-button" class="uk-button uk-button-link uk-padding-small" uk-toggle="target: #advanced-options; animation: uk-animation-fade">Advanced Options</button>
            <div id="advanced-options" hidden>
                <fieldset class="uk-fieldset">
                    <legend>Production Size</legend>
                    <input type="checkbox" id="boutique" name="size" value="boutique" checked/>
                    <label for="boutique">Boutique</label>
                    <input type="checkbox" id="medium" name="size" value="medium" checked/>
                    <label for="medium">Medium</label>
                    <input type="checkbox" id="large" name="size" value="large" checked/>
                    <label for="large">Large</label>
                </fieldset>
                <fieldset class="uk-fieldset">
                    <legend>Dining Option</legend>
                    <input type="checkbox" id="dining_option" name="dining" value="boutique"/>
                    <label for="dining_option">Dining Only</label>
                </fieldset>
            </div>
            <button type="submit" class="uk-button uk-button-primary">Go</button>
        </div>
    </form>
    
    @if($wineries)
    <div class="uk-child-width-1-2@m" uk-grid>
        @foreach($wineries as $winery)
            <div class="uk-card uk-card-small uk-padding-small uk-card-hover">
                <div class="uk-card-header uk-padding-remove">
                    <a class="uk-link-heading" href="/winery/{{$winery->id}}">
                        <div class="uk-grid-small uk-flex-center" uk-grid>
                            <div>   
                                <img class="winery_logo" src="{{'/img/logos/'.$winery->logo_lg}}" alt="{{$winery->name}} Logo">
                            </div>
                            <div class="uk-flex uk-flex-middle">    
                                <div>
                                    <h2 class="uk-card-title uk-margin-remove-bottom uk-padding-left">{{ $winery->name }}
                                        <span class="uk-text-muted" uk-icon="icon: check"></span>
                                    </h2>
                                    @if( $winery->sub_name )
                                        <p class="uk-text-meta uk-margin-remove">{{ $winery->sub_name }}</p>
                                    @endif
                                    <form class="uk-form uk-display-inline" action="/favorite/add/" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{$winery->id}}">
                                    <button type="submit" class="uk-button uk-button-text" title="Favorite">
                                        <span uk-icon="icon: heart"></span>
                                    </button>
                                    <span><em>4</em></span>
                                    </form>
                                    <form class="uk-form uk-display-inline" action="/wishlist/add/" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{$winery->id}}">
                                        <button type="submit" class="uk-button uk-button-text uk-margin-left" title="Wishlist">
                                            <span uk-icon="icon: star"></span>
                                        </button>
                                        <span><em>6</em></span>
                                    </form>
                                    <form class="uk-form uk-display-inline" action="/planner/add/" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{$winery->id}}">
                                        <button type="submit" class="uk-button uk-button-text uk-margin-left" title="Planner">
                                            <span uk-icon="icon: plus-circle"></span>        
                                        </button>
                                        <span><em>14</em></span>
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </a>
                </div> 
                <div class="uk-card-body uk-padding-remove-top">
                    @php
                        $directionLink = 'https://www.google.com/maps/dir//'.$winery->name.', '.$winery->street.', '.$winery->state.', '.$winery->zip;
                    @endphp

                    <address class="uk-grid-small uk-flex-center" uk-grid>
                        <div class="uk-flex-middle">
                            <a class="uk-link-heading" href="/winery/{{$winery->id}}">{{ $winery->street }}<br>
                            {{ $winery->city }}, {{ $winery->state }}, {{ $winery->zip }}</a>
                        </div>
                        <div class="uk-flex-middle">
                            @if( $winery->phone )
                                <a class="uk-link uk-display-block" href="tel:+6494461709">
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
                        </div>
                    </address>
                </div>
            </div>
              
        @endforeach
    </div>
    @else
        <p>GREETINGS</p>
    @endif  
@endsection
