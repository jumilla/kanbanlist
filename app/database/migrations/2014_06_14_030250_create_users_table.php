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
			$table->string('password');
			$table->text('permissions')->nullable();
			$table->boolean('activated')->default(0);
			$table->string('activation_code')->nullable();
			$table->timestamp('activated_at')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->string('persist_code')->nullable();
			$table->string('reset_password_code')->nullable();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('bg_img');
			$table->string('layout');
			$table->integer('pomo');
			$table->timestamps();			

			$table->index('activation_code');
			$table->index('reset_password_code');
			
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
