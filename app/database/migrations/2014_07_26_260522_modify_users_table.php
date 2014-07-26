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
			$table->text('permissions')->nullable();
//			$table->boolean('activated')->default(0);
//			$table->string('activation_code')->nullable();
//			$table->timestamp('activated_at')->nullable();
			$table->timestamp('last_login')->nullable();
//			$table->string('persist_code')->nullable();
//			$table->string('reset_password_code')->nullable();
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
		Schema::dropIfExists('users');
	}

}
