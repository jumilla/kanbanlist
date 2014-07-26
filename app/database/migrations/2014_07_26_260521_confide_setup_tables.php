<?php

use Illuminate\Database\Migrations\Migration;

class ConfideSetupTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		// Creates the users table
		Schema::create('users', function($table) {
			$table->increments('id');
			$table->integer('type');
			$table->string('username');
			$table->string('email');
			$table->string('password');
			$table->string('confirmation_code')->nullable();
			$table->boolean('confirmed')->default(false);
			$table->timestamps();
		});

		// Creates password reminders table
		Schema::create('password_reminders', function($table) {
			$table->string('email');
			$table->string('token');
			$table->timestamp('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
		Schema::dropIfExists('password_reminders');
		Schema::dropIfExists('users');
	}

}
