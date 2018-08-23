<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder {

	use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

	public function run() {

		// create an admin account;
		DB::table("users")->insert([
			"name" => "testAdmin",
			"email" => "test@test.com",
			"password" => "$2y$10\$N/74MbaQOil8qr431FRBjukRXeRDsCYq/gLIc8HrHhyVNy5mU3yDK", // 密码test123
		]);
	}
}
