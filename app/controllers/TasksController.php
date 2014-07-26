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

		if (Input::get('book_id') != null) {
			Session::set('book_id', Input::get('book_id'));
		}

		if (Input::get('layout') != null) {
			$this->setLayout(Input::get('layout'));
		}

		if (Agent::isMobile()) {
			$user_name = Auth::user()->name;
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

		$task = Task::create([
			'user_id' => Auth::user()->id,
			'book_id' => Book::getIdInMsg(Auth::user(), Input::get('msg')),
			'status' => Task::$status_table[Input::get('priority', 'todo_m')],
			'name' => Auth::user()->name,
			'msg' => Input::get('msg'),
		]);
		$task->save();

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
		Log::debug(__METHOD__."id=$id");

		$task = Task::find($id);
		$task->book_id = Book::getIdInMsg(Auth::user(), Input::get('msg'));
		if (Input::get('status') != '') {
			$task->status = Task::$status_table[Input::get('status')];
		}
		$task->message = Input::get('msg');
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

		$this->user_name = Auth::user()->name;

		return Response::json([
			'task_list_html' => $this->getTaskListHtml(Input::get('filter'), 15),
			'task_counts' => $this->getTaskCounts(),
			'all_books' => $this->getAllBookCounts(),
		])->setCallback('updateSilentJson');
	}

	public function donelist()
	{
		Log::debug(__METHOD__);

		$this->tasks = $this->curretTasks()->done;
		if (Input::get('year')->blank == false){
			$select_month = Carbon::createFromDate( Input::get('year'), Input::get('month'), 0);
			$this->tasks = $this->tasks->selectMonth($select_month);
		}
		$this->tasks = $this->tasks->paginate(100);

		$this->month_list = $this->curretTasks()->done_month_list;
//        $this->month_done_list = $this->curretTasks()->done_month_list->sortBy(function(){
//            |a,b| a[:date] <=> b[:date]
//        });
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
				$command = 'source ' . $hook_name . ' \"DONE\" \"#{helper.strip_tags task.msg}\"';
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
