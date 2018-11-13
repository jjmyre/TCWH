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

class WishlistController extends Controller
{
    public function wishlist(Request $request) {

    	$winery_id = $request->input('winery_id');

    	Auth::user()->wishlists()->attach($winery_id);

    	$winery = Winery::find($winery_id);

    	return back()->with('status', $winery->name.' was added to your wishlist!');

    }

    public function unwishlist($winery_id) {

    	Auth::user()->wishlists()->detach($winery_id);

    	$winery = Winery::find($winery_id);

    	return back()->with('status', $winery->name.' was removed from your wishlist!');
    }

    public function clear() {

    }
}
