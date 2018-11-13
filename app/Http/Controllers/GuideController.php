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

class GuideController extends Controller
{

    public function index() {
        
        $wineries = Winery::all();
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
        $members = User::all();
        $allFavorites = Favorite::all();
        $allWishlists = Wishlist::all(); 

        $wineryCount=$wineries->count();
        $citySelect = 'default';
        $regionSelect = 'default';
        $sortSelect= '';
        $cityOptions =[];
        $regionOptions= [];
        $subRegionOptions =[];
        $cityOrRegion = 'city';
        $listOrMap = 'list';

        
        
        foreach($wineries->unique('region')->sortBy('region') as $winery) {
            $regionOptions[] = $winery->region;
        }
        
        foreach($wineries->unique('sub_region')->sortBy('sub_region') as $winery) {
            $subRegionOptions[] = $winery->city;
        }

        foreach($wineries->unique('city')->sortBy('city') as $winery) {
            $cityOptions[] = $winery->city;
        }

        return view('guide.index')->with([
            'citySelect' => $citySelect,
            'regionSelect' => $regionSelect,
            'sortSelect' => $sortSelect,
            'cityOptions' => $cityOptions,
            'regionOptions' => $regionOptions,
            'subRegionOptions' => $subRegionOptions,
            'wineryCount' => $wineryCount,
            'cityOrRegion' => $cityOrRegion,
            'wineries' => $wineries,
            'user' => $user,
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
        $listOrMap = $request->input('mapSelect');
        $cityOrRegion = $request->input('cityOrRegion');

        $wineries = Winery::all();
        $wineryCount = 0;

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
        $members = User::all();
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

        if($citySelect != '' && $regionSelect == 'default'){
            if($citySelect != 'all'){
                if($sortSelect == "a-z") {
                    $wineries = Winery::where('city', $citySelect)->orderBy('name','asc')->paginate(10);
                }
                elseif($sortSelect == "z-a"){
                    $wineries = Winery::where('city', $citySelect)->orderBy('name','desc')->paginate(10);
                }
                $wineryCount = $wineries->total();    
            }
            elseif($citySelect == 'all') {
                if($sortSelect == "a-z") {
                    $wineries = Winery::orderBy('name','asc')->paginate(10);
                }
                elseif($sortSelect == "z-a"){
                    $wineries = Winery::orderBy('name','desc')->paginate(10);
                }
                $wineryCount = $wineries->total();   
            }  
        }

        if($regionSelect != '' && $citySelect == 'default'){
            if($regionSelect != 'all'){
                if($sortSelect == "a-z") {
                    $wineries = Winery::where('region', $regionSelect)->orderBy('name','asc')->paginate(10);
                }
                elseif($sortSelect == "z-a"){
                    $wineries = Winery::where('region', $regionSelect)->orderBy('name', 'desc')->paginate(10);
                }
                $wineryCount = $wineries->total();
                  
            }
            elseif($regionSelect == 'all') {
                if($sortSelect == "a-z") {
                    $wineries = Winery::orderBy('name','asc')->paginate(10);
                }
                elseif($sortSelect == "z-a"){
                    $regionWineries = Winery::orderBy('name', 'desc')->paginate(10);
                }
                $wineryCount = $wineries->total();    
            } 
        }

        return view('guide.list')->with([
            'citySelect' => $citySelect,
            'regionSelect' => $regionSelect,
            'listOrMap' => $listOrMap,
            'sortSelect' => $sortSelect,
            'cityOptions' => $cityOptions,
            'regionOptions' => $regionOptions,
            'subRegionOptions' => $subRegionOptions,
            'cityOrRegion' => $cityOrRegion,
            'wineryCount' => $wineryCount,
            'wineries' => $wineries,
            'user' => $user,
            'favorites' => $favorites,
            'wishlists' => $wishlists,
            'allFavorites' => $allFavorites,
            'allWishlists' => $allWishlists,
            'visits' => $visits,
        ]);
    }

    public function detail($id) {
        $winery = Winery::with('avas')->find($id);
        $user = Auth::user();
        $members = User::all();

        $avas = [];

        foreach($winery->avas as $ava){
            $avas[] = $ava->name;
        }

        ksort($avas);
        
        // Time Variables
        $time = $winery->time;


        return view('guide.detail')->with([
            'winery' => $winery,
            'avas' => $avas,
            'time' => $time,
            'user' => $user,
            'members' => $members
        ]);
    }
}
