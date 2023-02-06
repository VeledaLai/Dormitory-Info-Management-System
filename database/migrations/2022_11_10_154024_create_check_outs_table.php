<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if (!Schema::hasTable('check_out'))
            Schema::create('check_out', function (Blueprint $table) {
                $table->string('studentid')->primary();
                $table->string('buildingid');
                $table->string('reason');
                $table->string('status')->default('pending');

                $table->foreign('studentid')->references('studentid')->on('student');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_out');
    }
}
