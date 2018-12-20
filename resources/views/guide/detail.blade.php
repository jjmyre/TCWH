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
                        <button type="submit" class="favorited uk-button" title="Favorite">
                            <span class="uk-display-block" uk-icon="icon: heart; ratio:2"></span> Remove from Favorites
                @else
                    <form class="uk-form uk-display-inline" action="/favorite" method="post">
                        @csrf
                        <input type="hidden" name="winery_id" value="{{$winery->id}}">
                        <button type="submit" class="not_favorited uk-button" title="Favorite">
                            <span class="uk-display-block" uk-icon="icon: heart; ratio:2"></span> Add to Favorites
                @endif
                    </button>
                </form>
                @if($wishlists->contains('id', $winery->id))
                    <form class="uk-form uk-display-inline" action="/unwishlist/{{$winery->id}}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="delete" />
                        <button type="submit" class="wishlisted uk-button" title="Wishlist">
                            <span class="uk-display-block" uk-icon="icon: star; ratio:2"></span> Remove from Wishlist
                          
                @else
                     <form class="uk-form uk-display-inline" action="/wishlist" method="post">
                        @csrf
                        <input type="hidden" name="winery_id" value="{{$winery->id}}">
                        <button type="submit" class="not_wishlisted uk-button" title="Wishlist">
                            <span class="uk-display-block" uk-icon="icon: star; ratio:2"></span> Add to Wish List
                @endif
                    </button>
                </form>

                @if($plans->contains('id', $winery->id))
                    <form class="uk-form uk-display-inline" action="/planner/remove/{{$winery->id}}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="delete" />
                        <button type="submit" class="planned uk-button" title="Planner">
                            <span class="uk-display-block" uk-icon="icon: list; ratio:2"></span> Remove from Planner
                          
                @elseif($plans->count() < 9)
                     <form class="uk-form uk-display-inline" action="/planner/add" method="post">
                        @csrf
                        <input type="hidden" name="winery" value="{{$winery->id}}">
                        <button type="submit" class="not_wishlisted uk-button" title="Planner">
                            <span class="uk-display-block" uk-icon="icon: list; ratio:2"></span> Add to Planner
                @endif
                    </button>
                </form>
            @endauth

           
        </div>
    </div>                     
    <div class="uk-grid uk-container uk-child-width-1-3@s" uk-grid>
        <div>
            <h4 class="uk-margin-remove">Contact Info</h4>
            <table class="uk-table uk-table-small uk-flex uk-flex-left">
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
                            <td><a href="mailto:{{$winery->email}}">{{$winery->email}}</a></td> 
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
            <h4 class="uk-margin-remove">Tasting Room Hours</h4>
            <table class="uk-table uk-table-small uk-flex uk-flex-left">
                <tbody>
                    <tr>
                        <th>Monday</th>
                        <td class="uk-text-left">{{$time->monday}}</td> 
                    </tr>
                    <tr>
                        <th>Tuesday</th>
                        <td class="uk-text-left">{{$time->tuesday}}</td> 
                    </tr>
                    <tr>
                        <th>Wednesday</th>
                        <td class="uk-text-left">{{$time->wednesday}}</td> 
                    </tr>
                    <tr>
                        <th>Thursday</th>
                        <td class="uk-text-left">{{$time->thursday}}</td> 
                    </tr>
                    <tr>
                        <th>Friday</th>
                        <td class="uk-text-left">{{$time->friday}}</td> 
                    </tr>
                    <tr>
                        <th>Saturday</th>
                        <td class="uk-text-left">{{$time->saturday}}</td> 
                    </tr>
                    <tr>
                        <th>Sunday</th>
                        <td class="uk-text-left">{{$time->sunday}}</td> 
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <h4>AVA Regions </h4>
            <ul class="uk-list uk-margin-remove">
                @foreach($avas as $ava)
                    <li class="uk-margin-remove"><a class="uk-link" href="/avamap/{!! str_replace(' ', '_', $ava) !!}">{{$ava}}</a></li>
                @endforeach
            </ul>
            <h4>Dining</h4>
            <p class="uk-margin-remove">
                @if($winery->dining == 0)
                     {{"No"}}
                @elseif($winery->dining == 1)
                    {{"Yes"}}
                @endif
            </p>
            @if(count($nearbyWineries) > 0)
                <h4>Nearby Wineries</h4>
                <ul class="uk-list uk-margin-remove">
                    @foreach($nearbyWineries as $nearbyWinery)
                        <li class="uk-margin-remove"><a class="uk-link" href="/winery/{{$nearbyWinery->id}}">{{$nearbyWinery->name}}</a></li>
                    @endforeach
                </ul>
            @endif
        </div>
        @auth
            <div class="uk-container">
                <a class="uk-button uk-button-default uk-display-block uk-padding-remove uk-text-center" uk-toggle="target: #mistake-modal" href="">Something Wrong? Let us know.</a>
            </div>
        @endauth
    </div>
    <div class="uk-container uk-margin-medium-top uk-margin-large-bottom">
        @include('guide.map')
    </div>

    <!-- Mistake Form Modal (only seen by users) -->
    @auth
        @if ($errors->has('mistake') || $errors->has('description'))
            <div id="mistake-modal" class="uk-open" uk-modal style="display: block">
        @else
            <div id="mistake-modal" uk-modal>
        @endif 
            <div class="uk-modal-dialog uk-modal-body">
                <h2 class="uk-modal-title">What's Wrong?</h2>
                <form class="uk-form uk-form-stacked" action="/guide/mistake" method="POST" id="error_form">
                    @csrf
                    <fieldset class="uk-fieldset uk-width-1-1">
                        <label class="uk-form-label" for="subject">Problem</label>
                         @if ($errors->has('mistake'))               
                            <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                                <a class="uk-alert-close" uk-close></a>
                                <strong>{{ $errors->first('mistake') }}</strong>
                            </div>
                        @endif 
                        <select class="uk-select" name="mistake" id="mistake" required>
                            <option value='' {{ old('mistake') == '' ? 'SELECTED' : '' }} disabled>Select Problem</option>
                            <option value="Incorrect Winery Address" {{ old('mistake') == 'Incorrect Winery Address' ? 'SELECTED' : '' }}>Incorrect Winery Address</option>
                            <option value="Wrong Contact Information" {{ old('mistake') == 'Wrong Contact Information' ? 'SELECTED' : '' }}>Wrong Contact Info</option>
                            <option value="Wrong Business Hours" {{ old('mistake') == 'Wrong Business Hours' ? 'SELECTED' : '' }}>Wrong Business Hours</option>
                            <option value="Broken Link" {{ old('mistake') == 'Broken Link' ? 'SELECTED' : '' }}>Broken Link(s)</option>
                            <option value="Winery Website" {{ old('mistake') == 'Winery Website' ? 'SELECTED' : '' }}>Missing Information</option>
                            <option value="Other" {{ old('mistake') == 'Other' ? 'SELECTED' : '' }}>Other</option>
                        </select>
                        <div class="uk-width-1-1 uk-margin-top">
                            <label class="uk-form-label" for="message">Description of Problem</label>
                             @if ($errors->has('description'))               
                                <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                                    <a class="uk-alert-close" uk-close></a>
                                    <strong>{{ $errors->first('description') }}</strong>
                                </div>
                            @endif 
                            <textarea class="uk-textarea uk-width-1-1 uk-form-large" id="description" value="{{ old('description') }}" placeholder="Describe the problem (Limited to 500 characters)" name="description" required></textarea>
                        </div>
                    </fieldset>
                    <input type="hidden" name="winery_id" value="{{$winery->id}}">
                    <div class="uk-text-right uk-margin-top">
                        <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                        <button class="uk-button uk-button-primary" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    @endauth
@endsection