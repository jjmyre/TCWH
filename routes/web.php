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
Route::get('/guide/list', 'GuideController@list');

// Winery Detail Page
Route::get('winery/{id}', 'GuideController@detail');

// AVA Map
Route::get('/avamap', 'AvaMapController@index');
Route::get('/avamap/{id}', 'AvaMapController@list');

// About Page
Route::get('/about', function () {
	return view('about');
});

// Disclaimers Page
Route::get('/disclaimers', function () {
	return view('disclaimers');
});

// Authentication-Protected Routes
Route::group(['middleware' => 'auth'], function () {
	// Planner
	Route::get('/planner', 'PlannerController@index');
	Route::post('/planner/add', 'PlannerController@add');
	Route::post('/planner/move', 'PlannerController@move');
	Route::delete('/planner/remove/{winery_id}', 'PlannerController@remove');
	Route::delete('/planner/clear', 'PlannerController@clear');

	// User Edit Info & Dashboard
	Route::get('/dashboard/{id}', 'UserController@dashboard');
	Route::get('/editinfo/{id}', 'UserController@edit');

	// Favorites
	Route::post('/favorite', 'FavoriteController@favorite');
	Route::delete('/unfavorite/{winery_id}', 'FavoriteController@unfavorite');

	// Wishlists
	Route::post('/wishlist', 'WishlistController@wishlist');
	Route::delete('/unwishlist/{winery_id}', 'WishlistController@unwishlist');

	// Visited Wineries
	Route::post('/visited', 'VisitController@visited');
	Route::delete('/unvisited/{winery_id}', 'VisitController@unvisited');
	Route::delete('/unvisited/clear', 'VisitController@clear');
});

// Contact Routes
Route::get('/contact', 'ContactController@show');
Route::post('/contact', 'ContactController@send');

Route::post('/correction/{id}', function () {
    return view('contact');
});




// Signup Routes
Route::get('/signup', function () {
    return view('signup');
});
Route::post('/signup', 'Auth\RegisterController@register')->name('register');

// Login Routes
Route::post('/login', 'Auth\LoginController@login')->name('login');
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


*/