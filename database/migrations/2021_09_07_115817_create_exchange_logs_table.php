<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'exchange_logs',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->boolean('solved')->default(false);
                $table->string('exchange_type')->nullable();
                $table->string('type')->nullable();
                $table->string('file_name')->nullable();
                $table->string('line_number')->nullable();
                $table->string('category_code_1c')->nullable();
                $table->string('product_code_1c')->nullable();
                $table->string('attribute_code_1c')->nullable();
                $table->string('client_code_1c')->nullable();
                $table->string('order_code_1c')->nullable();
                $table->text('message')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_logs');
    }
}
