<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_series', static function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('attribute_1c_code')->nullable();
            $table->string('attribute_value_1c_code')->nullable();

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
        Schema::dropIfExists('products_series');
    }
}
