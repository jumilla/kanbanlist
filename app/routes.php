<?php

use Illuminate\Support\Facades\View;
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
		['as' => 'home', 'uses' => 'HomeController@index']);
	Route::get('signup',
		['as' => 'user.signup', 'uses' => 'UserController@getSignup']);
	Route::post('signup',
		['as' => '', 'uses' => 'UserController@postSignup']);
	Route::get('signin',
		['as' => 'user.signin', 'uses' => 'UserController@getSignin']);
	Route::post('signin',
		['as' => '', 'uses' => 'UserController@postSignin']);
});

Route::group(['prefix' => 'dashboard', 'before' => 'auth'], function() {
	Route::get('',
		['as' => 'dashboard', 'uses' => 'DashboardController@getIndex']);
});

Route::group(['prefix' => 'user', 'before' => 'auth'], function() {
	Route::get('signout',
		['as' => 'user.signout', 'uses' => 'UserController@signout']);
	Route::get('{id}',
		['as' => 'user.show', 'uses' => 'UserController@show']);
	Route::get('{id}/edit',
		['as' => 'user.edit', 'uses' => 'UserController@edit']);
	Route::post('{id}/edit',
		['as' => 'user.update', 'uses' => 'UserController@update']);
});

Route::group(['prefix' => 'tasks', 'before' => 'auth'], function() {
	Route::get('',
		['as'=>'tasks.index', 'uses'=>'TasksController@index']);
    Route::post('',
    	['as' => 'tasks.create', 'uses' => 'TasksController@create']);
    Route::post('update',
    	['as' => 'tasks.update', 'uses' => 'TasksController@update']);
    Route::post('destroy',
    	['as' => 'tasks.destroy', 'uses' => 'TasksController@destroy']);
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
});
