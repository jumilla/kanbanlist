<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');

		DB::table('users')->truncate();
		User::create([
			'username' => 'Sampler',
			'email' => 'sample@kanban.list',
			'password' => 'sample',
			'password_confirmation' => 'sample',
			'confirmed' => true,
		]);

		DB::table('tasks')->truncate();
		Task::create([
			'user_id' => 1,
			'book_id' => 1,
			'order_no' => 1,
			'status' => 1,
			'name' => 'sample_name',
			'message' => 'sample_message',
			'doing_at' => 'now()',
			'pomo' => 1,
		]);
	}

}
