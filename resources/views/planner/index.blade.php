@extends('layouts.master')

@section('title')
    Tasting Planner
@endsection

@section('header')
        <h1 class="uk-heading-primary uk-text-center">My Tasting Planner</h1>
@endsection

@section('content')

<h2>Itinerary</h2>
<form class="uk-form" action="/planner/clear" method="post">
    @csrf
    <input type="hidden" name="_method" value="delete" />
    <button type="submit" class="not_favorited uk-button uk-button-default" title="Favorite">
    	<span uk-icon="icon: trash; ratio:2">
    		CLEAR
    	</span>
	</button>
</form>
    	
@foreach($plans as $plan)
	<h3 class="uk-h3"><strong>{{$plan->pivot->order}}</strong> {{$plan->name}}</h3>	
	<a class="uk-label" href="/winery/{{$plan->id}}">More info</a>
	<form class="uk-form uk-display-inline" action="/planner/remove/{{$plan->id}}" method="post">
        @csrf
        <input type="hidden" name="winery_id" value="{{$plan->id}}">
        <input type="hidden" name="_method" value="delete" />
        <button type="submit" class="not_favorited uk-button uk-button-default" title="Favorite">
        	<span uk-icon="icon: minus; ratio:2"></span>
    	</button>
	</form>
@endforeach

<div class="uk-grid-match uk-flex-center uk-margin-bottom uk-flex" uk-grid>
	<h4 class="uk-h4 uk-flex-middle uk-margin-right">ADD TO ITINERARY FROM:</h4>
    <ul class="uk-subnav uk-text-left uk-subnav-pill uk-margin-left" uk-switcher="connect: .addMenu">
		@if($user->favorites()->exists())
    		<li class="uk-padding-remove"><a href="#">Favorites</a></li>
    	@endif
    	@if($user->wishlists()->exists())
    		<li class="uk-padding-remove"><a href="#">Wish List</a></li>
    	@endif
    	@if($user->visits()->exists())
    		<li class="uk-padding-remove"><a href="#">Visited List</a></li>
    	@endif
    	<li class="uk-padding-remove"><a href="#">Winery List</a></li>
    </ul>
</div>

<div class="uk-switcher addMenu">
@if($user->favorites()->exists())
	<div>
		<form class="uk-form uk-padding uk-margin-remove" action="/planner/add" method="post">
	        @csrf
	        <select name="winery" class="uk-select">
	        	@foreach($favorites as $favorite)
	        		<option value="{{$favorite->id}}">{{$favorite->name}}</option>
	        	@endforeach
	        </select>
	        <div class="uk-text-right uk-margin-top">
		        <button type="submit" class="uk-button uk-button-secondary uk-border-rounded" title="Add">
		        	<span uk-icon="icon: plus"></span>
		        </button>
		    </div>
		</form>
	</div>
@endif
@if($user->wishlists()->exists())
	<div>
		<form class="uk-form uk-padding uk-margin-remove" action="/planner/add" method="post">
	        @csrf
	        <select name="winery" class="uk-select">
	        	@foreach($wishlists as $wishlist)
	        		<option value="{{$wishlist->id}}">{{$wishlist->name}}</option>
	        	@endforeach
	        </select>
	        <div class="uk-text-right uk-margin-top">
		        <button type="submit" class="uk-button uk-button-secondary uk-border-rounded" title="Add">
		        	<span uk-icon="icon: plus"></span>
		        </button>
		    </div>
		</form>
	</div>
@endif

@if($user->visits()->exists())
	<div>
		<form class="uk-form uk-padding uk-margin-remove" action="/planner/add" method="post">
	        @csrf
	        <select name="winery" class="uk-select">
	        	@foreach($visits as $visit)
	        		<option value="{{$visit->id}}">{{$visit->name}}</option>
	        	@endforeach
	        </select>
	        <div class="uk-text-right uk-margin-top">
		        <button type="submit" class="uk-button uk-button-secondary uk-border-rounded" title="Add">
		        	<span uk-icon="icon: plus"></span>
		        </button>
		    </div>
		</form>
	</div>
@endif
	<div>
		<form class="uk-form uk-padding uk-margin-remove" action="/planner/add" method="post">
	        @csrf
	        <select name="winery" class="uk-select" value='6'>
	        	@foreach($wineries as $winery)
	        		<option value="{{$winery->id}}">{{$winery->name}}</option>
	        	@endforeach
	        </select>
			<div class="uk-text-right uk-margin-top">
	        	<button type="submit" class="uk-button uk-button-secondary uk-border-rounded" title="Add">
	        		<span uk-icon="icon: plus"></span>
	        	</button>
	    	</div>
		</form>
	</div>
</div>

@if($user->plans()->exists())
	@include('guide.map')
@endif


@endsection