<?php

class Book extends Eloquent {

	public static $book_name_patterns = [
		'/^\[(.+?)\][ ]*/',
		'/^【(.+?)】[ ]*/',
	];

	public static $DEFAULT_NAME = 'All Tasks';

	protected $guarded = ['id'];

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
				$bookName = $matches[1];
				$book = static::whereName($bookName)->first();
				if (!$book) {
					$book = static::create([
						'name' => $bookName,
					]);
				}
				return $book->id;
			}
		}
		return null;
	}

}
