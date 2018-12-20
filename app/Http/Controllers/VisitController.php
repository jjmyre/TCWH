<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Winery;
use App\Visit;
use App\User;
use Session;

use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function visit(Request $request) {
        $user = Auth::user();
        $visits = $user->visits()->get();
        $wineryId = $request->input('winery_id');
        $winery = Winery::find($winery_id);
        
        // if visit exists on list already, just tally the visit total
        if ($visits->contains($wineryId)) {
            $visits->where('id', '=', $wineryId)->first()->pivot->increment('tally');
            return back()->with('status', $winery->name.' was revisited.');
            
        }
        else {
            // add winery to visited list
            $user->visits()->attach($wineryId);

            return back()->with('status', $winery->name.' was added to your visited list!');
        }
    }

    public function unvisit() {
        //remove winery
    	Auth::user()->visits()->detach($winery_id);

    	$winery = Winery::find($winery_id);

    	return back()->with('status', $winery->name.' was removed from your visited list!');
    }

    public function clear() {
        // remove all visited wineries
    	Auth::user()->visits()->detach($winery_id);

    	return back()->with('status', 'Your visited list was cleared!');
    }
}
