<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Winery;
use App\Ava;
use App\Time;
use Session;

class HomeController extends Controller
{
    function __invoke(){
        
        $count=0;
        $citySelect = 'default';
        $regionSelect = 'default';
        $sortSelect= 'default';
        $cityOptions =[];
        $regionOptions= [];
        $subRegionOptions =[];

        $wineries = Winery::all();

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

        return view('guide.default')->with([
            'citySelect' => $citySelect,
            'sortSelect' => $sortSelect,
            'cityOptions' => $cityOptions,
            'regionOptions' => $regionOptions,
            'subRegionOptions' => $subRegionOptions,
            'count' => $count,
        ]);
    }
}
