<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FoodsTableSeeder extends Seeder {

	public function run() {
		// Create orders' data here

		$now = Carbon::now()->getTimestamp();
		$monthAgo = Carbon::now()->subMonth()->getTimestamp();

		echo "Create orders in 30 days from " . $now . ' to ' . $monthAgo;

	}
}
