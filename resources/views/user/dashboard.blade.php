@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('header')
        <h1 class="uk-heading-primary uk-text-center">{{$user->username}}'s Dashboard</h1>
@endsection


@section('content')
    @if(!empty($favorites))
        @foreach($favorites as $favorite)
            {{$favorite->name}}
        @endforeach
    @endif
    
    @if(!empty($wishlists))
        @foreach($wishlists as $wishlist)
            {{$wishlist->name}}
        @endforeach
    @endif

    @if(!empty($visits))
        @foreach($visits as $visit)
            {{$visit->name}}
        @endforeach
    @endif

@endsection


