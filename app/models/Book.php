<?php

class Book extends Eloquent {

	public static $book_name_patterns = [
		'/^\[(.+?)\][ ]*/',
		'/^【(.+?)】[ ]*/',
	];

	public static $DEFAULT_NAME = 'All Tasks';

	protected $guarded = ['id'];

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function tasks()
	{
		return $this->hasMany('Task');
	}

	public static function getIdInMessage($user, $message)
	{
		foreach (static::$book_name_patterns as $book_name_pattern) {
			$matches;
			if (preg_match($book_name_pattern, $message, $matches)) {
				$bookName = $matches[1];
				$book = static::whereName($bookName)->first();
				if (!$book) {
					$book = static::create([
						'user_id' => $user->id,
						'name' => $bookName,
					]);
				}
				return $book->id;
			}
		}
		return null;
	}

}
