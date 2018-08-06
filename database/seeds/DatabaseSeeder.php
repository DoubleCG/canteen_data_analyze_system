<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
		$now = Carbon::now()->getTimestamp();
		$monthAgo = Carbon::now()->subMonth()->getTimestamp();

		// echo $now . ' ' . $monthAgo;
		// echo gettype($now);
		// 生成过去一个月的订单数据

		while ($monthAgo < $now) {
			$monthAgo += (int) (rand(100, 1000));
			DB::table('orders')->insert([
				'client' => '001',
				'paytime' => $monthAgo,
				'paytype' => 'X',
				'phone' => "12345678910",
				'foods' => '[{"name":"炒饭","number":"3","price":"14"},{"name":"果冻","number":"48","price":"34"},{"name":"果冻","number":"7","price":"24"}]',
			]);
		}

		// $this->call(UsersTableSeeder::class);
	}
}
