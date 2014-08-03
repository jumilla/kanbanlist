<?php

use Carbon\Carbon;

class TasksController extends BaseController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		Log::debug(__METHOD__);

		if (Input::has('book_id')) {
			$this->setCurrentBook(Input::get('book_id'));
		}

		if (Input::has('layout')) {
			$this->setLayout(Input::get('layout'));
		}

		if (Agent::isMobile()) {
			$user_name = Auth::user()->username;
			$get_task_counts = $this->getTaskCounts();
			$book_name = $this->getBookName();
			$current_book_id = $this->currentBook() ? $this->currentBook()->id : 0;
			$prefix = $this->getPrefix();
			$recent_done_now = 10;
 			$books = $this->getAllBookCounts();
			$tasks = $this->getTasks('', $recent_done_now);
			return View::make('tasks.index', compact(
				'user_name', 'book_name', 'current_book_id', 'prefix', 'recent_done_now', 'tasks', 'books'
			));
		}
		else {
			$this->tasks = $this->currentTasks();
		//        respond_to do |format|
		//            format.html
		//            format.csv { send_data(current_tasks.csv) }
		//            format.xls
		//        end
			return View::make('tasks.index');
		}

	}

	public function create()
	{
		Log::debug(__METHOD__);
//		Log::debug(print_r(Input::all(), true));

		$task = Task::create([
			'user_id' => Auth::user()->id,
			'book_id' => Book::getIdInMessage(Auth::user(), Input::get('message')),
			'status' => Task::$status_table[Input::get('priority', 'todo_m')],
			'name' => Auth::user()->username,
			'message' => Input::get('message'),
		]);

		$moveId = $this->isMovedFromBook($task) ? $task->id : 0;
		$taskHtml = View::make('tasks._task')->with([
			'task' => $task,
			'display' => 'none',
			'done' => false,
		])->render();

		return Response::json([
			'id'           => $task->id,
			'status'       => $task->statusSymbol(),
			'li_html'      => $taskHtml,
			'move_task_id' => $moveId,
			'task_counts'  => $this->getTaskCounts(),
			'all_books'    => $this->getAllBookCounts(),
		])->setCallback('addTodoResponse');
	}

	public function update($id)
	{
		Log::debug(__METHOD__.sprintf('(id=%d, message="%s")', $id, Input::get('message')));

		$task = Task::find($id);
		$task->book_id = Book::getIdInMessage(Auth::user(), Input::get('message'));
		if (Input::has('status')) {
			$task->status = Task::$status_table[Input::get('status')];
		}
		$task->message = Input::get('message');
		$task->save();

		$moveId = $this->isMovedFromBook($task) ? $task->id : 0;

		$this->doHooks($task);
		return Response::json([
			'task_counts'  => $this->getTaskCounts(),
			'move_task_id' => $moveId,
			'all_books'    => $this->getAllBookCounts(),
		])->setCallback('updateTaskJson');
	}

	public function destroy($id)
	{
		Log::debug(__METHOD__);

		$task = Task::find($id);
		$task->delete();

		return Response::json([
			'task_counts'  => $this->getTaskCounts(),
			'move_task_id' => 0,
			'all_books'    => $this->getAllBookCounts(),
		])->setCallback('updateTaskJson');
	}

	public function updateOrder()
	{
		Log::debug(__METHOD__);

		if (Input::get('id') == null) {
		  return 'update_order noop';
		}

		// 並び順の変更はタイムスタンプを更新したくない
		foreach (Input::get('id') as $i=>$task_id) {
			$target_task = Task::find($task_id);
			$target_task->timestamps = false;
			$target_task->order_no = $i;
			$target_task->save();
			$target_task->timestamps = true;
		}

		return 'update_order ok';
	}

	public function filterOrUpdate()
	{
		Log::debug(__METHOD__);

		$this->setLayout(Input::get('layout'));
		return $this->renderJsonForUpdateBookJson(Input::get('filter'), 15);
	}

	public function silentUpdate()
	{
		Log::debug(__METHOD__);

		return Response::json([
			'task_list_html' => $this->getTaskListHtml(Input::get('filter'), 15),
			'task_counts' => $this->getTaskCounts(),
			'all_books' => $this->getAllBookCounts(),
		])->setCallback('updateSilentJson');
	}

	public function donelist()
	{
		Log::debug(__METHOD__);

		$tasks = $this->currentTasks()->done();
		if (Input::has('year')){
			$month = Carbon::createFromDate(Input::get('year'), Input::get('month'), 0);
			$tasks = $tasks->selectMonth($month);
		}
		$tasks = $tasks->paginate(100);

		$month_list = Task::doneMonthList($this->currentTasks());

		$month_done_list = array_sort(Task::doneMonthList($this->currentTasks()), function($value) { return $value['date']; });

		return View::make('tasks.donelist', compact('tasks', 'month_list', 'month_done_list'));
	}

	public function sendMail()
	{
		Log::debug(__METHOD__);

		$mail_addr    = Input::get('mail_addr');
		$mail_comment = Input::get('comment');

		TaskMailer::all_tasks(Auth::user(),
			$this->currentBook(),
			$mail_addr,
			$mail_comment,
			$this->getTasks('', 15)
		)->deliver();

		return Response::json(['addr' => $mail_addr])->setCallback('showMailResult');
	}

	private function doHooks($task)
	{
		switch ($task->statusSymbol()) {
			case 'done':
				$hook_name = dirname(__FILE__) . '/hooks/update_task_' . Auth::user()->email;
				$command = 'source ' . $hook_name . ' \"DONE\" \"#{helper.strip_tags task.message}\"';
				if (file_exists($hook_name)) {
					system($command);
				}
		}
	}

	private function isMovedFromBook($task)
	{
		return ($this->currentBook() != null) and ($this->currentBook()->id != ($task->book ? $task->book->id : 0 ));
	}

	private function setLayout($layout_name)
	{
		if (!empty($layout_name)){
			Session::set('layout', $layout_name);
		}
	}

}
