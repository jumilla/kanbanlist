<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function currentBook()
	{
		if (Session::get('book_id') != null && Session::get('book_id') != 0)
		{
			return Auth::user()->books->find(Session::get('book_id'));
		}
		else
		{
			return null;
		}
	}

	public function currentTasks()
	{
		return $this->currentBook() ? $this->currentBook()->tasks() : Auth::user()->tasks();
	}

	public function userEmail()
	{
		$this->user_email = Auth::user() ? Auth::user()->email : '';
	}

	public function getBookname()
	{
		return $this->currentBook() ? $this->currentBook()->name : Book::default_name();
	}

	public function getPrefix()
	{
		return $this->currentBook() ? $this->currentBook()->name : '';
	}

	public function getTaskCounts()
	{
		return $this->currentBook() ? $this->currentBook()->tasks()->count() : Auth::user()->tasks()->count();
	}

	public function getAllBookCounts()
	{
		return array_merge(array($this->allCountsInfo()), $this->allCountsInfoArray());
	}

	public function allCountsInfo()
	{
		$all_info = Auth::user()->tasks()->count();
		$all_info['id'] = 0;
		$all_info['name'] = Book::DEFAULT_NAME;
		return $all_info;
	}

	public function allCountsInfoArray()
	{
		return []; //Auth::user()->books
	}

	public function getTasks($filtered_str = '', $done_num = 10)
	{
		$target_tasks = $this->currentTasks();

		if (empty($filtered_str)) {
			$this->getUnfilteredTasks($target_tasks, $done_num);
		}
		else {
			$this->getFilteredTasks($target_tasks, $filtered_str, $done_num);
		}
	}

	public function getUnfilteredTasks($target_tasks, $done_num)
	{
		$tasks = [
			'todo_high_tasks' => $target_tasks.byStatus('todo_h'),
			'todo_mid_tasks'  => $target_tasks.byStatus('todo_m'),
			'todo_low_tasks'  => $target_tasks.byStatus('todo_l'),
			'doing_tasks'     => $target_tasks.byStatus('doing'),
			'waiting_tasks'   => $target_tasks.byStatus('waiting'),
			'done_tasks'      => $target_tasks.done.limit($done_num),
		];
		return $tasks;
	}

	public function getFilteredTasks($target_tasks, $filter_word, $done_num = 10)
	{
		$tasks = [
			'todo_high_tasks' => $target_tasks.byStatusAndFilter('todo_h'),
			'todo_mid_tasks'  => $target_tasks.byStatusAndFilter('todo_m'),
			'todo_low_tasks'  => $target_tasks.byStatusAndFilter('todo_l'),
			'doing_tasks'     => $target_tasks.byStatusAndFilter('doing'),
			'waiting_tasks'   => $target_tasks.byStatusAndFilter('waiting'),
			'done_tasks'      => $target_tasks.doneAndFilter($filter_word).limit($done_num),
		];
		return $tasks;
	}

	public function renderJsonForUpdateBookJson($filter_str = '', $done_num)
	{
		return Response::json([
			'task_list_html' => get_task_list_html($filter_str, $done_num),
			'book_name'      => getBookname(),
			'prefix'         => getPrefix(),
			'task_counts'    => getTaskCounts(),
			'all_books'      => getAllBookCounts(),
		])->setCallback('updateBookJson');
	}

	public function getTaskListHtml($filter_str, $done_num)
	{
		$this->recent_done_num = $done_num;
		$this->tasks = get_tasks($filter_str, $done_num);

		$layout = Session::get('layout');
		Session::put('layout', $layout ?: 'default');
		View::make('tasks/tasklist_' . Session::get('layout'));
	}

}
