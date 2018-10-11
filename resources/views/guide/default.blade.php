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
                <option selected value='all'>All</option>
                @foreach($cityOptions as $cityOption)
                    <option value='{{$cityOption}}'>{{$cityOption}}</option>
                @endforeach
            </select>
            {{--<label class="uk-label" for="regionSelect">Location</label>
            <select name="regionSelect" id="regionSelect" class="uk-select">
                <option value='all'>All</option>
                <option value='all'>All</option>
                @foreach($regionOptions as $regionOption)
                    <option value='{{$regionOption}}'>{{$regionOption}}</option>
                @endforeach
            </select>--}}
        </div>
        <div class="uk-width-1-2@s">
            <label class="uk-label" for="sortSelect">Sort By</label>
            <select name="sortSelect" id="sortSelect" class="uk-select">
                <option value='a-z'>Alphabetical (A-Z)</option>
                <option value='z-a'>Alphabetical (Z-A)</option>
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
            <button type="submit" class="uk-button uk-button-primary">Search</button>
        </div>
    </form>
    @if($wineries)
        @if(is_numeric ($wineries))
            <p>{{$wineries}}</p>
        @else
        @foreach($wineries as $winery)
            <div class="uk-card uk-card-small uk-border">
                <div class="uk-card-header">
                    <a class="uk-link-heading" href="/winery/{{$winery->id}}">
                        <div class="uk-grid-small" uk-grid>
                            <div>   
                                <img class="winery_logo" src="{{'/img/logos/'.$winery->logo_lg}}" alt="{{$winery->name}} Logo">
                            </div>
                            <div class="uk-width-expand uk-flex uk-flex-middle">    
                                <div>
                                    <h2 class="uk-card-title uk-margin-remove-bottom uk-padding-left">{{ $winery->name }}</h2>
                                    @if( $winery->sub_name )
                                        <p class="uk-text-meta uk-margin-remove-top">{{ $winery->sub_name }}</p>
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
                <div class="uk-card-body">
                    <address>
                        <p>{{ $winery->street }}<br>
                        {{ $winery->city }}, {{ $winery->state }} {{ $winery->zip }}</p>
                        @if( $winery->phone )
                            <a class="uk-link uk-display-block" href="tel:+6494461709">
                            <span uk-icon="icon:receiver"></span>
                            {{ $winery->phone }}</a>
                        @endif
                        @if($winery->email)
                            <a class="uk-link uk-display-block" href="mailto:{{$winery->email}}">
                            <span uk-icon="icon:mail"></span>
                            {{ $winery->email }}</a>
                        @endif
                        @if($winery->web_url)
                            <a class="uk-link uk-display-inline-block" href="{{ $winery->web_url }}" target="_blank">
                            <span uk-icon="icon:link"></span>Visit Website
                            </a>
                        @endif
                    </address>

                </div>
                <hr class="uk-divider-icon">
        @endforeach
        @endif

    @else
        <p>GREETINGS</p>
    @endif  
@endsection
