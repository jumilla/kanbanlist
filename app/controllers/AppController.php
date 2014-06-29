<?php

class AppController extends BaseController {

	public function index()
	{
		$all_user_count = User::count(); 
		$today_task_count = Task::todayCount();
		$all_task_count = Task::count();

		return View::make('app.index', compact('all_user_count','today_task_count','all_task_count'));
	}

	public function getSignup()
	{
		return View::make('app.signup');
	}

	public function postSignup()
	{
		//TODO: validator add 
		$validator = Validator::make(Input::all(), User::$rules);
		if ($validator->fails()) {
			return Redirect::route('app.signup')->withErrors($validator)->withInput();
		}

		try {
			// Let's register a user.
			$user = Sentry::register(array(
				'email'    => Input::get('email'),
				'password' => Input::get('password'),
				'name'     => Input::get('name'),
				'activated' => true,
			));
		
			// Let's get the activation code
			//$activationCode = $user->getActivationCode();
		
			// Send activation code to the user so he can activate the account

			Auth::login(User::find($user->getId()), false);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			return Redirect::route('app.signin')
				->withErrors(['username_reired', 'Login field is required.'])
				->withInput()
			;
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			return Redirect::route('app.signin')
				->withErrors(['password_reired', 'Password field is required.'])
				->withInput()
			;
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			return Redirect::route('app.signup')
				->withErrors(['existed_error', 'User with this login already exists.'])
				->withInput()
			;
		}

		return Redirect::route('tasks.index');
	}

	public function getSignin()
	{
		return View::make('app.signin');
	}

	public function postSignin()
	{
		try {
			// Let's register a user.
			$user = Sentry::authenticate(array(
				'email'    => Input::get('email'),
				'password' => Input::get('password'),
			));
		
			Auth::login(User::find($user->getId()), false);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			return Redirect::route('app.signin')
				->withErrors(['username_reired', 'Login field is required.'])
				->withInput()
			;
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			return Redirect::route('app.signin')
				->withErrors(['password_reired', 'Password field is required.'])
				->withInput()
			;
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			return Redirect::route('app.signin')
				->withErrors(['existed_error', 'User with this login already exists.'])
				->withInput()
			;
		}

		return Redirect::route('tasks.index');
	}

	public function signout()
	{
//		Sentry::logout();
		Auth::logout();

		return Redirect::route('app.home');
	}

}
