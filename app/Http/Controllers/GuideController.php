<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Winery;
use App\Ava;
use App\Time;
use App\User;
use Session;

class GuideController extends Controller
{

     public function index() {
        
        $wineries = Winery::all();

        $totalCount=0;
        $citySelect = 'default';
        $regionSelect = 'default';
        $sortSelect= '';
        $cityOptions =[];
        $regionOptions= [];
        $subRegionOptions =[];
        $cityOrRegion = 'city';
        $listOrMap = 'list';
        $cityWineries = '';
        $regionWineries = ''; 

        $user = User::findOrFail($id)->all();

        foreach($wineries as $winery) {
            $totalCount++;
        }
        
        foreach($wineries->unique('region')->sortBy('region') as $winery) {
            $regionOptions[] = $winery->region;
        }
        
        foreach($wineries->unique('sub_region')->sortBy('sub_region') as $winery) {
            $subRegionOptions[] = $winery->city;
        }

        foreach($wineries->unique('city')->sortBy('city') as $winery) {
            $cityOptions[] = $winery->city;
        }

        return view('guide.list')->with([
            'citySelect' => $citySelect,
            'regionSelect' => $regionSelect,
            'sortSelect' => $sortSelect,
            'cityOptions' => $cityOptions,
            'regionOptions' => $regionOptions,
            'subRegionOptions' => $subRegionOptions,
            'wineries' => $wineries,
            'totalCount' => $totalCount,
            'cityOrRegion' => $cityOrRegion,
            'cityWineries' => $cityWineries,
            'regionWineries' => $regionWineries,
            'user' => $user,
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
        $cityCount = 0;
        $regionCount = 0;
        $totalCount = 0;

        foreach($wineries as $winery){
            $totalCount++;
        }

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

        if(!empty($citySelect)){
            if($citySelect != 'all' && $citySelect != 'default'){
                if($sortSelect == "a-z") {
                    $cityWineries = Winery::where('city', $citySelect)->orderBy('name','asc')->paginate(8);
                }
                elseif($sortSelect == "z-a"){
                    $cityWineries = Winery::where('city', $citySelect)->orderBy('name','desc')->paginate(8);
                }
                $cityCount = $cityWineries->total();    
            }
            elseif($citySelect == 'all') {
                if($sortSelect == "a-z") {
                    $cityWineries = Winery::orderBy('name','desc')->paginate(8);
                }
                elseif($sortSelect == "z-a"){
                    $cityWineries = Winery::orderBy('name','desc')->paginate(8);
                }
                $cityCount = $cityWineries->total();   
            }
            else{
                $cityWineries = [];
                $cityCount = '';
            }       
        }

        if(!empty($regionSelect)){
            if($regionSelect != 'all' && $regionSelect != 'default'){
                if($sortSelect == "a-z") {
                    $regionWineries = Winery::where('region', $regionSelect)->orderBy('name','asc')->paginate(8);
                }
                elseif($sortSelect == "z-a"){
                    $regionWineries = Winery::where('region', $regionSelect)->orderBy('name', 'desc')->paginate(8);
                }
                $regionCount = $regionWineries->total();
                  
            }
            elseif($regionSelect == 'all') {
                if($sortSelect == "a-z") {
                    $regionWineries = Winery::orderBy('name','asc')->paginate(8);
                }
                elseif($sortSelect == "z-a"){
                    $regionWineries = Winery::orderBy('name', 'desc')->paginate(8);
                }
                $regionCount = $regionWineries->total();    
            }
            else{
                $regionWineries = [];
                $regionCount = '';
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
            'cityCount' => $cityCount,
            'regionCount' => $regionCount,
            'totalCount' => $totalCount,
            'cityWineries' => $cityWineries,
            'regionWineries' => $regionWineries,
        ]);
    }

    public function detail($id) {
        $winery = Winery::with('avas')->find($id);

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
        ]);
    }
}
