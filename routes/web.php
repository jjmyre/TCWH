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

// Guide Routes
Route::get('/guide', 'GuideController@index');
Route::get('/guide/list', 'GuideController@list');
Route::get('winery/{id}', 'GuideController@detail');
Route::post('/guide/mistake', 'GuideController@mistake');

// AVA Map Routes
Route::get('/avamap', 'AvaMapController@index');
Route::get('/avamap/{ava}', 'AvaMapController@list');

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
	
	// Planner Routes
	Route::get('/planner', 'PlannerController@index');
	Route::post('/planner/add', 'PlannerController@add');
	Route::post('/planner/moveup', 'PlannerController@moveup');
	Route::post('/planner/movedown', 'PlannerController@movedown');
	Route::post('/planner/visit', 'PlannerController@visit');
	Route::delete('/planner/unvisit/{wineryId}', 'PlannerController@unvisit');
	Route::delete('/planner/remove/{wineryId}', 'PlannerController@remove');
	Route::delete('/planner/clear', 'PlannerController@clear');

	// User Edit Info & Dashboard
	Route::get('/dashboard', 'UserController@dashboard');
	Route::get('/edit', 'UserController@edit');
	Route::post('/edit/password', 'UserController@editPassword');
	Route::post('/edit/email', 'UserController@editEmail');

	// Favorites
	Route::post('/favorite', 'FavoriteController@favorite');
	Route::delete('/unfavorite/{wineryId}', 'FavoriteController@unfavorite');
	Route::delete('/favorite/clear', 'FavoriteController@clear');

	// Wishlists
	Route::post('/wishlist', 'WishlistController@wishlist');
	Route::delete('/unwishlist/{wineryId}', 'WishlistController@unwishlist');

	// Visited Wineries
	Route::post('/visited', 'VisitController@visited');
	Route::delete('/unvisited/{wineryId}', 'VisitController@unvisited');
	Route::delete('/unvisited/clear', 'VisitController@clear');

	// User Logout
	Route::post('/logout', 'UserController@logout');
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
Route::get('/login', function() {
	return abort(404);
});
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


