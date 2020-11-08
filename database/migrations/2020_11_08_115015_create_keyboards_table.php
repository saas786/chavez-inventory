<?php

use App\Models\Cable;
use App\Models\Layout;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyboardsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('keyboards', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Layout::class)->constrained();
			$table
				->foreignId('switch_id')
				->references('id')
				->on('keyboard_components');
			$table
				->foreignId('keycap_id')
				->references('id')
				->on('keyboard_components');
			$table
				->foreignId('plate_id')
				->references('id')
				->on('keyboard_components');
			$table
				->foreignId('case_id')
				->references('id')
				->on('keyboard_components');
			$table->foreignIdFor(Cable::class)->constrained();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('keyboards');
	}
}
