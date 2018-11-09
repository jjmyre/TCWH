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

class PlannerController extends Controller
{
    public function index() {
    	$user = Auth::user();

        return view('planner.index')->with([
            'user' => $user,
        ]); 
    }

    public function add() {

    }

    public function move() {

    }

    public function remove() {

    }

    public function clear() {

    }
}
