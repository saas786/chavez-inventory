<?php

use App\Models\Keyboard;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrebuiltOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prebuilt_orders', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->foreignIdFor(Keyboard::class)->constrained();
			$table->unsignedFloat('price');
			$table->string('image_url');
			$table->text('description')->nullable();
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
		Schema::dropIfExists('prebuilt_orders');
	}
}
