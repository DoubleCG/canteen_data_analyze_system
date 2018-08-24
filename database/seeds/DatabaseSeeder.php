<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

	// default and important data should be created here

	public function run() {
		$this->call([
			OrdersTableSeeder::class,
			NewsTableSeeder::class,
		]);
	}
}
