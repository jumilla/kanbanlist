<?php
/**
 * @author: Chungth <huychungtran@gmail.com>
 * @since: 2014/06/14
 * */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users',function(Blueprint $table){
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('encrypted_password');
			$table->string('reset_password_token')->unique();
			$table->timestamp('reset_password_sent_at');
			$table->timestamp('remember_created_at');
			$table->integer('sign_in_count')->unsigned();
			$table->string('current_sign_in_ip');
			$table->string('last_sign_in_ip');
			$table->string('password_salt');
			$table->string('confirmation_token');
			$table->timestamp('confirmed_at');
			$table->timestamp('confirmation_sent_at');
			$table->integer('failed_attemps')->unsigned();
			$table->string('unlock_token');
			$table->timestamp('locked_at');
			$table->string('authentication_token');
			$table->string('name');
			$table->string('pass');
			$table->string('bg_img');
			$table->string('layout');
			$table->integer('pomo');
			$table->timestamps();			

			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
