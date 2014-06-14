<?php


class UserController extends BaseController{
	public function signUp(){
		return View::make('users/signUp');
	}
	
	public function signIn(){
		return View::make('users/signIn');
	}
	public function signOut(){
		//return View::make('users/signOut');
	}
	
	public function edit($id){
		$user = User::find($id);
		if(!isset($user)) App::abort(404);
		
		return View::make('users/edit',compact('user'));
	}
}
