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
        $user = Auth::user();
        $wishlists = $user->wishlists()->get();
        $winery_id = $request->input('winery_id');
        $winery = Winery::find($winery_id);

        if ($wishlists->contains($winery_id)) {
            return back()->with('status', $winery->name.' is already in your wish list.');
        }
        else {
            $user->wishlists()->attach($winery_id);
            return back()->with('status', $winery->name.' was added to your wish list!');
        }
    }

    public function unwishlist($winery_id) {
        //remove selected winery
    	Auth::user()->wishlists()->detach($winery_id);

    	$winery = Winery::find($winery_id);

    	return back()->with('status', $winery->name.' was removed from your wish list!');
    }

    public function clear() {
        // remove all wish listed wineries
    	Auth::user()->wishlists()->detach();
    	
    	return back()->with('status', 'Your wish list was cleared!');

    }
}
