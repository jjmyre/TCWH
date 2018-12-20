<?php

namespace App\Http\Controllers;

// Dependencies
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
use Mail;
use Session;
use Mapper;
use Geocoder;

class GuideController extends Controller
{
    public function index() {
        // get all wineries and paginate
        $wineries = Winery::paginate(10);

        // get all wineries to be used for options
        $wineryOptions = Winery::all();

        // get all wineries for maps
        $wineryMaps = Winery::all();

        // get authorized user
        $user = Auth::user();

        // wish lists, visits, favorites if user
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
        
        // dynamically generate region options for form
        foreach($wineryOptions->unique('region')->sortBy('region') as $winery) {
            $regionOptions[] = $winery->region;
        }
        
        // dynamically generate city options for form
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
            // content for map info window
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

        // set information markers for map
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

        // retrieve values from form inputs
        $citySelect = $request->input('citySelect');
        $regionSelect = $request->input('regionSelect');
        $sortSelect = $request->input('sortSelect');
        $listOrMap = $request->input('listOrMap');
        $cityOrRegion = $request->input('cityOrRegion');

        // get all wineries
        $wineries = Winery::all();
        $wineryMaps = Winery::get();

        $user = Auth::user();

        // wish lists, visits, favorites if user
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
            // content for information windows on map
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

        // set information markers dfor each winery on map
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

        // get nearby wineries by collecting wineries in the same city (with enough wineries, it would be sub_region)
        $nearbyWineries = Winery::where('city', '=', $winery->city)->where('id', '!=', $winery->id)->orderBy('name')->get();

        if($user) {
            $favorites = $user->favorites()->get();
            $wishlists = $user->wishlists()->get();
            $visits = $user->visits()->get();
            $plans = $user->plans()->get(); 
        } 
        else {
            $favorites = [];
            $wishlists = [];
            $visits = [];
            $plans = [];
        }
        // empty array for avas
        $avas = [];
        //set avas
        foreach($winery->avas as $ava){
            $avas[] = $ava->name;
        }
        // alphabetize avas in list
        ksort($avas);
        
        // Business Hours
        $time = $winery->time;

        // create empty markers array
        $marker = [];

        // use Geocoder package for coordinates
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

        Mapper::informationWindow($marker['latitude'], $marker['longitude'], $marker['content'], ['open' => true]);

        return view('guide.detail')->with([
            'winery' => $winery,
            'avas' => $avas,
            'time' => $time,
            'nearbyWineries' => $nearbyWineries,
            'user' => $user,
            'favorites' => $favorites,
            'wishlists' => $wishlists,
            'plans' => $plans,
            'visits' => $visits,
        ]);
    }

    public function mistake(Request $request) {
        $user = Auth::user();
        $name = $user->username;
        $email = $user->email;

        // validate contact form inputs
        $this->validate($request, [
            'mistake' => 'required',
            'description' => 'required|string|min:10|max:500',
        ]);

        // retrieve data from inputs and assign to variables
        $mistake = $request->input('mistake');
        $description = $request->input('description');
        $wineryId = $request->input('winery_id');

        // get winery
        $winery = Winery::find($wineryId);

        //create string for winery description
        $problemWinery = $winery->name.' [ ID:'.$winery->id.' ]';

        // create array from the data and auth user information
        $data = array(
            'description' => $description,
            'mistake' => $mistake,
            'name' => $name,
            'email' => $email,
            'problemWinery' => $problemWinery,
        );

        // Mail out message with data array
        Mail::send('emails.mistake', $data, function($message) use ($email, $name, $mistake, $problemWinery){
            $message->from($email, $name);
            $message->to('admin@tcwinehub.com', 'admin');
            $message->subject('Mistake: '.$mistake.' - '.$problemWinery);
        });

        return back()->with('status', 'Message was sent. Thanks for helping us out!');

    }  
}