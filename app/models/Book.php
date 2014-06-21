<?php

class Book extends Eloquent {

	public static $book_name_patterns = [
		'/^\[(.+?)\][ ]*/',
		'/^【(.+?)】[ ]*/',
	];

	public static $DEFAULT_NAME = 'All Tasks';

	protected $guarded = [];

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

	public static function getIdInMsg($user, $msg)
	{
		foreach (static::$book_name_patterns as $book_name_pattern) {
			$matches;
			if (preg_match($book_name_pattern, $msg, $matches)) {
				return $user->books->findOrCreateByName($matches[1]);
			}
		}
		return null;
	}

}
