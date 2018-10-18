<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvaMapController extends Controller
{
    public function list() {
    	return view('ava.list');
    }

}