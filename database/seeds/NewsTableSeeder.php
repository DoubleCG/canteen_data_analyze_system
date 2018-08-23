<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsTableSeeder extends Seeder {

	public function run() {

		// Each 2 seconds create a new order for news
		while (true) {
			$content = '{
                "clientid": "001",
                "phone": "12345678910",
                "paytype": "X",
                "order_num" : "4531894169846543242",
                "money": "421.24",
                "paytime": "2018-05-21 12:06:12",
                "foods": [{
                    "name": "锦鲤抄",
                    "number": 2,
                    "price": 21
                }, {
                    "name": "炒饭",
                    "number": 3,
                    "price": 14
                }, {
                    "name": "果冻",
                    "number": 48,
                    "price": 34
                }]
            }';

			DB::table('news')->insert(
				['content' => $content]
			);

			$now = Carbon::now()->getTimestamp();
			DB::table('orders')->insert([
				'clientid' => '001',
				'paytime' => $now,
				'order_num' => $now . "42",
				'paytype' => 'X',
				'money' => 421.24,
				'phone' => "12345678910",
				'foods' => '[{"name":"炒饭","number":"3","price":"14"},{"name":"果冻","number":"48","price":"34"},{"name":"果冻","number":"7","price":"24"}]',
			]);

			sleep(2);
		}
	}
}
