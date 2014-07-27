<?php

class DashboardController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	public function getIndex()
	{
		return View::make('dashboard.index', [
			'add_tasks' => Auth::user()->tasks()->newestAdd()->get(),
			'done_tasks' => Auth::user()->tasks()->newestDone()->get(),
			'oldest_tasks' => Auth::user()->tasks()->oldestUpdate()->get(),
			'doing_tasks' => Auth::user()->tasks()->byStatus('doing')->get(),
			'today_tasks' => Auth::user()->tasks()->todayTouch()->get(),
			'books' => $this->booksCountInfoArray(),
			'task_counts' => $this->allCountsInfo(),
			'month_done_lists' => Task::doneMonthList(Auth::user()->tasks()),
		]);
	}
	
}
