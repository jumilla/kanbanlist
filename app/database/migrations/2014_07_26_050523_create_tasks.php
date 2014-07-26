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
		Schema::create('tasks', function($table) {
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('book_id')->nullable();
			$table->integer('order_no')->default(0);
			$table->integer('status');
			$table->string('name');
			$table->string('message');
			$table->dateTime('doing_at')->nullable();
			$table->integer('pomo')->default(0);
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
		Schema::dropIfExists('tasks');
	}

}
