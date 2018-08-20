<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

	// public $testDB = new InteractsWithDatabase;
	use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
	// use InteractsWithDatabase;

	// $testDB = new InteractsWithDatabase;

	public function run() {
		echo "UsersTableSeeder";
		$result = $this->assertDatabaseHas('users', [
			'emial' => 'sally@example.com',
		]);

		echo $result;
	}
}
