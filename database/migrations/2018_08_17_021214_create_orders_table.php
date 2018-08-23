<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {
	private $tablename = 'orders';

	public function up() {

		if (Schema::hasTable($this->tablename)) {
			echo "Error: Table named " . $this->tablename . " is exist.\n";
			return;
		}

		//如果数据库中没 orders 表，则可以创建

		Schema::create($this->tablename, function (Blueprint $table) {
			$table->increments('id');
			$table->string('clientid', 11);
			$table->string('order_num', 20);
			$table->string('paytime', 10);
			$table->double('money', 5, 2);
			$table->string('paytype', 3);
			$table->string('phone', 16);
			$table->string('foods', 2000); // JSON 字符串，清单，如果对money有争议，以这个为准。
		});

	}

	public function down() {
		Schema::dropIfExists($this->tablename);

	}
}
