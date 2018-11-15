@extends('layouts.master')

@section('title')
    {{$winery->name}}
@endsection

@section('header')
    <h1 class="uk-heading-primary uk-text-center">{{$winery->name}}</h1>
    @if( $winery->sub_name )
        <h2 class="uk-text-center uk-text-lead uk-margin-top">{{ $winery->sub_name }}</h2>
    @endif
@endsection

@section('content')      
    <div class="uk-card uk-card-large uk-margin-remove" uk-grid>
        <div class="uk-card-header uk-width-1-1 uk-padding-remove">
            <div class="uk-flex-center"> 
                <img class="winery_logo_lg uk-align-center uk-padding-remove" src="{{'/img/logos/'.$winery->logo}}" alt="{{$winery->name}} Logo"> 
            </div>
        </div>
        <div class="uk-width-1-1 uk-text-center uk-padding-remove uk-grid uk-child-width-1-1 uk-display-inline" uk-grid>
            @auth
                @if($favorites->contains('id', $winery->id))
                    <form class="uk-form uk-display-inline" action="/unfavorite/{{$winery->id}}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="delete" />
                        <button type="submit" class="favorited uk-button uk-button-text" title="Favorite">
                            <span uk-icon="icon: heart; ratio:2"></span>Remove from Favorites
                @else
                     <form class="uk-form uk-display-inline" action="/favorite" method="post">
                        @csrf
                        <input type="hidden" name="winery_id" value="{{$winery->id}}">
                        <button type="submit" class="not_favorited uk-button uk-button-text" title="Favorite">
                            <span uk-icon="icon: heart; ratio:2"></span>Add to Favorites
                @endif
                    </button>
                </form>
                @if($wishlists->contains('id', $winery->id))
                    <form class="uk-form uk-display-inline" action="/unwishlist/{{$winery->id}}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="delete" />
                        <button type="submit" class="wishlisted uk-button uk-button-text" title="Wishlist">
                            <span uk-icon="icon: star; ratio:2"></span>Remove from Wishlist
                          
                @else
                     <form class="uk-form uk-display-inline" action="/wishlist" method="post">
                        @csrf
                        <input type="hidden" name="winery_id" value="{{$winery->id}}">
                        <button type="submit" class="not_wishlisted uk-button uk-button-text" title="Wishlist">
                            <span uk-icon="icon: star; ratio:2"></span>Add to Wishlist
                @endif
                    </button>
                </form>
            @endauth

           {{-- <form class="uk-form uk-form uk-display-inline" action="/planner/add/" method="post">
                @csrf
                <input type="hidden" value="{{$winery->id}}">
                <button type="submit" class="uk-button uk-button-default uk-button-small" title="Planner">
                    <span uk-icon="icon: plus-circle"></span>
                    PLANNER        
                </button>. 
            </form>--}}
        </div>
    </div>                     
    <div class="uk-grid uk-margin-large uk-child-width-1-3@m" uk-grid>
        <div>
            <h4 class="uk-margin-remove uk-text-center">Contact Info</h2>
            <table class="uk-table uk-table-small uk-flex uk-flex-center">
                <tbody>
                    <tr class="uk-flex uk-flex-middle">
                        <th>Address</th>
                        <td>{{$winery->street}} <br> 
                            {{$winery->city}}, {{$winery->state}} {{$winery->zip}}
                        </td> 
                    </tr>
                    @if(!empty($winery->phone))
                        <tr>
                            <th>Phone</th>
                            <td><a href="tel:{{$winery->phone}}">{{$winery->phone}}</a></td> 
                        </tr>
                    @endif
                    @if(!empty($winery->email))
                        <tr>
                            <th>Email</th>
                            <td><a href="mailto:{{$winery->email}}">{{$winery->email}}</td> 
                        </tr>
                    @endif
                    @if(!empty($winery->web_url))
                        <tr>
                            <th>Website</th>
                            <td><a class="uk-link" href="{{$winery->web_url}}" target="_blank">{{$winery->web_url}}</a></td> 
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div>
            <h4 class="uk-text-center uk-margin-remove">Tasting Room Hours</h4>
            <table class="uk-table uk-table-small uk-flex uk-flex-center uk-table-justify">
                <tbody>
                    <tr>
                        <th>Monday</a></th>
                        <td>{{$time->monday}}</td> 
                    </tr>
                    <tr>
                        <th>Tuesday</th>
                        <td>{{$time->tuesday}}</td> 
                    </tr>
                    <tr>
                        <th>Wednesday</th>
                        <td>{{$time->wednesday}}</td> 
                    </tr>
                    <tr>
                        <th>Thursday</th>
                        <td>{{$time->thursday}}</td> 
                    </tr>
                    <tr>
                        <th>Friday</th>
                        <td>{{$time->friday}}</td> 
                    </tr>
                    <tr>
                        <th>Saturday</th>
                        <td>{{$time->saturday}}</td> 
                    </tr>
                    <tr>
                        <th>Sunday</th>
                        <td>{{$time->sunday}}</td> 
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <h4 class="uk-text-left uk-margin-remove"> AVA Regions </h4>
            <ul class="uk-list uk-margin-remove">
                @foreach($avas as $ava)
                    <li class="uk-margin-remove"><a class="uk-link-reset" href="#">{{$ava}}</a></li>
                @endforeach
            </ul>
            <h4 class="uk-margin-remove-bottom"> Dining</h3>
            <p class="uk-margin-remove">
                @if($winery->dining == 0)
                     {{"No"}}
                @elseif($winery->dining == 1)
                    {{"Yes"}}
                @endif
            </p>
        </div>
    </div>
    <div class="uk-flex uk-flex-center uk-margin-top-large">
        @php
            $address_url = $winery->name.', '.$winery->street.', '.$winery->city.','.$winery->state.','.$winery->zip;
            str_replace(' ', '+', $address_url);
        @endphp
    
        <iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=address:{{$address_url}}&key=AIzaSyAfEbBPDyRHHQhMvLOaS6iTXTbqPyf3Kl0" allowfullscreen></iframe>
    </div>
    </div>
@endsection