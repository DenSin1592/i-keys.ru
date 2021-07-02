<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveAliasUniqueFromNodesTable extends Migration
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
                $table->dropUnique('nodes_alias_unique');
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
                $table->unique('alias', 'nodes_alias_unique');
            }
        );
    }

}
