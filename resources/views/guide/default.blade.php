@extends('layouts.master')

@section('title')
    Winery Guide
@endsection

@section('header')
    Winery Guide
@endsection

@section('content')
    <form method='get' action='/guide/list' name="guideForm" id="guideForm" class=" uk-grid-small uk-padding-large" uk-grid>
        <div class="uk-width-1-2@s">
            <label class="uk-label" for="citySelect">Location</label>
            <select name="citySelect" id="citySelect" class="uk-select">
                <option value='default' selected>Select City</option>
                <option value='all'>All</option>
                @foreach($cityOptions as $cityOption)
                    <option value='{{$cityOption}}'>{{$cityOption}}</option>
                @endforeach
            </select>
            {{--<label class="uk-label" for="regionSelect">Location</label>
            <select name="regionSelect" id="regionSelect" class="uk-select">
                <option value='all'>All</option>
                @foreach($regionOptions as $regionOption)
                    <option value='{{$regionOption}}'>{{$regionOption}}</option>
                @endforeach
            </select>--}}
        </div>
        <div class="uk-width-1-2@s">
            <label class="uk-label" for="sortSelect">Sort By</label>
            <select name="sortSelect" id="sortSelect" class="uk-select">
                <option value='a-z' {{ $sortSelect == "a-z" ? 'SELECTED' : '' }}>Alphabetical (A-Z)</option>
                <option value='z-a' {{ $sortSelect == "z-a" ? 'SELECTED' : '' }}>Alphabetical (Z-A)</option>
            {{--<option>Most Favorited</option>
                <option>Most Visited</option>
                <option>Average Rating</option>--}}             
            </select>
        </div>
        <br>
        <div class="uk-width-1-2@s">
            <button id="advanced-button" class="uk-button uk-button-link uk-padding-small" uk-toggle="target: #advanced-options; animation: uk-animation-fade">Advanced Options</button>
            <div id="advanced-options" hidden>
                <fieldset class="uk-fieldset">
                    <legend>Production Size</legend>
                    <input type="checkbox" id="boutique" name="size" value="boutique" checked/>
                    <label for="boutique">Boutique</label>
                    <input type="checkbox" id="medium" name="size" value="medium" checked/>
                    <label for="medium">Medium</label>
                    <input type="checkbox" id="large" name="size" value="large" checked/>
                    <label for="large">Large</label>
                </fieldset>
                <fieldset class="uk-fieldset">
                    <legend>Dining Option</legend>
                    <input type="checkbox" id="dining_option" name="dining" value="boutique"/>
                    <label for="dining_option">Dining Only</label>
                </fieldset>
            </div>
            <button type="submit" class="uk-button uk-button-primary">Go</button>
        </div>
    </form>
@endsection