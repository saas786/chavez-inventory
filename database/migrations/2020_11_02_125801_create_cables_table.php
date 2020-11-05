<?php

use App\Models\Color;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCablesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cables', function (Blueprint $table) {
			$table->id();
			$table->tinyInteger('cable_length');
			$table->tinyInteger('coil_length');
			$table->foreignIdFor(Color::class)->constrained();
			$table->boolean('double_sleeved')->default(false);
			$table
				->foreignId('double_sleeve_color_id')
				->nullable()
				->references('id')
				->on('colors');
			$table->boolean('detachable')->default(false);
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
		Schema::dropIfExists('cables');
	}
}
