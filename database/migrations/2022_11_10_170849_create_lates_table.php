<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('late', function (Blueprint $table) {
            $table->string('studentid')->primary();
            $table->string('reason');
            $table->string('recordtime')->nullable();
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
        Schema::dropIfExists('late');
    }
}
