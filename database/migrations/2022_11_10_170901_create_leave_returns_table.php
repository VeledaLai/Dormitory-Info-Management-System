<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_return', function (Blueprint $table) {
            $table->string('studentid')->primary();
            $table->string('leavetime')->nullable();
            $table->string('returntime')->nullable();
            $table->id()->autoIncrement();

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
        Schema::dropIfExists('leave_return');
    }
}
