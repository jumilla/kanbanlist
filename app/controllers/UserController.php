<?php


class UserController extends BaseController{
	public function signUp(){
		echo "OK";
	}
	
	public function signIn(){
		echo "Sign In";
	}
	public function signOut(){
		echo "Sign out";
	}
	
	public function edit($id){
		echo "edit: " .$id;
	}
}
