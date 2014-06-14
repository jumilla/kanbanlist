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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('dashboard', 'DashboardController@getIndex');

// Route::get('tasks/index', ['as'=>'tasks', 'uses'=>'TasksController@index']);
Route::get('tasks', function()
{
	return View::make('tasks/index');
});

Route::get('users/sign_up','UserController@signUp');
Route::get('users/sign_in','UserController@signIn');
Route::get('users/sign_out','UserController@signOut');
Route::get('users/{id}/edit','UserController@edit');
