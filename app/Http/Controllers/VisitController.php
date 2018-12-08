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
        $winery_id = $request->input('winery_id');
        $winery = Winery::find($winery_id);

        if ($visits->contains($winery_id)) {
            return back()->with('status', $winery->name.' was visited again.');
            
        }
        else {
            $user->visits()->attach($winery_id);
            return back()->with('status', $winery->name.' was added to your visited list!');
        }
    }

    public function unvisit() {
    	Auth::user()->visits()->detach($winery_id);

    	$winery = Winery::find($winery_id);

    	return back()->with('status', $winery->name.' was removed from your visited list!');
    }

    public function clear() {
    	Auth::user()->visits()->detach($winery_id);

    	return back()->with('status', 'Your visited list was cleared!');
    }
}
