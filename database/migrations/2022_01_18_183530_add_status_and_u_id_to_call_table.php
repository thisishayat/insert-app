<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusAndUIdToCallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insert_app', function (Blueprint $table) {
            $table->smallInteger('status')->default(0)->after('input_date_time');
            $table->bigInteger('updated_by')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('insert_app', function (Blueprint $table) {
            //
        });
    }
}
