<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldsInAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn([
                'use_in_filter',
                'for_admin_filter',
                'icon',
                'filter_name',
                'hidden'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->boolean('use_in_filter')->default(false);
            $table->boolean('for_admin_filter')->default(false);
            $table->string('filter_name')->nullable();
            $table->boolean('hidden')->default(false);
            $table->string('icon')->nullable();
        });
    }
}
