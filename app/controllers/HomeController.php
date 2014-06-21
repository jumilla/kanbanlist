<?php

class HomeController extends BaseController {

	public function index()
	{
		$all_user_count = 1000; 
		$today_task_count = 10000;
		$all_task_count = 100000;

		return View::make('home.index', compact('all_user_count','today_task_count','all_task_count'));
	}

}
