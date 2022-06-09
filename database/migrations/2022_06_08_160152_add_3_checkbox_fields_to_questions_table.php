<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Add3CheckboxFieldsToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->boolean('show_test_code')->after('test_code')->default(0);
            $table->boolean('show_front_code')->after('front_code')->default(0);
            $table->boolean('show_config_code')->after('config_code')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('show_config_code');
            $table->dropColumn('show_front_code');
            $table->dropColumn('show_test_code');
        });
    }
}
