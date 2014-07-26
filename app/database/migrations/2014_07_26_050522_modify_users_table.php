<?php
/**
 * @author: Chungth <huychungtran@gmail.com>
 * @since: 2014/06/14
 * */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users',function(Blueprint $table) {
			$table->timestamp('last_logged_at')->nullable();
			$table->string('background_image')->nullable();
			$table->string('layout')->nullable();
			$table->integer('pomo')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}

}
