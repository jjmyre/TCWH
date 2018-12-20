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

class UserController extends Controller
{

	public function __construct() {
        $this->middleware('auth');
    }

	public function dashboard() {
		$user = Auth::user();
		$favorites = $user->favorites()->get();
		$wishlists = $user->wishlists()->get();
		$visits = $user->visits()->get();

		return view('user.dashboard')->with([
            'user' => $user,
            'favorites' => $favorites,
            'wishlists' => $wishlists,
            'visits' => $visits,
        ]);
	}

	public function edit() {
		$user = Auth::user();
        return view('user.edit')->with(['user' => $user]);
    }

    public function update(Request $request)
    { 
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user->name = request('name');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));

        $user->save();

        return back();
    }



	public function logout() {
		Auth::logout();
	}
}
