<?php
class Book extends Eloquent {
	public static $default_name = 'All Tasks'

	public function defaulf_name()
	{
		return $this->default_name;
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
