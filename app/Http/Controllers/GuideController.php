<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Winery;
use App\Ava;
use App\Time;
use Session;

class GuideController extends Controller
{

     public function default() {
        
        $wineries = Winery::paginate(20);

        $count=0;
        $citySelect = 'default';
        $regionSelect = 'default';
        $sortSelect= 'default';
        $cityOptions =[];
        $regionOptions= [];
        $subRegionOptions =[];

        foreach($wineries as $winery) {
            $count++;
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
            'count' => $count,
        ]);
    }

    public function list(Request $request) {

        // Validate list/sort and get the values for list

        $this->validate($request, [
            'citySelect' => 'required',
            'sortSelect' => 'required',

        ]);

        $citySelect = $request->input('citySelect');
        $sortSelect = $request->input('sortSelect');

        $wineries = Winery::all();
        $count = 0;

        // initialize location options
        $cityOptions =[];
        $regionOptions= [];
        $subRegionOptions =[];

        // create region options for location select
        foreach($wineries->unique('region') as $winery) {
            $regionOptions[] = $winery->region;
        }

        // create sub_region options for location select
        foreach($wineries->unique('sub_region') as $winery) {
            $subRegionOptions[] = $winery->sub_region;
        }

        $wineries->sortBy('city');
        // create city options for location select
        foreach($wineries->unique('city')->sortBy('city') as $winery) {
            $cityOptions[] = $winery->city;
        }

        if($citySelect != 'all'){
            if($sortSelect == "a-z") {
                $wineries = Winery::where('city', '=',
                $citySelect)->orderBy('name', 'asc')->paginate(8);
            }  
            elseif($sortSelect == "z-a"){
                $wineries = Winery::where('city', '=',
                $citySelect)->orderBy('name', 'desc')->paginate(8);
            } 
        }
        else {
            if($sortSelect == "a-z") {
                $wineries = Winery::orderBy('name', 'asc')->paginate(8); 
            }  
            elseif($sortSelect == "z-a"){
                $wineries = Winery::orderBy('name', 'desc')->paginate(8);
            }
        }

        foreach($wineries as $winery){
            $count++;
        }

        return view('guide.list')->with([
            'citySelect' => $citySelect,
            'sortSelect' => $sortSelect,
            'cityOptions' => $cityOptions,
            'regionOptions' => $regionOptions,
            'subRegionOptions' => $subRegionOptions,
            'count' => $count,
            'wineries' => $wineries,
        ]);
    }

    public function detail($id) {
        $winery = Winery::with('avas')->find($id);

        $avas = [];

        foreach($winery->avas as $ava){
            $avas[] = $ava->name;
        }

        ksort($avas);

        return view('guide.detail')->with([
            'winery' => $winery,
            'avas' => $avas,
        ]);
    }
}
