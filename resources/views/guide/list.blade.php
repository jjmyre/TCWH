@extends('layouts.master')

@section('title')
    Winery Guide
    @if($citySelect != 'all' & $citySelect != 'default')
        | {{$citySelect}}
    @endif
@endsection

@section('header')
        @if($citySelect == 'all' or $citySelect == 'default')
            <h1 class="uk-heading-primary uk-text-center">Winery Guide</h1>
        @else
             <h1 class="uk-text-center uk-heading">Winery Guide : {{$citySelect}}</h1>
        @endif
@endsection

@section('content')
    <form method='get' action='/guide/list/' name="guideForm" id="guideForm" class="uk-form uk-grid-small uk-grid-match uk-padding" uk-grid>
        <div class="uk-width-1-2@s">
            <label class="uk-label" for="citySelect">Location</label>
            <select name="citySelect" id="citySelect" class="uk-select" required>
                <option selected disabled>Choose City</option>
                <option value='all' {{ $citySelect == 'all' ? 'SELECTED' : '' }}>All</option>
                @foreach($cityOptions as $cityOption)
                    <option value='{{$cityOption}}' {{ $citySelect == $cityOption ? 'SELECTED' : '' }}>{{$cityOption}}</option>
                @endforeach
            </select>
            {{--<label class="uk-label" for="regionSelect">Location</label>
            <select name="regionSelect" id="regionSelect" class="uk-select" required>
                <option value='default' {{ $regionSelect == 'default' ? 'SELECTED' : '' }} disabled>Choose Region</option>
                <option value='all' {{ $regionSelect == 'all' ? 'SELECTED' : '' }}>All</option>
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
        <div class="uk-width-1-1@s">
            <div class="uk-text-right">
                <button type="submit" class="uk-border-rounded uk-button uk-button-secondary">Go</button>
            </div>
        </div>
            {{--<div>
                    <button id="advanced-button" class="uk-text-center uk-button uk-button-small uk-button-link uk-text-center" uk-toggle="target: #advanced-options; animation: uk-animation-fade">Advanced Options</button>
                </div>

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
            --}}
    </form>
    @if($citySelect == 'default')
        <p class="uk-text-center uk-text-muted">There are {{ $count }} wineries waiting to be discovered.</p>
    @elseif(isset($wineries) & $citySelect != 'default')
        <p class="uk-text-center uk-text-muted">
        @if($count == 1)
            1 winery was found.</p>
        @elseif($count > 1) 
            {{$count}} wineries were found.</p>
        @else($count < 1) 
            No wineries were found.</p>
        @endif
    
        {{ $wineries->appends(request()->except('page'))->links() }}
        @if($count <= 1)
            <div class="uk-child-width uk-margin-remove" uk-grid>
        @else
            <div class="uk-child-width-1-2@l uk-padding-small uk-margin-remove" uk-grid>
        @endif
            @foreach($wineries as $winery)
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
                            </div>
                        </address>
                    </div>
                </div>
            @endforeach
        </div>
        {{--https://laracasts.com/discuss/channels/laravel/how-to-send-parameters-in-paginate-function--}}
        {{ $wineries->appends(request()->except('page'))->links() }}
    @else
        <p class="uk-text-center uk-text-muted">No wineries found.</p>
    @endif
@endsection
