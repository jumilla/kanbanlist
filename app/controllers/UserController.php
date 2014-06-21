<?php

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class UserController extends BaseController {

	public function getSignup()
	{
		return View::make('users/signup');
	}

	public function postSignup()
	{
		//TODO: validator add 
		$validator = Validator::make(Input::all(), User::$rules);
		if ($validator->fails()) {
			return Redirect::route('user.signup'))->withErrors($validator);
		}

		try {
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
			return Redirect::route('user.signup'))
					->withErrors(array('existed_error','User with this login already exists.'));
		}
	}

	public function getSignin()
	{
		return View::make('users/signin');
	}

	public function postSignin()
	{
		return View::make('users/signin');
	}

	public function signout()
	{
		//return View::make('users/signOut');
	}

	public function edit()
	{
		return View::make('users/edit', compact('user'));
	}

	public function update()
	{
	}

	private function given_new_password_in_params()
	{
		return strlen(Input::get('password')) > 0 or strlen(Input::get('password_confirm')) > 0;
	}

	private function update_with_password()
	{

	}

	private function update_without_password()
	{

	}

	public function dump($id)
	{
		return var_dump(User::find($id));
	}

}
