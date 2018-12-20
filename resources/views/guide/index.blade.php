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
    <div class="uk-flex uk-flex-center uk-margin-remove uk-padding-remove" uk-grid>
        <ul class="uk-subnav uk-subnav-pill uk-margin-right uk-margin-remove-left uk-padding-remove" uk-switcher="connect: .cityOrRegion">
            <li class="uk-padding-remove {{ $cityOrRegion == 'city' ? 'uk-active' : '' }}"><a href="#">City</a></li>
            <li class="uk-padding-remove {{ $cityOrRegion == 'region' ? 'uk-active' : '' }}"><a href="#">Region</a></li>
        </ul>
        <ul class="uk-subnav uk-subnav-pill uk-margin-left uk-margin-remove-right uk-padding-remove" uk-switcher="connect: .listOrMap">
            <li class="uk-padding-remove {{ $listOrMap == 'list' ? 'uk-active' : '' }}"><a href="#">List</a></li>
            <li class="uk-padding-remove {{ $listOrMap == 'map' ? 'uk-active' : '' }}"><a href="#">Map</a></li>
        </ul>
    </div>
    <div class="uk-switcher uk-container listOrMap uk-padding-large uk-padding-remove-top">
        <div class="listSection">
            <div class="uk-switcher cityOrRegion">
                <form method='get' action='/guide/list/' name="listCityForm" id="listCityForm" class="uk-form uk-padding uk-margin-remove">
                    <div class="uk-child-width-1-2@s" uk-grid>
                        <div>
                            <label class="visuallyHidden" for="citySelect">City</label>                   
                            <select name="citySelect" id="citySelect" class="uk-select" required>
                                <option value='' {{ $citySelect == 'default' ? 'SELECTED' : '' }} disabled>SELECT CITY</option>
                                <option value='all' {{ $citySelect == 'all' ? 'SELECTED' : '' }}>All Cities</option>
                                @foreach($cityOptions as $cityOption)
                                    <option value='{{$cityOption}}' {{ $citySelect == $cityOption ? 'SELECTED' : '' }}>{{$cityOption}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="visuallyHidden" for="sortSelect">Sort</label>
                            <select name="sortSelect" id="sortSelect" class="uk-select" required>
                                <option value='a-z' {{ $sortSelect == "a-z" ? 'SELECTED' : '' }}>A&#8594;Z</option>
                                <option value='z-a' {{ $sortSelect == "z-a" ? 'SELECTED' : '' }}>Z&#8594;A</option>           
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="cityOrRegion" value="city">
                    <input type="hidden" name="listOrMap" value="list">
                    <input type="hidden" name="regionSelect" value="default">
                    <div class="uk-text-right uk-margin-top">
                        <button type="submit" class="uk-button uk-button-secondary uk-border-rounded uk-padding-small uk-padding-remove-top uk-padding-remove-bottom">
                            <span uk-icon="icon: search"></span>                     
                        </button>
                    </div>
                </form>
                <form method='get' action='/guide/list/' name="listRegionForm" id="listRegionForm" class="uk-form uk-padding uk-margin-remove">
                    <div class="uk-child-width-1-2@s" uk-grid>
                        <div>
                            <label class="visuallyHidden" for="regionSelect">Location</label>
                            <select name="regionSelect" id="regionSelect" class="uk-select" required>
                                <option value='' {{ $regionSelect == 'default' ? 'SELECTED' : '' }} disabled>SELECT REGION</option>
                                <option value='all' {{ $regionSelect == 'all' ? 'SELECTED' : '' }}>All Regions</option>
                                @foreach($regionOptions as $regionOption)
                                    <option value='{{$regionOption}}' {{ $regionSelect == $regionOption ? 'SELECTED' : '' }}>{{$regionOption}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="visuallyHidden" for="sortSelect">Sorted By</label>
                            <select name="sortSelect" class="uk-select" required>
                                <option value='a-z' {{ $sortSelect == "a-z" ? 'SELECTED' : '' }}>A&#8594;Z</option>
                                <option value='z-a' {{ $sortSelect == "z-a" ? 'SELECTED' : '' }}>Z&#8594;A</option>         
                            </select>
                            <div class="uk-text-right uk-margin-top">
                                <button type="submit" class="uk-button uk-button-secondary uk-border-rounded uk-padding-small uk-padding-remove-top uk-padding-remove-bottom">
                                    <span uk-icon="icon: search"></span>                     
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="cityOrRegion" value="region">
                    <input type="hidden" name="listOrMap" value="list">
                    <input type="hidden" name="citySelect" value="default">
                </form>
            </div>
            <div class="uk-text-center">
                @if($citySelect != 'default')
                    <h2 class="uk-text uk-margin-remove-bottom">
                    @if($citySelect == 'all')
                        All Cities</h2>
                    @else
                        {{$citySelect}}</h2>
                    @endif
                @endif

                @if($regionSelect != 'default')
                    <h2 class="uk-text uk-margin-remove-bottom">
                    @if($regionSelect == 'all')
                       All Regions</h2>
                    @else
                        {{$regionSelect}}</h2>
                    @endif
                @endif
            </div>

            <p class="uk-text uk-margin-remove-top uk-text-center">
                @if($wineries->total() == 1)
                    1 Winery
                @elseif($wineries->total() > 1) 
                    {{$wineries->total()}} Wineries
                @elseif($wineries->total() < 1) 
                    No wineries were found
                @endif
            </p>

            @include('guide.list')

        </div>
        <div class="mapSection">
            <div class="uk-switcher cityOrRegion">
                <form method='get' action='/guide/list/' name="mapCityForm" id="mapCityForm" class="uk-form uk-padding uk-margin-remove">
                    <div class="uk-child-width-1-1@s" uk-grid>
                        <div>
                            <label class="visuallyHidden" for="mapCitySelect">City</label>                   
                            <select name="citySelect" id="mapCitySelect" class="uk-select" required>
                                <option value='' {{ $citySelect == 'default' ? 'SELECTED' : '' }} disabled>SELECT CITY</option>
                                <option value='all' {{ $citySelect == 'all' ? 'SELECTED' : '' }}>All Cities</option>
                                @foreach($cityOptions as $cityOption)
                                    <option value='{{$cityOption}}' {{ $citySelect == $cityOption ? 'SELECTED' : '' }}>{{$cityOption}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="cityOrRegion" value="city">
                    <input type="hidden" name="listOrMap" value="map">
                    <input name="sortSelect" type="hidden" value="a-z">
                    <input type="hidden" name="regionSelect" value="default">
                    <div class="uk-text-right uk-margin-top">
                        <button type="submit" class="uk-button uk-button-secondary uk-border-rounded uk-padding-small uk-padding-remove-top uk-padding-remove-bottom">
                            <span uk-icon="icon: search"></span>                     
                        </button>
                    </div>
                </form>
                <form method='get' action='/guide/list/' name="mapRegionForm" id="mapRegionForm" class="uk-form uk-padding uk-margin-remove">
                    <div class="uk-child-width-1-1@s" uk-grid>
                        <div>
                            <label class="visuallyHidden" for="mapRegionSelect">Location</label>
                            <select name="regionSelect" id="mapRegionSelect" class="uk-select" required>
                                <option value='' {{ $regionSelect == 'default' ? 'SELECTED' : '' }} disabled>SELECT REGION</option>
                                <option value='all' {{ $regionSelect == 'all' ? 'SELECTED' : '' }}>All Regions</option>
                                @foreach($regionOptions as $regionOption)
                                    <option value='{{$regionOption}}' {{ $regionSelect == $regionOption ? 'SELECTED' : '' }}>{{$regionOption}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="cityOrRegion" value="region">
                    <input type="hidden" name="listOrMap" value="map">
                    <input name="sortSelect" type="hidden" value="a-z">
                    <input type="hidden" name="citySelect" value="default">
                    <div class="uk-text-right uk-margin-top">
                        <button type="submit" class="uk-button uk-button-secondary uk-border-rounded uk-padding-small uk-padding-remove-top uk-padding-remove-bottom">
                            <span uk-icon="icon: search"></span>                     
                        </button>
                    </div>
                </form>
            </div>
            <div class="uk-text-center">
                @if($citySelect != 'default')
                    <h2 class="uk-text uk-margin-remove-bottom">
                    @if($citySelect == 'all')
                        All Cities</h2>
                    @else
                        {{$citySelect}}</h2>
                    @endif
                @endif

                @if($regionSelect != 'default')
                    <h2 class="uk-text uk-margin-remove-bottom">
                    @if($regionSelect == 'all')
                       All Regions</h2>
                    @else
                        {{$regionSelect}}</h2>
                    @endif
                @endif
            </div>

            <p class="uk-text-muted uk-margin-remove-top uk-text-center">
                @if($wineries->total() == 1)
                    1 Winery
                @elseif($wineries->total() > 1) 
                    {{$wineries->total()}} Wineries
                @elseif($wineries->total() < 1) 
                    No wineries were found
                @endif
            </p>

            @include('guide.map')
            
        </div>
    </div>
@endsection


