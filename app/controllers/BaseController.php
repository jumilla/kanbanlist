<?php

class BaseController extends Controller {

	public function __construct()
	{
	}

	public function currentBook()
	{
		return Session::has('book_id') ? Book::find(Session::get('book_id')) : null;
	}

	public function setCurrentBook($bookId)
	{
		Session::put('book_id', $bookId);
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
		return Task::countsByStatus($this->currentBook() ? $this->currentBook()->tasks() : Auth::user()->tasks());
	}

	public function getAllBookCounts()
	{
		return array_merge([$this->allCountsInfo()], $this->booksCountInfoArray());
	}

	public function allCountsInfo()
	{
		$all_info = [
			'id' => 0,
			'name' => Book::$DEFAULT_NAME,
		] + Task::countsByStatus(Auth::user()->tasks());
//		Log::debug(print_r($all_info, true));
		return $all_info;
	}

	public function booksCountInfoArray()
	{
		$all_books_info = [];
		foreach (Auth::user()->books as $book) {
			$book_info = [
				'id' => $book->id,
				'name' => $book->name,
				'active_task' => $book->tasks()->whereNotStatus(Task::$status_table['done'])->count(),
			] + Task::countsByStatus($book->tasks());
			$all_books_info[] = $book_info;
		}
//		Log::debug(print_r($all_books_info, true));
		return $all_books_info;
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
