<?php

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class UserController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	public function edit()
	{
		return View::make('user.edit', compact('user'));
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
