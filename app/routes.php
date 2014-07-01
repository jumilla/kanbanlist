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
	Route::get('signup',
		['as' => 'app.signup', 'uses' => 'AppController@getSignup']);
	Route::post('signup',
		['as' => '', 'uses' => 'AppController@postSignup']);
	Route::get('signin',
		['as' => 'app.signin', 'uses' => 'AppController@getSignin']);
	Route::post('signin',
		['as' => '', 'uses' => 'AppController@postSignin']);
	Route::get('signout',
		['as' => 'app.signout', 'uses' => 'AppController@signout']);
});

Route::group(['prefix' => 'dashboard', 'before' => 'auth'], function() {
	Route::get('',
		['as' => 'dashboard', 'uses' => 'DashboardController@getIndex']);
});

Route::group(['prefix' => 'user', 'before' => 'auth'], function() {
	Route::get('{id}',
		['as' => 'user.show', 'uses' => 'UserController@show']);
	Route::get('{id}/edit',
		['as' => 'user.edit', 'uses' => 'UserController@edit']);
	Route::post('{id}/edit',
		['as' => 'user.update', 'uses' => 'UserController@update']);
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
