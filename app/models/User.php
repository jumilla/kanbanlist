<?php

use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Confide\ConfideUser;

class User extends Eloquent implements ConfideUserInterface {

	use ConfideUser;

	public static function isSampleUser()
	{
		return Auth::user()->email == "sample@kanban.list";
	}

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = array('password', 'remember_token');
		
	private $_base_bg_path;
	
	public function books()
	{
		return $this->hasMany('Book');
	}

	public function tasks()
	{
		return $this->hasMany('Task');
	}
	
	public function bgImgPath()
	{
		return $this->background_image ?: null;
	}

	public static function byName($name)
	{
		return User::where('name', '=', $name)->first();
	}

	public function exist($name)
	{
		$user = self::byName($name);
		if ($user){
			return true;
		}
		return false;
	}
	
	public function bgImgByName($name)
	{
		$user = self::byName($name);
		if ($user){
			return $user->background_image;
		}
		return null;
	}
	
	
	public function layoutByName($name)
	{
		$user = self::byName($name);
		if ($user){
			return $user->layout;
		}
		return null;
	}
	
	public function incPomo($name)
	{
		$user = self::byName($name);
		if (!$user){
			return null;
		}
		$user->pomo += 1;
		$user->save();
	}

}
