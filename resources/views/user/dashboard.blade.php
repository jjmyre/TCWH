@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('header')
        <h1 class="uk-heading-primary uk-text-center">{{$user->username}}'s Dashboard</h1>
@endsection


@section('content')
    <div class="uk-flex uk-flex-center uk-width-1-1">
        <ul class="uk-subnav uk-text-center uk-subnav-pill uk-padding-small" uk-switcher="connect: .dashboard">
            <li class="uk-padding-remove"><a href="#">Wishlist</a></li>
            <li class="uk-padding-remove"><a href="#">Favorites</a></li>
            <li class="uk-padding-remove"><a href="#">Visited</a></li>
        </ul>
    </div>
    <div class="uk-child-width-1-2@l uk-padding-small uk-margin-remove uk-flex uk-flex-center" uk-grid>     
        <div class="uk-switcher dashboard uk-container uk-flex uk-flex-left uk-margin-remove uk-padding-small">                     
            <div class="uk-card">
                <div class="uk-card-body">
                    @if($user->wishlists()->exists())
                        <ul class="uk-list">
                            @foreach($wishlists as $wishlist)
                                <li>
                                    <a class="uk-link" href="/winery/{{$wishlist->id}}">{{$wishlist->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Wishlist is empty.</p>
                    @endif
                </div>
            </div>
            <div class="uk-card">
                <div class="uk-card-body">
                    @if($user->favorites()->exists())
                        <ul class="uk-list">
                            @foreach($favorites as $favorite)
                                <li>
                                    <a class="uk-link" href="/winery/{{$favorite->id}}">{{$favorite->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Favorites list is empty.</p>
                    @endif
                </div>
            </div>
            <div class="uk-card">
                <div class="uk-card-body">
                    @if($user->visits()->exists())
                        <ul class="uk-list">
                            @foreach($visits as $visited)
                                <li>
                                    <a class="uk-link" href="/winery/{{$visited->id}}">{{$visited->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    @else 
                        <p>Visited List is empty.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
                        
@endsection


