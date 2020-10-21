<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyboardComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keyboard_components', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            
            $table->foreignIdFor( \App\Models\KeyboardComponentType::class );
            $table->foreignIdFor( \App\Models\Layout::class );
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedFloat('price')->default(0);

            $table->string('image_url')->nullable();
            $table->string('status')->default('Available');
            
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
        Schema::dropIfExists('keyboard_components');
    }
}
