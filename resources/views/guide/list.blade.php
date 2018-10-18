@extends('layouts.master')

@section('title')
    Winery Guide
    @if($citySelect != 'all' & $citySelect != 'default')
        | {{$citySelect}}
    @elseif($regionSelect != 'all' & $regionSelect != 'default') 
        | {{$regionSelect}} Region
    @endif
@endsection

@section('header')
        <h1 class="uk-heading-primary uk-text-center">Winery Guide</h1>
@endsection

@section('content')
    <div class="uk-flex uk-flex-center uk-grid uk-container" uk-grid>
        <div>
            <ul class="uk-subnav uk-subnav-pill uk-padding-small" uk-switcher="connect: .cityOrRegion">
                @if($cityOrRegion == 'city')
                    <li class="uk-padding-remove uk-active"><a href="#">City</a></li>
                @else
                    <li class="uk-padding-remove"><a href="#">City</a></li>
                @endif
                @if($cityOrRegion == 'region')
                    <li class="uk-padding-remove uk-active"><a href="#">Region</a></li>
                @else
                    <li class="uk-padding-remove"><a href="#">Region</a></li>
                @endif
            </ul>
        </div>
        <div>
            <ul class="uk-subnav uk-subnav-pill uk-padding-small" uk-switcher="connect: .listOrMap">
                <li class="uk-padding-remove"><a href="#">List</a></li>
                <li class="uk-padding-remove"><a href="#">Map</a></li>
            </ul>
        </div>
    </div>
    <div class="uk-switcher cityOrRegion uk-container uk-margin-remove uk-padding-small">
        <form method='get' action='/guide/list/' name="guideCityForm" id="guideCityForm" class="uk-form uk-padding-large uk-flex uk-grid-match uk-child-width-1-3@s" uk-grid>
            <div>
                <label class="uk-form-label" for="citySelect">City</label>                   
                <select name="citySelect" id="citySelect" class="uk-select" required>
                    <option value='' {{ $citySelect == 'default' ? 'SELECTED' : '' }} disabled>Select City</option>
                    <option value='all' {{ $citySelect == 'all' ? 'SELECTED' : '' }}>All Cities</option>
                    @foreach($cityOptions as $cityOption)
                        <option value='{{$cityOption}}' {{ $citySelect == $cityOption ? 'SELECTED' : '' }}>{{$cityOption}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="uk-form-label" for="sortSelect">Sorted By</label>
                <select name="sortSelect" id="sortSelect" class="uk-select">
                    <option value='a-z' {{ $sortSelect == "a-z" ? 'SELECTED' : '' }}>Alphabetical (A-Z)</option>
                    <option value='z-a' {{ $sortSelect == "z-a" ? 'SELECTED' : '' }}>Alphabetical (Z-A)</option>
                    {{--<option>Sort By Most Favorited</option>
                    <option>Most Visited</option>
                    <option>Average Rating</option>--}}             
                </select>
            </div>

            <div class="uk-flex uk-flex-middle">
                <input type="hidden" name="cityOrRegion" value="city">
                <input type="hidden" name="regionSelect" value="default">
                <button type="submit" class="uk-border-rounded uk-button uk-button-secondary">Find Wineries</button>
            </div>
        </form>
        <form method='get' action='/guide/list/' name="guideRegionForm" id="guideRegionForm" class="uk-form uk-padding-large uk-margin-remove-top uk-flex uk-grid-match uk-child-width-1-3@s" uk-grid>
            <div>
                <label class="uk-form-label" for="regionSelect">Wine Region</label>
                <select name="regionSelect" id="regionSelect" class="uk-select" required>
                    <option value='' {{ $regionSelect == 'default' ? 'SELECTED' : '' }} disabled>Select Region</option>
                    <option value='all' {{ $regionSelect == 'all' ? 'SELECTED' : '' }}>All Regions</option>
                    @foreach($regionOptions as $regionOption)
                        <option value='{{$regionOption}}' {{ $regionSelect == $regionOption ? 'SELECTED' : '' }}>{{$regionOption}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="uk-form-label" for="sortSelect">Sorted By</label>
                <select name="sortSelect" class="uk-select">
                    <option value='a-z' {{ $sortSelect == "a-z" ? 'SELECTED' : '' }}>Alphabetical (A-Z)</option>
                    <option value='z-a' {{ $sortSelect == "z-a" ? 'SELECTED' : '' }}>Alphabetical (Z-A)</option>
                {{--<option>Most Favorited</option>
                    <option>Most Visited</option>
                    <option>Average Rating</option>--}}             
                </select>
            </div>
            <div class="uk-flex uk-flex-middle">
                <input type="hidden" name="cityOrRegion" value="region">
                <input type="hidden" name="citySelect" value="default">
                <button type="submit" class="uk-border-rounded uk-button uk-button-secondary">Find Wineries</button>
            </div>
        </form>
    </div>
    <div class="uk-switcher uk-container listOrMap uk-padding-large uk-padding-remove-top">
        <div class="uk-switcher cityOrRegion"> 
            <div>
                @if(!empty($cityWineries))
                    @include('list.city')
                @endif 
            </div>
            <div>
                @if(!empty($regionWineries))
                    @include('list.region')
                @endif
            </div>
        </div>
        <div>
            @include('guide.map')
        </div>
    </div>

@endsection
