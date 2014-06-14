<?php

class DashboardController extends BaseController {

	public function getIndex()
	{
		return View::make('dashboard.index', [
			'add_tasks' => [],
			'done_tasks' => [],
			'oldest_tasks' => [],
			'doing_tasks' => [],
			'today_tasks' => [],
			'books' => [],
		]);
	}
	
}
