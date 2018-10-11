<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvaMapController extends Controller
{
    function __invoke(){
        return view('ava.list');
    }
}