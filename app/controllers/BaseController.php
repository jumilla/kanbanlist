<?php

class BaseController extends Controller {

	public function __construct()
	{
		DeviceAutoDetectFinder::install();
	}

	public function currentBook()
	{
		return Session::has('book_id') ? Book::find(Session::get('book_id')) : null;
	}

	public function currentTasks()
	{
		return $this->currentBook() ? $this->currentBook()->tasks() : Auth::user()->tasks();
	}

	public function getBookname()
	{
		return $this->currentBook() ? $this->currentBook()->name : Book::$DEFAULT_NAME;
	}

	public function getPrefix()
	{
		return $this->currentBook() ? $this->currentBook()->name : '';
	}

	public function getTaskCounts()
	{
		return $this->currentBook() ? $this->currentBook()->tasks->count() : Auth::user()->tasks->count();
	}

	public function getAllBookCounts()
	{
		return array_merge($this->allCountsInfo(), $this->booksCountInfoArray());
	}

	public function allCountsInfo()
	{
		$all_info = [];
		$all_info['id'] = 0;
		$all_info['name'] = Book::$DEFAULT_NAME;
		foreach (array_keys(Task::$status_table) as $status_name) {
			$all_info[$status_name] = 0;
		}
		foreach (Auth::user()->tasks()->select('status', DB::raw('count(*) as total'))->groupBy('status')->get() as $result) {
			$status_name = array_search($result->status, Task::$status_table);
			$all_info[$status_name] = $result->total;
		}
		Log::info(print_r($all_info, true));
		return $all_info;
	}

	public function booksCountInfoArray()
	{
		//Auth::user()->books
		return [
/*			'todo_h' => 0,
			'todo_m' => 0,
			'todo_l' => 0,
			'doing' => 0,
			'waiting' => 0,
			'done' => 0,*/
		];
	}

	public function renderJsonForUpdateBookJson($filter_str = '', $done_num)
	{
		return Response::json([
			'task_list_html' => $this->getTaskListHtml($filter_str, $done_num),
			'book_name'      => $this->getBookname(),
			'prefix'         => $this->getPrefix(),
			'task_counts'    => $this->getTaskCounts(),
			'all_books'      => $this->getAllBookCounts(),
		])->setCallback('updateBookJson');
	}

	public function getTaskListHtml($filter_str, $done_num)
	{
		$recent_done_num = $done_num;
		$tasks = $this->getTasks($filter_str, $done_num);

		$layout = Session::get('layout', 'default');
		return View::make('tasks.layouts.' . $layout, compact('tasks', 'recent_done_num'))->render();
	}

	public function getTasks($filtered_str = '', $done_num = 10)
	{
		if (empty($filtered_str)) {
			return $this->getUnfilteredTasks($done_num);
		}
		else {
			return $this->getFilteredTasks($filtered_str, $done_num);
		}
	}

	public function getUnfilteredTasks($done_num = 10)
	{
		$tasks = [
			'todo_high_tasks' => $this->currentTasks()->byStatus('todo_h')->get(),
			'todo_mid_tasks'  => $this->currentTasks()->byStatus('todo_m')->get(),
			'todo_low_tasks'  => $this->currentTasks()->byStatus('todo_l')->get(),
			'doing_tasks'     => $this->currentTasks()->byStatus('doing')->get(),
			'waiting_tasks'   => $this->currentTasks()->byStatus('waiting')->get(),
			'done_tasks'      => $this->currentTasks()->byStatus('done')->limit($done_num)->get(),
		];
		return $tasks;
	}

	public function getFilteredTasks($filter_word, $done_num = 10)
	{
		$tasks = [
			'todo_high_tasks' => $this->currentTasks()->byStatusAndFilter('todo_h')->get(),
			'todo_mid_tasks'  => $this->currentTasks()->byStatusAndFilter('todo_m')->get(),
			'todo_low_tasks'  => $this->currentTasks()->byStatusAndFilter('todo_l')->get(),
			'doing_tasks'     => $this->currentTasks()->byStatusAndFilter('doing')->get(),
			'waiting_tasks'   => $this->currentTasks()->byStatusAndFilter('waiting')->get(),
			'done_tasks'      => $this->currentTasks()->doneAndFilter($filter_word)->limit($done_num)->get(),
		];
		return $tasks;
	}

}
