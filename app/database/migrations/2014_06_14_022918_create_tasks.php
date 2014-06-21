<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function($table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('book_id')->unsigned()->nullable();
			$table->integer('status');
			$table->string('name');
			$table->string('msg');
			$table->dateTime('doing_at')->nullable();
			$table->integer('pomo')->default(0);
			$table->integer('order_no')->default(0);
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
		Schema::drop('tasks');
	}

}
