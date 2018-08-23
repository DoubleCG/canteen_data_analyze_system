<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder {

	public function run() {
		// Create orders' data here

		$now = Carbon::now()->getTimestamp();
		$monthAgo = Carbon::now()->subMonth()->getTimestamp();

		echo "Create orders in 30 days from " . $now . ' to ' . $monthAgo;

		while ($monthAgo < $now) {
			$monthAgo += (int) (rand(10, 100));
			DB::table('orders')->insert([
				'clientid' => '001',
				'order_num' => $now . "42",
				'paytime' => $monthAgo,
				'money' => 421.24,
				'paytype' => 'X',
				'phone' => "12345678910",
				'foods' => '[{"name":"炒饭","number":"3","price":"14"},{"name":"果冻","number":"48","price":"34"},{"name":"果冻","number":"7","price":"24"}]',
			]);

		}
	}
}
