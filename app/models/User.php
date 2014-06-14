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

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	
	
	private $_email;
	private $_password;
	private $_password_confirmation;
	private $_remember_me
	private $_name;
	private $_bg_img;
	private $_layout;
	private $_pomo
	
	private $_base_bg_path;
	
	public bg_img_path(){
		
	}
	
	public add_user($name){
		
	}
	
	public by_name($name){
		return User::where('name', '=', $name)->firstOrFail();
	}
	
	public exist($name){
		if (User::where('name', '=', $name)->get()){
			return true;
		}
		return false;
	}
	
	public bg_img_by_name($name){
		$user = $this->by_name($name);
		if ($user){
			return $user->bg_img;
		}
		return null;
	}
	
	public set_bg_img($name, $bg_img){
		
	}
	
	public layout_by_name($name){
		
	}
	
	public set_layout($name, $layout){
		
	}
	
	public inc_pomo($name){
		
	}

}
