<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class ContactController extends Controller
{
    public function showForm() {
    	
    	$user = Auth::user();

    	return view('contact')->with([
            'user' => $user,
        ]);
    }

    public function submitForm() {

    }

    public function clear() {

    }

}
