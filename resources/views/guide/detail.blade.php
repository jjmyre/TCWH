@extends('layouts.master')

@section('title')
    {{$winery->name}}
@endsection

@section('header')
    <h1 class="uk-heading-primary uk-text-center">{{$winery->name}}</h1>
    @if( $winery->sub_name )
        <h2 class="uk-text-center uk-text-lead uk-margin-remove">{{ $winery->sub_name }}</h2>
    @endif
@endsection

@section('content')      
    <div class="uk-card uk-card-large uk-margin-remove uk-felx uk-flex-center" uk-grid>
        <div class="uk-card-header uk-width-1-1 uk-padding-remove">
            <div class="uk-flex-center"> 
                <img class="winery_logo_lg uk-align-center" src="{{'/img/logos/'.$winery->logo}}" alt="{{$winery->name}} Logo"> 
            </div>
        </div>                     

        <div>
            <h3 class="uk-heading uk-margin-remove"> AVA Regions </h3>
            <ul class="uk-list uk-margin-remove">
                @foreach($avas as $ava)
                    <li><a class="uk-link-reset" href="#">{{$ava}}</a></li>
                @endforeach
            </ul>
        </div>
         @php
            $directionLink = 'https://www.google.com/maps/dir//'.$winery->name.', '.$winery->street.', '.$winery->state.', '.$winery->zip;
        @endphp
        <div>
            <h3 class="uk-heading uk-text-underline uk-margin-remove"> Address </h3>
            <p class="uk-link-reset uk-margin-remove">{{ $winery->street }}<br>
                    {{ $winery->city }}, {{ $winery->state }}, {{ $winery->zip }}
            </p>
            <a class="uk-link uk-display-block" href="{!! str_replace(' ', '+', $directionLink) !!}" target="_blank"></span>Directions</a>
        </div>
        <div>
            <h3 class="uk-heading uk-margin-remove"> Contact Info</h3>
            @if( $winery->phone )
                <a class="uk-link uk-display-block" href="tel:{{$winery->phone}}">
                    <span uk-icon="icon:receiver"></span>
                {{ $winery->phone }}</a>
            @endif

            @if( $winery->email )
                <a class="uk-link uk-display-block" href="mailto:{{$winery->email}}">
                    <span uk-icon="icon:mail"></span>
                {{ $winery->email }}</a>
            @endif
            @if($winery->web_url)
                <a class="uk-link uk-display-inline-block" href="{{ $winery->web_url }}" target="_blank">
                <span uk-icon="icon:link"></span>Website</a>
            @endif
        </div>
        <div>
            <h3 class="uk-heading uk-margin-remove"> Production Size</h3>
            <p class="uk-link-reset uk-margin-remove">{{ $winery->size }}</p>
            <h3 class="uk-heading uk-margin-remove"> Dining</h3>
            <p class="uk-link-reset uk-margin-remove">
                @if($winery->dining == 0)
                     {{"No"}}
                @elseif($winery->dining == 1)
                    {{"Yes"}}
                @endif
            </p>
        </div>
        <div class="uk-width-1-1 uk-text-center uk-padding-remove uk-grid uk-child-width-1-3@m" uk-grid>
            <form class="uk-form uk-display-inline" action="/favorite/add/" method="post">
            {{ csrf_field() }}
                <input type="hidden" value="{{$winery->id}}">
                <button type="submit" class="uk-button uk-button-primary uk-border-rounded" title="Favorite">
                    <span uk-icon="icon: heart"></span>
                    FAVORITE (7)
                </button>
            </form>
            <form class="uk-form uk-display-inline" action="/wishlist/add/" method="post">
                {{ csrf_field() }}
                <input type="hidden" value="{{$winery->id}}">
                <button type="submit" class="uk-button uk-button-primary uk-border-rounded" title="Wishlist">
                    <span uk-icon="icon: star;"></span>
                    WISHLIST (60)
                </button>
                
            </form>
            <form class="uk-form uk-display-inline" action="/planner/add/" method="post">
                {{ csrf_field() }}
                <input type="hidden" value="{{$winery->id}}">
                <button type="submit" class="uk-button uk-button-primary uk-border-rounded" title="Planner">
                    <span uk-icon="icon: plus-circle"></span>
                    PLANNER (14)        
                </button>
            </form>
        </div>
        </div>
    </div>
@endsection