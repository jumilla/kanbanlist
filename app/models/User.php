<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	public static $rules = array(
		 'email' => 'required | email',
		 'name'  => 'required',
		 'password'=>'required',
		 'password_confirmation' => 'same:password'
	);

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
	
	public function bgImgPath(){
		if ($this->background_image){
			return $this->background_image;
		}else{
			return null;
		}
	}
		
	public static function byName($name){
		return User::where('name', '=', $name)->first();
		
	}
	
	public function exist($name){
		$user = self::byName($name);
		if ($user){
			return true;
		}
		return false;
	}
	
	public function bgImgByName($name){
		$user = self::byName($name);
		if ($user){
			return $user->background_image;
		}
		return null;
	}
	
	
	public function layoutByName($name){
		$user = self::byName($name);
		if ($user){
			return $user->layout;
		}
		return null;
	}
	
	public function incPomo($name){
		$user = self::byName($name);
		if (!$user){
			return null;
		}
		$user->pomo += 1;
		$user->save();
	}
}
