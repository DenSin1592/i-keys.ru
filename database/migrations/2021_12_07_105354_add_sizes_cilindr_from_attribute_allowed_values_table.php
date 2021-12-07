<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSizesCilindrFromAttributeAllowedValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_allowed_values', static function (Blueprint $table) {
            $table->string('value_first_size_cylinder')->nullable();
            $table->string('value_second_size_cylinder')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attribute_allowed_values', static function (Blueprint $table) {
            $table->dropColumn('value_second_size_cylinder');
            $table->dropColumn('value_first_size_cylinder');
        });
    }
}
