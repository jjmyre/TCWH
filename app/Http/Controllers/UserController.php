<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Session;
use Hash;

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

    public function editPassword(Request $request)
    { 
        //validate input fields
        $this->validate(request(), [
            'current_password' => 'required|string|min:7',
            'new_password' => 'required|string|min:7|confirmed',
        ]);

        // assign variables
        $user = Auth::user();
        $currentPassword =  $request->input('current_password');
        $newPassword =  $request->input('new_password');

        // check and see if the password matches, if not redirect back with message
        if (!(Hash::check($currentPassword, $user->password))) {
            return back()->with('status', 'Your password does not match our records.');
        }
        // crypt new password
        $user->password = bcrypt($newPassword);

        // save user
        $user->save();

        return back()->with('status', "Your password was successfully changed!");
    }

    public function editEmail(Request $request)
    {
        $user= Auth::user();
        // validate input fields 
        $this->validate(request(), [
            'current_email' => 'required|email|max:255|exists:users,email',
            'new_email' => 'required|email|max:255|unique:users,email|confirmed',
        ]);

        $currentEmail = $request->input('current_email');
        $newEmail = $request->input('new_email');

        $user->email = $newEmail;

        $user->save();

        return back()->with('status', "Your email was successfully changed!");
    }



	public function logout() {
		Auth::logout();
	}
}
