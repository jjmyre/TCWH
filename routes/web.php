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

//Authentication-Protected Routes
Route::group(['middleware' => 'auth'], function () {
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
	Route::post('/unvisited/clear', 'VisitController@clear');
});

// Contact Routes
Route::get('/contact', function () {
    return view('contact');
});
Route::post('/correction/{id}', function () {
    return view('contact');
});




// Signup Routes
Route::get('/signup', function () {
    return view('signup');
});
Route::post('/signup', 'Auth\RegisterController@register');

// Login Routes
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');



/*

// Auth::routes();


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


