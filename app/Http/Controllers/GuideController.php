<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Winery;
use App\Favorite;
use App\Wishlist;
use App\Visit;
use App\Plan;
use App\Ava;
use App\Time;
use App\User;
use Session;
use Mapper;
use Geocoder;

class GuideController extends Controller
{
    public function index() {
        
        $wineries = Winery::paginate(10);
        $wineryOptions = Winery::all();
        $wineryMaps = Winery::all();
        $user = Auth::user();
        if($user) {
            $favorites = $user->favorites()->get();
            $wishlists = $user->wishlists()->get();
            $visits = $user->visits()->get(); 
        } 
        else {
            $favorites = [];
            $wishlists = [];
            $visits = [];
        }
        $allFavorites = Favorite::all();
        $allWishlists = Wishlist::all(); 
        $citySelect = 'all';
        $regionSelect = 'default';
        $sortSelect= '';
        $cityOptions =[];
        $regionOptions= [];
        $subRegionOptions =[];
        $cityOrRegion = 'city';
        $listOrMap = 'list';
        
        foreach($wineryOptions->unique('region')->sortBy('region') as $winery) {
            $regionOptions[] = $winery->region;
        }
        
        foreach($wineryOptions->unique('city')->sortBy('city') as $winery) {
            $cityOptions[] = $winery->city;
        }

        // create markers array with keys but empty values
        $markers = [];

        // foreach to assign markers latitude and longitude from WineryMap collection
        foreach($wineryMaps as $wineryMap) {
            $geo = Geocoder::getCoordinatesForAddress($wineryMap->street, $wineryMap->city, $wineryMap->state, $wineryMap->zip);
            $directionLink = 'https://www.google.com/maps/dir//'.$wineryMap->name.', '.$wineryMap->street.', '.$wineryMap->state.', '.$wineryMap->zip;
           
            $markers['latitude'][] = $geo['lat'];
            $markers['longitude'][] = $geo['lng'];
            $markers['content'][] = 
                "<h4 class='uk-link-reset uk-margin-remove-bottom'>".$wineryMap->name."</h4>".
                "<address class='uk-margin-remove-top'>".$geo['formatted_address']."</address>".
                "<a class='uk-link' href='tel:'".$wineryMap->phone.">
                    <span uk-icon='icon:receiver'></span>".$wineryMap->phone."</a>".
                "<a class='uk-link' href=".$wineryMap->web_url." target='_blank'>
                    <span uk-icon='icon:link'></span>Visit Website</a>".
                "<a class='uk-link' href=".str_replace(' ', '+', $directionLink)." target='_blank'>
                    <span uk-icon='icon:location'></span>Directions</a>".
                "<a class='uk-button-primary uk-display-block uk-border-rounded uk-text-center uk-margin-small-top uk-margin-small-bottom' href=".env('APP_URL')."/winery/".$wineryMap->id.">More Details</a>";          
        }

        // Default map to first marker
        Mapper::map($markers['latitude'][0], $markers['longitude'][0], ['zoom' => 10, 'fullscreenControl' => true, 'center' => true, 'marker' => false, 'cluster' => false, 'clusters' => ['center' => false, 'zoom' => 10, 'size'=> 10], 'language' => 'en']);

        for($i = 0; $i <= (count($wineryMaps)-1); $i++) {
            Mapper::informationWindow($markers['latitude'][$i], $markers['longitude'][$i], $markers['content'][$i], ['animation' => 'DROP']);
        }

        return view('guide.index')->with([
            'citySelect' => $citySelect,
            'regionSelect' => $regionSelect,
            'cityOrRegion' => $cityOrRegion,
            'listOrMap' => $listOrMap,
            'sortSelect' => $sortSelect,
            'cityOptions' => $cityOptions,
            'regionOptions' => $regionOptions,
            'wineries' => $wineries,
            'user' => $user,
            'favorites' => $favorites,
            'wishlists' => $wishlists,
            'visits' => $visits,
            'allFavorites' => $allFavorites,
            'allWishlists' => $allWishlists,
            'visits' => $visits,
        ]);
    }

    public function list(Request $request) {

        // Validate list/sort and get the values for list

        $this->validate($request, [
            'citySelect' => 'required',
            'regionSelect' => 'required',
            'sortSelect' => 'required',
        ]);

        $citySelect = $request->input('citySelect');
        $regionSelect = $request->input('regionSelect');
        $sortSelect = $request->input('sortSelect');
        $listOrMap = $request->input('listOrMap');
        $cityOrRegion = $request->input('cityOrRegion');

        $wineries = Winery::all();
        $wineryMaps = Winery::get();

        $user = Auth::user();

        if($user) {
            $favorites = Auth::user()->favorites()->get();
            $wishlists = Auth::user()->wishlists()->get();
            $visits = Auth::user()->visits()->get(); 
        } 
        else {
            $favorites = [];
            $wishlists = [];
            $visits = [];
        } 

        $allFavorites = Favorite::all();
        $allWishlists = Wishlist::all();

        // initialize location options
        $cityOptions =[];
        $regionOptions= [];
        $subRegionOptions =[];

        // create region options for location select
        foreach($wineries->unique('region')->sortBy('region') as $winery) {
            $regionOptions[] = $winery->region;
        }

        // create sub_region options for location select
        foreach($wineries->unique('sub_region')->sortBy('sub_region') as $winery) {
            $subRegionOptions[] = $winery->sub_region;
        }

        // create city options for location select
        foreach($wineries->unique('city')->sortBy('city') as $winery) {
            $cityOptions[] = $winery->city;
        }

        if($regionSelect == 'default'){
            if($citySelect != 'all'){
                
                $wineryMaps = Winery::where('city', $citySelect)->get();

                if($sortSelect == "a-z") {
                    $wineries = Winery::where('city', $citySelect)->orderBy('name','asc')->paginate(10);
                }
                elseif($sortSelect == "z-a"){
                    $wineries = Winery::where('city', $citySelect)->orderBy('name','desc')->paginate(10);
                }
                 
            }
            elseif($citySelect == 'all') {
                if($sortSelect == "a-z") {
                    $wineries = Winery::orderBy('name','asc')->paginate(10);
                }
                elseif($sortSelect == "z-a"){
                    $wineries = Winery::orderBy('name','desc')->paginate(10);
                }
            }  
        }

        if($citySelect == 'default'){
            if($regionSelect != 'all'){

                $wineryMaps = Winery::where('region', $regionSelect)->get();

                if($sortSelect == "a-z") {
                    $wineries = Winery::where('region', $regionSelect)->orderBy('name','asc')->paginate(10);
                }
                elseif($sortSelect == "z-a"){
                    $wineries = Winery::where('region', $regionSelect)->orderBy('name', 'desc')->paginate(10);
                }
                $wineryMappers = Winery::where('city', $citySelect);       
            }
            elseif($regionSelect == 'all') {
                if($sortSelect == "a-z") {
                    $wineries = Winery::orderBy('name','asc')->paginate(10);
                }
                elseif($sortSelect == "z-a"){
                    $wineries = Winery::orderBy('name','desc')->paginate(10);
                }    
            } 
        }
        
        // create markers array with keys but empty values
        $markers = [];

        // foreach to assign markers latitude and longitude from WineryMap collection
        foreach($wineryMaps as $wineryMap) {
            $geo = Geocoder::getCoordinatesForAddress($wineryMap->street, $wineryMap->city, $wineryMap->state, $wineryMap->zip);
            $directionLink = 'https://www.google.com/maps/dir//'.$wineryMap->name.', '.$wineryMap->street.', '.$wineryMap->state.', '.$wineryMap->zip;
           
            $markers['latitude'][] = $geo['lat'];
            $markers['longitude'][] = $geo['lng'];
            $markers['content'][] = 
                "<h4 class='uk-link-reset uk-margin-remove-bottom'>".$wineryMap->name."</h4>".
                "<address class='uk-margin-remove-top'>".$geo['formatted_address']."</address>".
                "<a class='uk-link' href='tel:'".$wineryMap->phone.">
                    <span uk-icon='icon:receiver'></span>".$wineryMap->phone."</a>".
                "<a class='uk-link' href=".$wineryMap->web_url." target='_blank'>
                    <span uk-icon='icon:link'></span>Visit Website</a>".
                "<a class='uk-link' href=".str_replace(' ', '+', $directionLink)." target='_blank'>
                    <span uk-icon='icon:location'></span>Directions</a>".
                "<a class='uk-button-primary uk-display-block uk-border-rounded uk-text-center uk-margin-small-top uk-margin-small-bottom' href=".env('APP_URL')."/winery/".$wineryMap->id.">More Details</a>";              
        }

        // Default map to first marker
        Mapper::map($markers['latitude'][0], $markers['longitude'][0], ['zoom' => 10, 'fullscreenControl' => true, 'center' => true, 'marker' => false, 'cluster' => false, 'clusters' => ['center' => false, 'zoom' => 10, 'size'=> 10], 'language' => 'en']);

        for($i = 0; $i <= (count($wineryMaps)-1); $i++) {
            Mapper::informationWindow($markers['latitude'][$i], $markers['longitude'][$i], $markers['content'][$i], ['animation' => 'DROP']);
        }

        return view('guide.index')->with([
            'citySelect' => $citySelect,
            'regionSelect' => $regionSelect,
            'listOrMap' => $listOrMap,
            'sortSelect' => $sortSelect,
            'cityOptions' => $cityOptions,
            'regionOptions' => $regionOptions,
            'subRegionOptions' => $subRegionOptions,
            'cityOrRegion' => $cityOrRegion,
            'wineries' => $wineries,
            'user' => $user,
            'favorites' => $favorites,
            'wishlists' => $wishlists,
            'visits' => $visits,
            'allFavorites' => $allFavorites,
            'allWishlists' => $allWishlists,
        ]);
    }

    public function detail($id) {
        $winery = Winery::with('avas')->find($id);
        $user = Auth::user();

        if($user) {
            $favorites = Auth::user()->favorites()->get();
            $wishlists = Auth::user()->wishlists()->get();
            $visits = Auth::user()->visits()->get(); 
        } 
        else {
            $favorites = [];
            $wishlists = [];
            $visits = [];
        }
        
        $allFavorites = Favorite::all();
        $allWishlists = Wishlist::all(); 
        $avas = [];
        foreach($winery->avas as $ava){
            $avas[] = $ava->name;
        }
        ksort($avas);
        
        // Business Hours
        $time = $winery->time;

        // create markers array with keys but empty values
        $marker = [];


        $geo = Geocoder::getCoordinatesForAddress($winery->street, $winery->city, $winery->state, $winery->zip);
        $directionLink = 'https://www.google.com/maps/dir//'.$winery->name.', '.$winery->street.', '.$winery->state.', '.$winery->zip;
       
        $marker['latitude'] = $geo['lat'];
        $marker['longitude'] = $geo['lng'];
        $marker['content'] = 
            "<h4 class='uk-link-reset uk-margin-remove-bottom'>".$winery->name."</h4>".
            "<address class='uk-margin-remove-top'>".$geo['formatted_address']."</address>".
            "<a class='uk-link' href=".str_replace(' ', '+', $directionLink)." target='_blank'>
                <span uk-icon='icon:location'></span>Directions</a>";                        


        // Default map to marker
        Mapper::map($marker['latitude'], $marker['longitude'], ['zoom' => 15, 'fullscreenControl' => true, 'center' => true, 'marker' => true, 'cluster' => false, 'language' => 'en']);

    //    Mapper::marker($marker['latitude'], $marker['longitude'], ['animation' => 'DROP']);

        Mapper::informationWindow($marker['latitude'], $marker['longitude'], $marker['content'], ['open' => true]);

        return view('guide.detail')->with([
            'winery' => $winery,
            'avas' => $avas,
            'time' => $time,
            'user' => $user,
            'favorites' => $favorites,
            'wishlists' => $wishlists,
            'allFavorites' => $allFavorites,
            'allWishlists' => $allWishlists,
            'visits' => $visits,
        ]);
    }
}