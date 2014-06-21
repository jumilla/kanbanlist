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

Route::get('/', ['as' => 'home',
	'uses' => 'HomeController@index']);

Route::get('dashboard', ['as' => 'dashboard',
	'uses' => 'DashboardController@getIndex']);

Route::group(['prefix' => 'tasks'], function() {
	Route::get('', ['as'=>'tasks', 'uses'=>'TasksController@index']);
	Route::post('filter_or_update', ['as'=>'getTasks', 'uses'=>'TasksController@filterOrUpdate']); 
});



Route::get('user/signup', ['as' => 'user.signup',
	'uses' => 'UserController@getSignup']);
Route::post('user/signup', ['as' => '',
	'uses' => 'UserController@postSignup']);
Route::get('user/signin', ['as' => 'user.signin',
	'uses' => 'UserController@getSignin']);
Route::post('user/signin', ['as' => '',
	'uses' => 'UserController@postSignin']);
Route::get('user/signout', ['as' => 'user.signout',
	'uses' => 'UserController@signout']);
Route::get('user/{id}', ['as' => 'user.show',
	'uses' => 'UserController@show']);
Route::get('user/{id}/edit', ['as' => 'user.edit',
	'uses' => 'UserController@edit']);
Route::post('user/{id}/edit', ['as' => 'user.update',
	'uses' => 'UserController@update']);

Route::post('tasks/update_order', ['as' => 'tasks.update_order', 'uses' => 'TasksController@updateOrder']);
Route::post('tasks/filter_or_update', ['as' => 'tasks.filter_or_update', 'uses' => 'TasksController@filterOrUpdate']);
Route::post('tasks/silent_update', ['as' => 'tasks.silent_update', 'uses' => 'TasksController@silentUpdate']);
Route::post('tasks/send_mail', ['as' => 'tasks.send_mail', 'uses' => 'TasksController@sendMail']);
Route::get('tasks/donelist', ['as' => 'tasks.donelist', 'uses' => 'TasksController@donelist']);
