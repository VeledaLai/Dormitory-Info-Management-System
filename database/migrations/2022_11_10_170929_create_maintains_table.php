<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintain', function (Blueprint $table) {
            $table->id();
            $table->string('dormitoryid');
            $table->string('goodname');
            $table->string('reason');
            $table->string('phone');
            $table->string('applytime');
            $table->string('ctime')->nullable();

            $table->foreign('dormitoryid')->references('dormitoryid')->on('dormitory');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintain');
    }
}
