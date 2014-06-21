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
			'email' => 'sample@kanban.list',
			'password' => Hash::make('sample'),
			'activated' => true,
		]);
	}

}
