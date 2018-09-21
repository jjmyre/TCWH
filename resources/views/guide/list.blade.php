@extends('layouts.master')

@section('title')
    Winery Guide
@endsection
@section('header')
    Winery Guide
@endsection

@section('content')
    <h1 class="uk-heading-line uk-text-center"><span>Winery Guide</span></h1>
    <form method='GET' action='/guide' name="guideForm" class="guideForm">
        <label>Location:</label>
        <select name="city" id="citySelect">
            <option disabled>-----------------</option>
			<option value='all'>All</option>
            <optgroup label="Tri-Cities">
                <option value='Kennewick'>Kennewick</option>
                <option value='Richland'>Richland</option>
                <option value='Pasco'>Pasco</option>
            </optgroup>
            <option value='Benton City' >Benton City</option>
            <option value='Prosser'>Prosser</option>
            <option value='Border'>Paterson/Oregon</option>
        </select>
        <label>Sort By:</label>
        <select name="sortBy" id="sortSelect">
            <option disabled>-----------------</option>
            <option>Alphabetical (A-Z)</option>
            <option>Alphabetical (Z-A)</option>
            <option>Most Favorited</option>
            <option>Most Visited</option>
            <option>Average Wine Score</option>                  
        </select>
        <input type="submit" value="Go" class="">
    </form>
@endsection
