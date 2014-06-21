<?php

class HomeController extends BaseController {

	public function index()
	{
		$all_user_count = User::count(); 
		$today_task_count = Task::todayCount();
		$all_task_count = Task::count();

		return View::make('home.index', compact('all_user_count','today_task_count','all_task_count'));
	}

}
