<?php


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
class UserController extends BaseController{
	public function signUp(){
		return View::make('users/signUp');
	}
	public function postSignUp(){
		//TODO: validator add 
		$validator = Validator::make(Input::all(),User::$rules);
		if($validator->fails()){
			return Redirect::to(URL::action('UserController@signUp'))->withErrors($validator);
		}
		try
		{
			// Let's register a user.
			$user = Sentry::register(array(
					'email'    => Input::get('email'),
					'password' => Input::get('password'),
					'name'     => Input::get('name')
			));
		
			// Let's get the activation code
			$activationCode = $user->getActivationCode();
		
			// Send activation code to the user so he can activate the account
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			echo 'Login field is required.';
			//validated in validator
			
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			echo 'Password field is required.';
			//validated in validator
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			return Redirect::to(URL::action('UserController@signUp'))
					->withErrors(array('existed_error','User with this login already exists.'));
		}
		
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
	
	public function show($id){
		return var_dump(User::find($id));
	}
}
