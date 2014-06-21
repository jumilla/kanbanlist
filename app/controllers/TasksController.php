<?php

use Carbon\Carbon;

class TasksController extends BaseController
{
    public function index()
    {
        if (Input::get('book_id') != null) {
            Session::set('book_id', Input::get('book_id'));
        }

        if (Input::get('layout') != null) {
            $this->setLayout(Input::get('layout'));
        }

//        if (UserAgent::isSmartphone()){
//            $this->user_name = Auth::user()->name;
//            $this->get_task_counts = getTaskCounts();
//            $this->book_name = getBookName();
//            $this->current_book_id = $this->currentBook() ? $this->currentBook()->id : 0;
//            $this->prefix = $this->getPrefix();
//            $this->recent_done_now = 10;
//            $this->books = $this->getAllBookCounts();
//            $this->tasks = $this->getTasks('', $this->recent_done_now);
//        } else {
            $this->tasks = $this->currentTasks();
        //        respond_to do |format|
        //            format.html
        //            format.csv { send_data(current_tasks.csv) }
        //            format.xls
        //        end
//        }
    }

    public function create() {
        $task = Task::create(['msg' => Input::get('msg'),
                        'name' => Auth::user()->name,
                        'user' => Auth::user()]);
        $task->update_status(Input::get('priority') || 'todo_m');
        $task->book = $task->getBookIdInMsgByUser(Auth::user());
        $task->save();

        $move_id = $this->isMovedFromBook(task) ? $task->id : 0;
        $task_html = View::make('task')->with([locals => ['task' => $task, 'display' => "none" ]]);

        return Response::json(['id'           => $task->id,
                               'status'       => $task->statusSym(),
                               'li_html'      => $task_html,
                               'move_task_id' => $move_id,
                               'task_counts'  => $this->getTaskCounts(),
                               'all_books'    => $this->getAllBookCounts() ])->setCallback('addTodoResponse');
    }

    public function update() {
        $task = Task::find(Input::get('id'));
        if (Input::get('status') != '') {
            $task->updateStatus(Input::get('status'));
        }
        $task->msg = Input::get('msg');
        $task->book = $task->getBookIdInMsgByUser(Auth::user());
        $task->save();

        $move_id = $this->isMovedFromBook($task) ? $task->id : 0;

        $this->doHooks($task);
        return Response::json(['task_counts'  => $this->getTaskCounts(),
                               'move_task_id' => $move_id,
                               'all_books'    => $this->getAllBookCounts() ])
                    ->setCallback('updateTaskJson');
    }

    public function destroy(){
        $task = Task::find(Input::get('id'));
        $task->delete();

        return Response::json(['task_counts'  => $this->getTaskCounts(),
                               'move_task_id' => 0,
                               'all_books'    => $this->getAllBookCounts() ])
                    ->setCallback('updateTaskJson');
    }

    public function updateOrder(){
        if (Input::get('id') == null){
          return 'update_order noop';
        }

        // 並び順の変更はタイムスタンプを更新したくない
        foreach(Input::get('id') as $i=>$task_id){
            $target_task = Task::find($task_id);
            $target_task->timestamps = false;
            $target_task->order_no = $i;
            $target_task->save();
            $target_task->timestamps = true;
        }

        return 'update_order ok';
    }

    public function filterOrUpdate(){
        $this->setLayout(Input::get('layout'));
        $this->renderJsonForUpdateBookJson(Input::get('filter'), 15);
    }

    public function silentUpdate(){
    $this->user_name = Auth::user()->name;

        return Response::json(['task_list_html' => $this->getTaskListHtml(Input::get('filter'), 15),
                               'task_counts' => $this->getTaskCounts(),
                               'all_books' => $this->getAllBookCounts()])
                    ->setCallback('updateSilentJson');
    }

    public function donelist(){
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

    public function  sendMail(){
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

    private function doHooks($task){
        switch ($task->status_sym) {
            case 'done':
                $hook_name = dirname(__FILE__) . '/hooks/update_task_' . Auth::user()->email;
                $command = 'source ' . $hook_name . ' \"DONE\" \"#{helper.strip_tags task.msg}\"';
                if (file_exists($hook_name)) {
                    system($command);
                }
        }
    }

    public function isMovedFromBook($task){
        return ($this->currentBook() != null) and ($this->currentBook()->id != ($task->book ? $task->book->id : 0 ));
    }

    public function setLayout($layout_name){
        if (!empty($layout_name)){
            Session::set('layout', $layout_name);
        }
    }

}
