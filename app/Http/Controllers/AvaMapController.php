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

class AvaMapController extends Controller
{
    public function index() {
    	$user = Auth::user();

        return view('ava.index')->with([
            'user' => $user,
        ]); 
    }

    public function list() {
    	return view('ava.index');
    }

}