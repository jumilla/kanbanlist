<?php

class TasksController extends BaseController {
	

	public function index()
	{
		return View::make('tasks.index');
	}

	public function filterOrUpdate()
	{
	}

}
