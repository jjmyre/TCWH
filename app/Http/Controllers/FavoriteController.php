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

class FavoriteController extends Controller
{
    public function favorite(Request $request) {

    	$winery_id = $request->input('winery_id');

    	Auth::user()->favorites()->attach($winery_id);

    	$winery = Winery::find($winery_id);

    	return back()->with('status', $winery->name.' was added to your favorites!');
    }

    public function unfavorite($winery_id) {

    	Auth::user()->favorites()->detach($winery_id);

    	$winery = Winery::find($winery_id);

    	return back()->with('status', $winery->name.' was removed from your favorites!');

    }

    public function clear() {

    }

}
