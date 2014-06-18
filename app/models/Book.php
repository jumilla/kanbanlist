<?php

class Book extends Eloquent {

	public static $DEFAULT_NAME = 'All Tasks';

	public function defaulf_name()
	{
		return static::$DEFAULT_NAME;
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function tasks()
	{
		return $this->hasMany('Task');
	}

}
