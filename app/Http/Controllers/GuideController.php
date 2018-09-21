<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuideController extends Controller
{
	function __invoke(){
        return view('guide.list');
    }
    
}
