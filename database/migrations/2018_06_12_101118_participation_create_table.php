<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParticipationCreateTable extends Migration
{
    	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('participations', function (Blueprint $table) {
			$table->integer('event_id');
			$table->integer('user_id');
			$table->boolean('paid');
			$table->integer('result');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('participations');
	}
}
