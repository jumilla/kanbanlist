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

Route::get('/', 'HomeController@index');

Route::get('dashboard', 'DashboardController@getIndex');

Route::group(['prefix' => 'tasks'], function() {
	Route::get('', ['as'=>'tasks', 'uses'=>'TasksController@index']);
	Route::post('filter_or_update', ['as'=>'getTasks', 'uses'=>'TasksController@filterOrUpdate']); 
});



Route::get('users/sign_up','UserController@signUp');
Route::post('users/sign_up','UserController@postSignUp');
Route::get('users/sign_in','UserController@signIn');
Route::get('users/sign_out','UserController@signOut');
Route::get('users/{id}/edit','UserController@edit');
