<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilityBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utility_bill', function (Blueprint $table) {
            $table->string('year')->primary();
            $table->string('month')->primary();
            $table->string('dormitoryid')->primary();
            $table->string('eletricfee');
            $table->string('waterfee');
            $table->string('status')->default('pending');

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
        Schema::dropIfExists('utility_bill');
    }
}
