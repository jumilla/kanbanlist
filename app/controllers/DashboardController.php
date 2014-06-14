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
			'task_counts' => ['todo_h' => 0, 'todo_m' => 0, 'todo_l' => 0, 'doing' => 0, 'waiting' => 0],
			'month_done_list' => [],
		]);
	}
	
}
