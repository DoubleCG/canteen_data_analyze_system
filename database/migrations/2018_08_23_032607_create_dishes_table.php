<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDishesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('dishes', function (Blueprint $table) {
			$table->increments("id")->nullable(false)->index();
			$table->string("name", 30);
			$table->string("type", 15);
			$table->double("price", 5, 2);
			$table->string("pic", 200);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('dishes');
	}
}
