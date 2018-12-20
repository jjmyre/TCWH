@extends('layouts.master')

@section('title')
    Tasting Planner
@endsection

@section('header')
        <h1 class="uk-heading-primary uk-text-center">Tasting Planner</h1>
@endsection

@section('content')
<div class="uk-container">
	<div class="uk-flex-center uk-margin-bottom uk-flex" uk-grid>
		<div>
			<div class="uk-display-inline">
				<p class="uk-h4 uk-text-center">Add From:</p>
				<ul class="uk-subnav uk-subnav-pill" uk-switcher="connect: .addMenu">
		        	<li class="uk-padding-remove"><a href="#">Winery Guide</a></li>
					@if($user->favorites()->exists())
			    		<li class="uk-padding-remove"><a href="#">My Favorites</a></li>
			    	@endif
			    	@if($user->wishlists()->exists())
			    		<li class="uk-padding-remove"><a href="#">My Wish List</a></li>
			    	@endif
			    	@if($user->visits()->exists())
			    		<li class="uk-padding-remove"><a href="#">My Visited List</a></li>
			    	@endif	
		    	</ul>
		    </div>
			<div class="uk-switcher addMenu">
				<div>
					<form class="uk-form uk-padding uk-margin-remove" action="/planner/add" method="post">
				        @csrf
				 
				        <select name="winery" class="uk-select uk-width-1-1">
				        	@foreach($wineries as $winery)
				        		@if(!($plans->contains($winery->id)))
				        			<option value="{{$winery->id}}">{{$winery->name}}</option>
				        		@endif
				        	@endforeach
				        </select>
			        	<button type="submit" class="uk-button uk-button-secondary uk-text-right" title="Add">
			        		<span uk-icon="icon: plus"></span>
			        	</button>
			
					</form>
				</div>
				@if($user->favorites()->exists())
					<div>
						<form class="uk-form uk-padding uk-margin-remove" action="/planner/add" method="post">
					        @csrf
					        <select name="winery" class="uk-select">
					        	@foreach($favorites as $favorite)
					        		@if(!($plans->contains($favorite->id)))
					        			<option value="{{$favorite->id}}">{{$favorite->name}}</option>
					        		@endif
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
					        		@if(!($plans->contains($wishlist->id)))
					        			<option value="{{$wishlist->id}}">{{$wishlist->name}}</option>
					        		@endif
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
					        		@if(!($plans->contains($visit->id)))
					        			<option value="{{$visit->id}}">{{$visit->name}}</option>
					        		@endif
					        	@endforeach
					        </select>
					        <div class="uk-text-right uk-margin-top">
						        <button type="submit" class="uk-button uk-button-secondary uk-border-rounded uk-display-inline" title="Add">
						        	<span uk-icon="icon: plus"></span>
						        </button>
						    </div>
						</form>
					</div>
				@endif
			</div>
		</div>
	</div>
	<div class="uk-padding-bottom">
		@if(count($plans) >= 1)
			<div class="uk-width-1-1 uk-text-center uk-margin-bottom">
				<form class="uk-form uk-display-inline" action="/planner/clear" method="post">
				    @csrf
				    <input type="hidden" name="_method" value="delete" />
				    <button type="submit" class="uk-link-muted uk-button uk-button-text uk-button-large">
				    	<span uk-icon="icon: trash"></span>
				    		Clear Planner
					</button>
				</form>
			</div>
		@else
			<p class="uk-text-lead"> Planner is empty.</p>
		@endif
	</div>
	@foreach($plans as $plan)
		<div class="uk-card div-border uk-margin-remove uk-padding-small uk-margin-bottom uk-flex uk-flex-middle" id="div_{{$plan->id}}" uk-grid>
			<div>
				@if($plan != $plans->first())
					<form class="uk-form uk-margin-right uk-padding-remove" action="/planner/moveup" method="post">
				        @csrf
				        <input type="hidden" name="order" value="{{$plan->pivot->order}}">
				        <button type="submit" class="uk-button uk-button-default uk-padding-remove">
				        	<span uk-icon="icon: triangle-up"></span>
				    	</button>
					</form>
				@endif
				@if($plan != $plans->last())
					<form class="uk-form uk-margin-right uk-padding-remove" action="/planner/movedown" method="post">
				        @csrf
				        <input type="hidden" name="order" value="{{$plan->pivot->order}}">
				        <button type="submit" class="uk-button uk-button-default uk-padding-remove">
				        	<span uk-icon="icon: triangle-down"></span>
				    	</button>
					</form>
				@endif
			</div>
			<div class="uk-padding-remove uk-margin-remove">
				<span class="uk-text-lead uk-text-bold"><span uk-icon="icon:location"></span>{{$plan->pivot->order}}</span>
			</div>
			
			<div>
				<h3 class="uk-h3 uk-margin-remove"><a class="uk-link uk-display-inline" href="/winery/{{$plan->id}}" target ="_blank">{{$plan->name}}</a></h3>
				<address class="uk-margin-remove">{{$plan->street}}, <br>
					{{$plan->city}}, {{$plan->state}}, {{$plan->zip}}
				</address>
			</div>

		</div>
		<div class="uk-text-right uk-display-block uk-margin-medium-bottom">			
			<form class="uk-form uk-display-inline" action="/planner/remove/{{$plan->id}}" method="post">
		        @csrf
		        <input type="hidden" name="winery_id" value="{{$plan->id}}">
		        <input type="hidden" name="_method" value="delete" />
		        <button type="submit" class="uk-button uk-button-default">
		        	<span uk-icon="icon: trash"></span>
		        	Remove
		    	</button>
			</form>
			<form class="uk-form uk-display-inline" action="/planner/visit" method="post">
		        @csrf
		        <input type="hidden" name="winery_id" value="{{$plan->id}}">
		        <button type="submit" class="uk-button uk-button-default">
		        	<span uk-icon="icon: check"></span>
		        	Visited
		    	</button>
			</form>
		</div>
		{{--<div class="uk-text-left uk-display-inline">
			<a class="">Directions from {{$plan->name}}</a> 
		</div> --}}
	@endforeach
	@if($user->plans()->exists())
         <div class="uk-container uk-margin-medium-top uk-margin-large-bottom">
        	@include('guide.map')
    	</div>
	@endif
</div>



@endsection