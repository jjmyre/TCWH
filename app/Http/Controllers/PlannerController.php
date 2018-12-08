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
    	$user = Auth::user();
        $favorites = $user->favorites()->orderBy('name')->get();
        $wishlists = $user->wishlists()->orderBy('name')->get();
        $wineries = Winery::orderby('name')->get();
        $visits = $user->visits()->orderBy('name')->get();
        $plans = $user->plans()->orderby('order')->get();
        //$firstPlan = $plans->first();
        //$lastPlan = $user->plans()->orderby('order')->first();

        if($user->plans()->exists()) {
            // create markers array with keys but empty values
            $markers = [];

            foreach($plans as $wineryMap) {
                $geo = Geocoder::getCoordinatesForAddress($wineryMap->street, $wineryMap->city, $wineryMap->state, $wineryMap->zip);
                $directionLink = 'https://www.google.com/maps/dir//'.$wineryMap->name.', '.$wineryMap->street.', '.$wineryMap->state.', '.$wineryMap->zip;
               
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
            Mapper::map($markers['latitude'][0], $markers['longitude'][0], ['zoom' => 10, 'fullscreenControl' => true, 'center' => true, 'marker' => false, 'cluster' => false, 'clusters' => ['center' => false, 'zoom' => 10, 'size'=> 10], 'language' => 'en']);

            for($i = 0; $i <= (count($plans)-1); $i++) {
                $labels = (string)($i + 1);

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

        $winery_id = $request->input('winery');
        $winery = Winery::find($winery_id);
        $user = Auth::user();
        $plans = $user->plans()->get();

        if ($plans->contains('id', $winery_id)) {
            return back()->with('status', $winery->name.' is already in your planner.');
            
        }
        elseif(($plans->count() >= 9)){
            return back()->with('status', 'Your planner can only have up to 9 wineries');
        }
        else {
            //get plan that is last in order
            $currentPlan = $user->plans()->orderby('order', 'desc')->first();

            if(!empty($currentPlan)){

               // find the very last order number of planner list
                $currentLastOrder = $currentPlan->pivot->order;

                //add 1 to the last order to make this winery last on list
                $newLastOrder = $currentLastOrder + 1;

                //attach new winery to planner with last order number
                $user->plans()->attach($winery_id,  ['order' => $newLastOrder]);
            }
            else {
                //attach new winery to planner with order of 1
                $user->plans()->attach($winery_id,  ['order' => 1]);
            }
                
            // find winery with newly added winery_id
            return back()->with('status', $winery->name.' was added to your planner!');
        }
    }

    public function remove($winery_id) {
        // logged in, current user
        $user = Auth::user();

        $selectedPlan = $user->plans()->where('winery_id', '=', $winery_id)->first();

        $selectedPlanOrder = $selectedPlan->pivot->order;
        $higherPlans = $user->plans()->where('order', '>', $selectedPlanOrder)->get();

        if(!empty($selectedPlanOrder)) {
            foreach($higherPlans as $higherPlan) {
                $higherPlan->pivot->decrement('order');
            }
        }

        $user->plans()->detach($winery_id);

        $deletedWinery = Winery::find($winery_id);

        return back()->with('status', $deletedWinery->name.' was removed from your planner!');
    }

    public function clear() {

        Auth::user()->plans()->detach();
        
        return back()->with('status', 'Your planner was cleared!');

    }

    public function visit(Request $request) {
        $user = Auth::user();
        $wineryId = $request->input('winery_id');
        $winery = Winery::find($wineryId);
        $visits = $user->visits()->get();
        
        $selectedPlan = $user->plans()->where('winery_id', '=', $wineryId)->first();

        $selectedPlanOrder = $selectedPlan->pivot->order;
        $higherPlans = $user->plans()->where('order', '>', $selectedPlanOrder)->get();

        if(!empty($selectedPlanOrder)) {
            foreach($higherPlans as $higherPlan) {
                $higherPlan->pivot->decrement('order');
            }
        }


        $user->plans()->detach($wineryId);
        
        if ($visits->contains($wineryId)) {
            return back()->with('status', $winery->name.' was visited again.');
            
        }
        else {
            $user->visits()->attach($wineryId);
            return back()->with('status', $winery->name.' was added to your visited list!');
        }

    }

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
