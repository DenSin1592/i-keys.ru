<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInTreePublishFields extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'nodes',
            function (Blueprint $table) {
                $table->boolean('in_tree_publish')->default(false);
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
            'nodes',
            function (Blueprint $table) {
                $table->dropColumn('in_tree_publish');
            }
        );
    }
}
