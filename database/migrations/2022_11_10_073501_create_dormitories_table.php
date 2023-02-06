<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDormitoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if (!Schema::hasTable('dormitory'))
            Schema::create('dormitory', function (Blueprint $table) {
                $table->string('dormitaryid')->primary();
                $table->string('buildingid');
                $table->string('door_num');
                $table->string('bed_num');

                $table->foreign('buildingid')->references('buildingid')->on('manager');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dormitory');
    }
}
