<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/guide');
});

// Guide

Route::get('/guide', 'GuideController@default');

Route::get('/guide/list/', 'GuideController@list');

Route::get('/guide/winery/{id}', 'GuideController@detail');
Route::get('/guide/region/{id}', 'GuideController@detail');

// Planner CRUD
Route::post('/planner/add/:id', 'PlannerController@add');


// Contact & Error Correction

Route::get('/contact', function () {
    return view('contact');
});
Route::post('/contact', function () {
    return view('contact');
});


// Login & Signup

Route::get('/signup', function () {
    return view('signup');
});

Route::post('/signup', function () {
    return view('signup');
});


/* Route::get('/debug', function () {

    $debug = [
        'Environment' => App::environment(),
        'Database defaultStringLength' => Illuminate\Database\Schema\Builder::$defaultStringLength,
    ];

    
    The following commented out line will print your MySQL credentials.
    Uncomment this line only if you're facing difficulties connecting to the
    database and you need to confirm your credentials. When you're done
    debugging, comment it back out so you don't accidentally leave it
    running on your production server, making your credentials public.
    
    #$debug['MySQL connection config'] = config('database.connections.mysql');

    try {
        $databases = DB::select('SHOW DATABASES;');
        $debug['Database connection test'] = 'PASSED';
        $debug['Databases'] = array_column($databases, 'Database');
    } catch (Exception $e) {
        $debug['Database connection test'] = 'FAILED: '.$e->getMessage();
    }

    dump($debug);
});
*/


