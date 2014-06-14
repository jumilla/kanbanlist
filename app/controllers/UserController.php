<?php


class UserController extends BaseController{
	public function signUp(){
		return View::make('users/signUp');
	}
	public function postSignUp(){
		try
		{
			// Let's register a user.
			$user = Sentry::register(array(
					'email'    => 'john.doe@example.com',
					'password' => 'test',
			));
		
			// Let's get the activation code
			$activationCode = $user->getActivationCode();
		
			// Send activation code to the user so he can activate the account
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			echo 'Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			echo 'Password field is required.';
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			echo 'User with this login already exists.';
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
}
