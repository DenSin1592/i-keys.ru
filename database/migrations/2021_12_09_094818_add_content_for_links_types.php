<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddContentForLinksTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_type_pages', function (Blueprint $table) {
            $table->text('content_for_links_type')->nullable();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->text('content_for_links_type')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_type_pages', function (Blueprint $table) {
            $table->dropColumn('content_for_links_type');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('content_for_links_type');
        });
    }
}
