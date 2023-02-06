<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        // if (!Schema::hasTable('student'))
            Schema::create('student', function (Blueprint $table) {
                $table->string('studentid')->primary();
                $table->string('dormitaryid')->nullable();
                $table->string('name');
                $table->string('gender');
                $table->string('classes');
                $table->string('pwd');
                $table->string('status')->default('住宿');

                $table->foreign('dormitaryid')->references('dormitaryid')->on('dormitary');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('student');
    }
}
