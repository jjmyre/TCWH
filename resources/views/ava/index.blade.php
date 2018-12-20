@extends('layouts.master')

@section('title')
    AVA Map
@endsection

@section('header')
	<h1 class="uk-heading-primary uk-text-center">
		@if(isset($avaActive))
        	{{$avaActive->name}} AVA </h1>
            <p class="uk-text-large uk-text-center">For more information on this AVA, visit the
                <a class="uk-link" href="{{$avaActive->info_url}}" target="_blank">Washington State Wine Commission<span uk-icon="icon:link"></span>.</a></p>
        @else
			AVA Map
        @endif
    
@endsection

@section('content')
    <div class="uk-container uk-grid-collapse" uk-grid>
        <div class="uk-flex uk-flex-center uk-flex-middle uk-margin-remove uk-padding-remove uk-width-1-3@m">

    		<ul class="uk-subnav-pill uk-list">
    			@foreach($avaList as $ava)
    				<li class="uk-padding-small-top {{ request()->is('avamap/'.$ava->name) ? 'uk-active' : '' }}"><a class="uk-padding-small uk-text-lead" href="/avamap/{{$ava->name}}">{{$ava->name}}</a></li>
    			@endforeach
    		</ul>
    	</div>
        <div class="ava-map uk-panel uk-width-2-3@m">
            <div>
                @include('ava.svg')
                <p class="uk-text-right">
                    <span class="uk-display-block uk-margin-right" uk-icon="info"></span>

                </p>
            </div>
        </div>
    </div>
    <div class="uk-container uk-column-1-2@m uk-padding uk-margin-top">
        @if(request()->is('avamap'))
            <p class="uk-text-large">AVA stands for American Viticultural Area and the boundaries of these wine-grape growing regions are determined by the Alcohol and Tobacco Tax and Trade Bureau. When an area is given an AVA classification, it is an official and legal designation. Currently, Washington state has 14 such AVAs, the vast majority of which are located east of the Cascade mountains in and around the Columbia Basin. There are many factors that go into designating a Viticultural Area, or what some refer to as an “Appellation”, but the primary reasons involve geographical, environmental and climate-based factors that make these areas ideal for growing grapes specifically for wine-making.</p> 

            <p class="uk-text-large">Some wineries are known for producing wine by harvesting grapes in vineyards located in a specific AVA while other wineries actually purchase their grapes from various AVAs and carefully craft their wines according to the strengths that each AVA offers. For this reason, you will find that many wineries produce wines comprised of grapes from multiple AVAs and it all depends on the grape varietal and the wine-maker’s intended purpose. Furthermore, some wineries have their own vineyards in these AVAs while many others choose to outsource their grapes from independent vineyards.</p>
        @endif
    </div>
	<div class="uk-container">
		@if(isset($wineries))
            <p class="uk-text-large uk-margin-remove-top uk-text-center">
                @if($wineries->total() == 1)
                    1 Winery was found in this AVA.
                @elseif($wineries->total() > 1) 
                    {{$wineries->total()}} Wineries were found in this AVA.
                @elseif($wineries->total() < 1) 
                    No wineries were found in this AVA.
                @endif
            </p>
            @include('guide.list')
		@endif
    </div>

@endsection
