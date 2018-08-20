<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration {

	private $tablename = 'password_resets';

	public function up() {

		if (Schema::hasTable($this->tablename)) {
			echo "Table named " . $this->tablename . " is exist.\n";
			return;
		}

		Schema::create($this->tablename, function (Blueprint $table) {
			$table->string('email')->index();
			$table->string('token');
			$table->timestamp('created_at')->nullable();
		});
	}

	public function down() {
		Schema::dropIfExists($this->tablename);
	}
}
