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
use Mail;
use Session;

class AvaMapController extends Controller
{
    public function index() {
    	$user = Auth::user();

    	// get complete list of avas
    	$avaList = Ava::orderBy('name')->get();

        return view('ava.index')->with([
            'user' => $user,
            'avaList' => $avaList
        ]); 
    }

    public function list($ava) {
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

        // get complete list of avas
        $avaList = Ava::orderBy('name')->get();
    	$avaActive = Ava::where('name', $ava)->first();

    	// query the ava pivot table and paginate wineries that are in the active Ava
    	$wineries = Winery::whereHas('avas', function ($query) use ($avaActive) {
    		$query->where('ava_id','=', $avaActive->id);
		})->paginate(10);

    	return view('ava.index')->with([
            'user' => $user,
            'avaList' => $avaList,
            'avaActive' => $avaActive,
            'wineries' => $wineries,
            'allFavorites' => $allFavorites,
            'allWishlists' => $allWishlists,
            'favorites' => $favorites,
            'wishlists' => $wishlists,
            'visits' => $visits,
        ]); 

    }

}