<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['prefix' => ''], function() {
	Route::get('/',
		['as' => 'app.home', 'uses' => 'AppController@index']);
});

Route::group(['prefix' => 'dashboard', 'before' => 'auth'], function() {
	Route::get('',
		['as' => 'dashboard', 'uses' => 'DashboardController@getIndex']);
});

// Confide routes
Route::group(['prefix' => 'users'], function() {
	// Confide routes
	Route::get( 'create',
		['as' => 'user.create', 'uses' => 'UsersController@create']);
	Route::post('create',
		['as' => 'user.store', 'uses' => 'UsersController@store']);
	Route::get( 'login',
		['as' => 'user.login', 'uses' => 'UsersController@login']);
	Route::post('login',
		['as' => 'user.do_login', 'uses' => 'UsersController@doLogin']);
	Route::get( 'confirm/{code}',
		['as' => 'user.confirm', 'uses' => 'UsersController@confirm']);
	Route::get( 'forgot_password',
		['as' => 'user.forgot_password', 'uses' => 'UsersController@forgotPassword']);
	Route::post('forgot_password',
		['as' => 'user.do_forgot_password', 'uses' => 'UsersController@doForgotPassword']);
	Route::get( 'reset_password/{token}',
		['as' => 'user.reset_password', 'uses' => 'UserController@resetPassword']);
	Route::post('reset_password',
		['as' => 'user.do_reset_password', 'uses' => 'UsersController@doResetPassword']);
	Route::get( 'logout',
		['as' => 'user.logout', 'uses' => 'UsersController@logout']);

	// App routes
	Route::get( 'edit',
		['as' => 'user.edit', 'uses' => 'UsersController@edit']);
	Route::post('edit',
		['as' => 'user.update', 'uses' => 'UsersController@update']);
});

Route::group(['prefix' => 'books', 'before' => 'auth'], function() {
	Route::post('create',
		['as' => 'books.create', 'uses' => 'BooksController@create']);
	Route::get('{id}',
		['as' => 'books.show', 'uses' => 'BooksController@show']);
	Route::delete('{id}',
		['as' => 'books.destroy', 'uses' => 'BooksController@destroy']);
});

Route::group(['prefix' => 'tasks', 'before' => 'auth'], function() {
	Route::get('',
		['as'=>'tasks.index', 'uses'=>'TasksController@index']);
    Route::post('',
    	['as' => 'tasks.create', 'uses' => 'TasksController@create']);
    Route::post('update_order',
    	['as' => 'tasks.update_order', 'uses' => 'TasksController@updateOrder']);
    Route::any('filter_or_update',
    	['as' => 'tasks.filter_or_update', 'uses' => 'TasksController@filterOrUpdate']);
    Route::post('silent_update',
    	['as' => 'tasks.silent_update', 'uses' => 'TasksController@silentUpdate']);
    Route::post('send_mail',
    	['as' => 'tasks.send_mail', 'uses' => 'TasksController@sendMail']);
    Route::get('donelist',
    	['as' => 'tasks.donelist', 'uses' => 'TasksController@donelist']);
    Route::put('{id}',
    	['as' => 'tasks.update', 'uses' => 'TasksController@update']);
    Route::delete('{id}',
    	['as' => 'tasks.destroy', 'uses' => 'TasksController@destroy']);
});

// for DEBUG
if (Config::get('app.debug')) {
	// route 'crud/{table}'
	Shin1x1\LaravelTableAdmin\TableAdminFacade::route([
    	'users',
    	'books',
    	'tasks',
	]);
}
//

