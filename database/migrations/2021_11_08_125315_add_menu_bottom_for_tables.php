<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMenuBottomForTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nodes', function (Blueprint $table){
            $table->boolean('menu_bottom')->default(false);
        });

        Schema::table('categories', function (Blueprint $table){
            $table->boolean('menu_top')->default(false);
            $table->boolean('menu_bottom')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function(Blueprint $table) {
            $table->dropColumn('menu_bottom');
            $table->dropColumn('menu_top');
        });
        Schema::table('nodes', function(Blueprint $table) {
            $table->dropColumn('menu_bottom');
        });
    }
}
