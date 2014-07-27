<?php

class AppController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		Log::info(get_class(App::make('view.finder')));

		$all_user_count = User::count(); 
		$today_task_count = Task::todayCount();
		$all_task_count = Task::count();

		return View::make('app.index', compact('all_user_count','today_task_count','all_task_count'));
	}

}
