<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCode1cFieldToCategoriesTable extends Migration
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
                $table->string('code_1c')->nullable()->after('in_tree_publish');
                $table->unique('code_1c', 'categories_code_1c_unique');
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
                $table->dropUnique('categories_code_1c_unique');
                $table->dropColumn('code_1c');
            }
        );
    }
}
