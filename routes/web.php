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
Route::get('/guide', 'GuideController@index');
Route::get('/guide/list/', 'GuideController@list');
Route::get('/winery/{id}', 'GuideController@detail');


// AVA Map
Route::get('/avamap', 'AvaMapController@list');

// Planner
Route::get('/planner', 'PlannerController@index');
Route::post('/planner/add/{id}', 'PlannerController@add');
Route::post('/planner/move/{id}', 'PlannerController@move');
Route::post('/planner/remove/{id}', 'PlannerController@remove');
Route::post('/planner/clear', 'PlannerController@clear');

// Favorites
Route::post('/favorite/{id}', 'FavoriteController@favorite');
Route::post('/unfavorite/{id}', 'FavoriteController@unfavorite');

// Wishlists
Route::post('/wishlist/{id}', 'WishlistController@wishlist');
Route::post('/unwishlist/{id}', 'WishlistController@unwishlist');

// Visited Wineries
Route::post('/visited/{id}', 'VisitController@visited');
Route::post('/unvisited/{id}', 'VisitController@unvisited');
Route::post('/unvisited/all', 'VisitController@clear');




// Contact & Error Correction

Route::get('/contact', function () {
    return view('contact');
});
Route::post('/correction/{id}', function () {
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



Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
