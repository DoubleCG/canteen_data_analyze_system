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

		// if (!Schema::hasTable('orders')) {
		// Schema::create('orders', function (Blueprint $table) {
		// 	$table->increments('id');
		//              $table->integer('client');
		//              $table->
		// });
		//             create table `orders`(
		//     id int(11)  NOT NULL auto_increment,
		//     client int(11) NOT NULL,
		//     paytime char(10) NOT NULL,
		//     paytype varchar(20) NOT NULL,
		//     phone varchar(15) NOT NULL,
		//     foods varchar(1000) NOT NULL,
		//     PRIMARY KEY (`ID`) USING BTREE
		// );
		// }

		// if(!Schema::hasTable('news')){
		// create table `news`(
		//     id int(11) NOT NULL auto_increment,
		//     content varchar(1000) NOT NULL,
		//     PRIMARY KEY (`ID`) USING BTREE
		// );
		// }
		//
		// }

		// if(!Schema::hasTable('foods')){
		//     create table `foods`(
		//         id int(11) NOT NULL auto_increment,
		//         name varchar(30) NOT NULL,
		//         type varchar(15) NULL,
		//         price double(5,2) NOT NULL,
		//         pic varchar(100) NULL,
		//         PRIMARY KEY (`ID`) USING BTREE
		//     );
		// }

		// if (Schema::hasColumn('users', 'email')) {

		// }

		$now = Carbon::now()->getTimestamp();
		$monthAgo = Carbon::now()->subMonth()->getTimestamp();

		echo $now . '---->' . $monthAgo;
		// echo gettype($now);
		// 生成过去一个月订单

		while ($monthAgo < $now) {
			$monthAgo += (int) (rand(10, 100));
			DB::table('orders')->insert([
				'client' => '001',
				'paytime' => $monthAgo,
				'paytype' => 'X',
				'phone' => "12345678910",
				'foods' => '[{"name":"炒饭","number":"3","price":"14"},{"name":"果冻","number":"48","price":"34"},{"name":"果冻","number":"7","price":"24"}]',
			]);
		}

		// if(check_table_is_exist('show databases;','test'))
		// create table `news`(
		//     id int(11) NOT NULL auto_increment,
		//     content varchar(1000) NOT NULL,
		//     PRIMARY KEY (`ID`) USING BTREE
		// );

		// $this->call(UsersTableSeeder::class);
	}
}
