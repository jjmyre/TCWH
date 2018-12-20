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
use Mapper;
use Geocoder;

class PlannerController extends Controller
{
    public function index() {
        // get authorized user
    	$user = Auth::user();

        $favorites = $user->favorites()->orderBy('name')->get();
        $wishlists = $user->wishlists()->orderBy('name')->get();
        $wineries = Winery::orderby('name')->get();
        $visits = $user->visits()->orderBy('name')->get();
        $plans = $user->plans()->orderby('order')->get();

        if($user->plans()->exists()) {
            // create empty markers array for map
            $markers = [];

            foreach($plans as $wineryMap) {
                // get geo coordinates for each winery
                $geo = Geocoder::getCoordinatesForAddress($wineryMap->street, $wineryMap->city, $wineryMap->state, $wineryMap->zip);

                //get direction link for map
                $directionLink = 'https://www.google.com/maps/dir//'.$wineryMap->name.', '.$wineryMap->street.', '.$wineryMap->state.', '.$wineryMap->zip;
               
                // set markers lats and longs from $geo array
                $markers['latitude'][] = $geo['lat'];
                $markers['longitude'][] = $geo['lng'];
                $markers['content'][] = 
                    "<h4 class='uk-link-reset uk-margin-remove-bottom'>".$wineryMap->name."</h4>".
                    "<address class='uk-margin-remove-top'>".$geo['formatted_address']."</address>".
                    "<a class='uk-link' href='tel:'".$wineryMap->phone.">
                        <span uk-icon='icon:receiver'></span>".$wineryMap->phone."</a>".
                    "<a class='uk-link' href=".$wineryMap->web_url." target='_blank'>
                        <span uk-icon='icon:link'></span>Visit Website</a>".
                    "<a class='uk-link' href=".str_replace(' ', '+', $directionLink)." target='_blank'>
                        <span uk-icon='icon:location'></span>Directions</a>".
                    "<a class='uk-button-primary uk-display-block uk-border-rounded uk-text-center uk-margin-small-top uk-margin-small-bottom' href=".env('APP_URL')."/winery/".$wineryMap->id.">More Details</a>";              
            }
                                   
            // Default map to first marker
            Mapper::map($markers['latitude'][0], $markers['longitude'][0], ['zoom' => 11, 'fullscreenControl' => true, 'center' => true, 'marker' => false, 'cluster' => false, 'clusters' => ['center' => false, 'zoom' => 10, 'size'=> 10], 'language' => 'en']);

            // set labels according to array index
            for($i = 0; $i <= (count($plans)-1); $i++) {
                $labels = (string)($i + 1);

                // create map with markers and labels and info windows
                Mapper::informationWindow($markers['latitude'][$i], $markers['longitude'][$i], $markers['content'][$i], ['animation' => 'DROP', 'label' => $labels]);
            }
        }

        return view('planner.index')->with([
            'user' => $user,
            'favorites' => $favorites,
            'wishlists' => $wishlists,
            'visits' => $visits,
            'wineries' => $wineries,
            'plans' => $plans,
        ]); 
    }

    public function add(Request $request) {
        // get authorized user
        $user = Auth::user();

        // get winery from input and find it from query
        $wineryId = $request->input('winery');
        $winery = Winery::find($wineryId);
        
        $plans = $user->plans()->get();

        // if the plan already contains the winery, do nothing and go back with status message
        if ($plans->contains('id', $wineryId)) {
            return back()->with('status', $winery->name.' is already in your planner.');
            
        }
        // if plan does not have winery but there are more than 9, do nothing and go back with status message 
        elseif(($plans->count() >= 9)){
            return back()->with('status', 'Your planner can only have up to 9 wineries');
        }
        else {
            // get the winery that is last in order from the plan
            $currentPlan = $user->plans()->orderby('order', 'desc')->first();

            if(!empty($currentPlan)){

               // find the very last order number of planner list
                $currentLastOrder = $currentPlan->pivot->order;

                // add 1 to the last order to make this winery last on list
                $newLastOrder = $currentLastOrder + 1;

                // attach new winery to planner with last order number
                $user->plans()->attach($wineryId,  ['order' => $newLastOrder]);
            }
            else {
                //attach new winery to planner with order of 1
                $user->plans()->attach($wineryId,  ['order' => 1]);
            }
                
            // find winery with newly added winery_id
            return back()->with('status', $winery->name.' was added to your planner!');
        }
    }

    public function remove($wineryId) {
        // get authorized user
        $user = Auth::user();

        // selected winery via winery id
        $selectedPlan = $user->plans()->where('winery_id', '=', $wineryId)->first();

        // get the current set order of the selected winery
        $selectedPlanOrder = $selectedPlan->pivot->order;

        // get all planned wineries that have a higher order number than selected winery
        $higherPlans = $user->plans()->where('order', '>', $selectedPlanOrder)->get();

        if(!empty($selectedPlanOrder)) {
            foreach($higherPlans as $higherPlan) {
                // lower the ordering of each planned winery with higher order than current winery
                $higherPlan->pivot->decrement('order');
            }
        }

        // remove the winery from the planner pivot table
        $user->plans()->detach($wineryId);

        // get info of the deleted winery
        $deletedWinery = Winery::find($wineryId);

        return back()->with('status', $deletedWinery->name.' was removed from your planner!');
    }

    public function clear() {

        // get the plans from the authorized user and remove pivot table
        Auth::user()->plans()->detach();
        
        return back()->with('status', 'Your planner was cleared!');
    }

    public function visit(Request $request) {
        $user = Auth::user();
        $wineryId = $request->input('winery_id');
        $winery = Winery::find($wineryId);
        $visits = $user->visits()->get();
        
        // get selected plan via winery_id
        $selectedPlan = $user->plans()->where('winery_id', '=', $wineryId)->first();

        // change pending status to true
        $selectedPlan->pivot->increment('pending');
        
        if ($visits->contains($wineryId)) {
            // find the visited winery, access the pivot and increment the visit tally total
            $visits->where('id', '=', $wineryId)->first()->pivot->increment('tally');

            return back()->with('status', $winery->name.' was visited.');
            
        }
        else {
            // add winery to the visit table if it isn't already
            $user->visits()->attach($wineryId);
            return back()->with('status', $winery->name.' was added to your visited list!');
        }
    }

    public function unvisit($wineryId) {

        $user = Auth::user();
        $winery = Winery::find($wineryId);
        $visits = $user->visits()->get();
        
        // get selected plan via winery_id
        $selectedPlan = $user->plans()->where('winery_id', '=', $wineryId)->first();

        // change pending status to true
        $selectedPlan->pivot->decrement('pending');
        
        if ($visits->contains($wineryId) && ($visits->where('id', '=', $wineryId)->first()->pivot->tally) > 1) {
            // find the visited winery, access the pivot and decrement the visit tally total
            $visits->where('id', '=', $wineryId)->first()->pivot->decrement('tally');
            return back()->with('status', $winery->name.' had its visited status removed.');
            
        }
        else {
            // remove winery to the visit table if it isn't already
            $user->visits()->detach($wineryId);
            return back()->with('status', $winery->name.' was removed from your visited list!');
        }
    }

    // Move the selected planned winery up in order
    public function moveup(Request $request) {
        $user = Auth::user();
        $plans = $user->plans()->get();
        $currentOrder = $request->input('order');

        //assign variable for winery by matching winery_id to pivot
        $selectedPlan = $user->plans()->where('order', '=', $currentOrder)->get();      
      
        //get the plan item that is above the selected plan by order ranking
        $abovePlan = $user->plans()->where('order', '=', $currentOrder-1)->get();

        //decrement the above plan by index to find pivot
        $abovePlan[0]->pivot->increment('order');

        //increment the selected plan and return
        $selectedPlan[0]->pivot->decrement('order');

        return back();

    }

    // Move the selected planned winery down in order
    public function movedown(Request $request) {
        $user = Auth::user();
        $plans = $user->plans()->get();
        $currentOrder = $request->input('order');

        //assign variable for winery by matching winery_id to pivot
        $selectedPlan = $user->plans()->where('order', '=', $currentOrder)->get();      
      
        //get the plan item that is above the selected plan by order ranking
        $belowPlan = $user->plans()->where('order', '=', $currentOrder+1)->get();

        //decrement the above plan by index to find pivot
        $belowPlan[0]->pivot->decrement('order');

        //decrement the selected plan's order and return
        $selectedPlan[0]->pivot->increment('order');

        return back();
    }

}
