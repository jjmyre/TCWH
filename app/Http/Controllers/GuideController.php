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
        
        $wineries=Winery::all();

        $count=0;
        $citySelect = '';
        $regionSelect = '';
        $sortSelect= '';
        $cityOptions =[];
        $regionOptions= [];
        $subRegionOptions =[];

        foreach($wineries as $winery){
            $count++;
        }

        $wineries->sortBy('region');

        foreach($wineries->unique('region') as $winery) {
            $regionOptions[] = $winery->region;
        }

        $wineries->sortBy('sub_region');

        
        foreach($wineries->unique('sub_region') as $winery) {
            $subRegionOptions[] = $winery->city;
        }

        $wineries->sortBy('city');

        foreach($wineries->unique('city') as $winery) {
            $cityOptions[] = $winery->city;
        }

        $wineries = [];


        return view('guide.default')->with([
            'citySelect' => $citySelect,
            'sortSelect' => $sortSelect,
            'cityOptions' => $cityOptions,
            'regionOptions' => $regionOptions,
            'subRegionOptions' => $subRegionOptions,
            'wineries' => $count,
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

        $cityOptions =[];
        $regionOptions= [];
        $subRegionOptions =[];

        $wineries->sortBy('region');

        foreach($wineries->unique('region') as $winery) {
            $regionOptions[] = $winery->region;
        }

        $wineries->sortBy('sub_region');

        
        foreach($wineries->unique('sub_region') as $winery) {
            $subRegionOptions[] = $winery->city;
        }

        $wineries->sortBy('city');

        foreach($wineries->unique('city') as $winery) {
            $cityOptions[] = $winery->city;
        }

        if($citySelect != 'all'){
            if($sortSelect == "a-z") {
                $wineries = Winery::where('city', '=',
                $citySelect)->orderBy('name', 'asc')->get();
            }  
            elseif($sortSelect == "z-a"){
                $wineries = Winery::where('city', '=',
                $citySelect)->orderBy('name', 'desc')->get();
            }
        }
        else {
            if($sortSelect == "a-z") {
                $wineries = Winery::orderBy('name', 'asc')->paginate(5); 
            }  
            elseif($sortSelect == "z-a"){
                $wineries = Winery::orderBy('name', 'desc')->paginate(5);
            }
        }

        return view('guide.list')->with([
            'citySelect' => $citySelect,
            'sortSelect' => $sortSelect,
            'cityOptions' => $cityOptions,
            'regionOptions' => $regionOptions,
            'subRegionOptions' => $subRegionOptions,
            'wineries' => $wineries,
        ]);
    }
}
