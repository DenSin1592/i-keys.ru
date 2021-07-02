<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCatalogTypeToCategories extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'categories',
            function (Blueprint $table) {
                $table->string('catalog_type')->nullable();
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
        Schema::table(
            'categories',
            function (Blueprint $table) {
                $table->dropColumn('catalog_type');
            }
        );
    }

}
