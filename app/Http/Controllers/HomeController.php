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
  
        return view('guide.list')->with([
            'wineries' => null,
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


        if($citySelect != 'all'){
            $wineries = Winery::with('times')->where('city', '=',
                $citySelect)->orderBy('name', 'asc')->get();  
        }
        else {
            $wineries = Winery::with('times')->orderBy('name', 'asc')->get(); 
        }

        return view('guide.list')->with([
            'citySelect' => $citySelect,
            'sortSelect' => $sortSelect,
            'wineries' => $wineries,
        ]);
    }
}
