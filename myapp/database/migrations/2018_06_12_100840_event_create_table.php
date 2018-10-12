
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventCreateTable extends Migration
{
  	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('events', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->date('datum');
			$table->time('time');
			$table->double('price');
			$table->integer('location_id');
			$table->string('description')->nullable();
			$table->integer('user_id');
			$table->integer('minimum_members')->nullable();
			$table->integer('maximum_members')->nullable();
			$table->enum('status', ['accepted', 'tobechecked']);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('events');
	}
}
