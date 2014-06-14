<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	
	
	private $_email;
	private $_password;
	private $_password_confirmation;
	private $_remember_me;
	private $_name;
	private $_bg_img;
	private $_layout;
	private $_pomo;
	
	private $_base_bg_path;
	
	public function bgImgPath(){
		
	}
	
	public function addUser($name){
		
	}
	
	public function byName($name){
		return User::where('name', '=', $name)->firstOrFail();
		App::error(function(ModelNotFoundException $e)
		{
		    return null;
		});
	}
	
	public function exist($name){
		if (User::where('name', '=', $name)->get()){
			return true;
		}
		return false;
	}
	
	public function bgImgByName($name){
		$user = $this->byName($name);
		if ($user){
			return $user->bg_img;
		}
		return null;
	}
	
	public function setBgImg($name, $bg_img){
		$user = $this->byName($name);
		if (!$user){
			return null;
		}
		$user->bg_img = $bg_img;
		$user->save();
	}
	
	public function layoutByName($name){
		$user = $this->byName($name);
		if ($user){
			return $user->layout;
		}
		return null;
	}
	
	public function setLayout($name, $layout){
		$user = $this->byName($name);
		if (!$user){
			return null;
		}
		$user->layout = $layout;
		$user->save();
	}
	
	public function incPomo($name){
		$user = $this->byName($name);
		if (!$user){
			return null;
		}
		$user->pomo += 1;
		$user->save();
	}

}
