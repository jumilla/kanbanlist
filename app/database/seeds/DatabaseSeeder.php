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
			'name' => 'Sampler',
			'email' => 'sample@kanban.list',
			'password' => Hash::make('sample'),
			'activated' => true,
		]);
		DB::table('tasks')->truncate();
		Task::create([
			'user_id' => '1',
			'book_id' => '1',
			'status' => '1',
			'name' => 'sample_name',
			'msg' => 'sample_msg',
			'doing_at' => 'now()',
			'pomo' => '1',
			'order_no' => '1',
			
		]);
	}

}
