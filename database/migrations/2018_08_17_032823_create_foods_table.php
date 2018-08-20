<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodsTable extends Migration {
	private $tablename = 'foods';

	public function up() {
		if (Schema::hasTable($this->tablename)) {
			echo "Error: Table named " . $this->tablename . " is exist.\n";
			return;
		}

		//如果数据库中没 orders 表，则创建
		Schema::create($this->tablename, function (Blueprint $table) {
			$table->increments("id")->nullable(false)->index();
			$table->string("name", 30);
			$table->string("type", 15);
			$table->double("price", 5, 2);
			$table->string("pic", 200);
		});
	}

	public function down() {
		Schema::dropIfExists($this->tablename);
	}
}
