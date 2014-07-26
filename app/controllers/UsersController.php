<?php

/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends Controller
{

	/**
	 * Displays the form for account creation
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function create()
	{
		return View::make(Config::get('confide::signup_form'));
	}

	/**
	 * Stores new account
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function store()
	{
		$repo = App::make('UserRepository');
		$user = $repo->signup(Input::all());

		if ($user->id) {
			if (!Config::get('kanbanlist.user.signup_force_confirm')) {
				// 登録確認メール送信
				Mail::send(
					Config::get('confide::email_account_confirmation'),
					compact('user'),
					function ($message) use ($user) {
						$message
							->to($user->email, $user->username)
							->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
					}
				);
			}
			else {
				// 無条件で確認済みとする
				$user->confirmed = true;
				$user->save();
			}

			return Redirect::action('UsersController@login')
				->with('notice', Lang::get('confide::confide.alerts.account_created'));
		}
		else {
			$error = $user->errors()->all(':message');

			return Redirect::action('UsersController@create')
				->withInput(Input::except('password'))
				->withErrors([$error]);
		}
	}

	/**
	 * Displays the login form
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function login()
	{
		// 既にログインされていたら
		if (Confide::user()) {
			return Redirect::route('dashboard');
		}
		else {
			return View::make(Config::get('confide::login_form'));
		}
	}

	/**
	 * Attempt to do login
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function doLogin()
	{
		$repo = App::make('UserRepository');
		$input = Input::all();

		if ($repo->login($input)) {
			$user = Confide::user();
			$user->last_logged_at = \Carbon\Carbon::now();
			$user->save();

			return Redirect::route('tasks.index');
		}
		else {
			if ($repo->isThrottled($input)) {
				$errorMessage = Lang::get('confide::confide.alerts.too_many_attempts');
			}
			elseif ($repo->existsButNotConfirmed($input)) {
				$errorMessage = Lang::get('confide::confide.alerts.not_confirmed');
			}
			else {
				$errorMessage = Lang::get('confide::confide.alerts.wrong_credentials');
			}

			return Redirect::action('UsersController@login')
				->withInput(Input::except('password'))
				->withErrors([$errorMessage]);
		}
	}

	/**
	 * Attempt to confirm account with code
	 *
	 * @param  string $code
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function confirm($code)
	{
		if (Confide::confirm($code)) {
			$notice_msg = Lang::get('confide::confide.alerts.confirmation');
			return Redirect::action('UsersController@login')
				->with('notice', $notice_msg);
		}
		else {
			$error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
			return Redirect::action('UsersController@login')
				->withErrors($error_msg);
		}
	}

	/**
	 * Displays the forgot password form
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function forgotPassword()
	{
		return View::make(Config::get('confide::forgot_password_form'));
	}

	/**
	 * Attempt to send change password link to the given email
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function doForgotPassword()
	{
		if (Confide::forgotPassword(Input::get('email'))) {
			$notice_msg = Lang::get('confide::confide.alerts.password_forgot');
			return Redirect::action('UsersController@login')
				->with('notice', $notice_msg);
		}
		else {
			$error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
			return Redirect::action('UsersController@forgot_password')
				->withInput()
				->withErrors($error_msg);
		}
	}

	/**
	 * Shows the change password form with the given token
	 *
	 * @param  string $token
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function resetPassword($token)
	{
		return View::make(Config::get('confide::reset_password_form'))
				->with('token', $token);
	}

	/**
	 * Attempt change password of the user
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function doResetPassword()
	{
		$repo = App::make('UserRepository');
		$input = array(
			'token'                 =>Input::get('token'),
			'password'              =>Input::get('password'),
			'password_confirmation' =>Input::get('password_confirmation'),
		);

		// By passing an array with the token, password and confirmation
		if ($repo->resetPassword($input)) {
			$noticeMessage = Lang::get('confide::confide.alerts.password_reset');
			return Redirect::action('UsersController@login')
				->with('notice', $notice_msg);
		}
		else {
			$error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
			return Redirect::action('UsersController@reset_password', array('token'=>$input['token']))
				->withInput()
				->withErrors($error_msg);
		}
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function logout()
	{
		Confide::logout();

		return Redirect::to('/');
	}

	/**
	 * Edit Form for current user
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function edit()
	{
		$user = Confide::user();
		return View::make('user.edit', compact('user'));
	}

	/**
	 * Update current user data
	 *
	 * @return  Illuminate\Http\Response
	 */
	public function update()
	{
		$user = Confide::user();
		$repo = App::make('UserRepository');

		if (strlen(Input::get('password')) > 0) {
			if (!$repo->updateWithPassword($user, Input::all()))
				return View::make('user.edit', compact('user'));

			return View::make('user.password_changed', compact('user'));
		}
		else {
			if (!$repo->updateWithoutPassword($user, Input::all()))
				return View::make('user.edit', compact('user'));

			return Redirect::route('tasks.index');
		}
	}

}
