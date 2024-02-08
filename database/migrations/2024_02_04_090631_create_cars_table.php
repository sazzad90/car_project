<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('make', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->enum('fuel_type', ['gas', 'diesel', 'electricity'])->nullable();
            $table->enum('drive', ['fwd', 'rwd', 'awd', '4wd'])->nullable();
            $table->integer('cylinders')->nullable();
            $table->enum('transmission', ['manual', 'automatic'])->nullable();
            $table->year('year')->nullable();
            $table->decimal('min_city_mpg', 8, 2)->nullable();
            $table->decimal('max_city_mpg', 8, 2)->nullable();
            $table->decimal('min_hwy_mpg', 8, 2)->nullable();
            $table->decimal('max_hwy_mpg', 8, 2)->nullable();
            $table->decimal('min_comb_mpg', 8, 2)->nullable();
            $table->decimal('max_comb_mpg', 8, 2)->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
