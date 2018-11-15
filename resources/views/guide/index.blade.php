@extends('layouts.master')

@section('title')
    Winery Guide
    @if($citySelect != 'default' && $citySelect != 'all')
        | {{$citySelect}}
    @elseif($citySelect == 'all')
        | All Cities
    @elseif($regionSelect != 'default' && $regionSelect != 'all') 
        | {{$regionSelect}} Region
    @elseif($regionSelect == 'all')
        | All Regions
    @endif
@endsection

@section('header')
        <h1 class="uk-heading-primary uk-text-center">Winery Guide</h1>
@endsection

@section('content')
    <div class="uk-flex uk-flex-center uk-grid uk-container" uk-grid>
        <ul class="uk-subnav uk-subnav-pill uk-padding-small" uk-switcher="connect: .listOrMap">
            <li class="uk-padding-remove"><a href="#">List</a></li>
            <li class="uk-padding-remove"><a href="#">Map</a></li>
        </ul>
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
    <div class="uk-switcher cityOrRegion uk-container uk-margin-remove uk-padding-small">
        <form method='get' action='/guide/list/' name="guideCityForm" id="guideCityForm" class="uk-form uk-padding-large uk-flex uk-grid-match uk-child-width-1-3@s" uk-grid>

            <div>
                <label class="uk-form-label" for="citySelect">Location</label>                   
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
                </select>
            </div>

            <div class="uk-flex-middle uk-flex">
                <input type="hidden" name="cityOrRegion" value="city">
                <input type="hidden" name="regionSelect" value="default">
                <button type="submit" class="uk-button uk-button-secondary">Find Wineries</button>
            </div>
        </form>
        <form method='get' action='/guide/list/' name="guideRegionForm" id="guideRegionForm" class="uk-form uk-padding-large uk-margin-remove-top uk-flex uk-grid-match uk-child-width-1-3@s" uk-grid>
            <div>
                <label class="uk-form-label" for="regionSelect">Location</label>
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
        <div>
            @yield('list')
        </div>

        <div>
            @yield('map')      
        </div>
    </div>
@endsection
