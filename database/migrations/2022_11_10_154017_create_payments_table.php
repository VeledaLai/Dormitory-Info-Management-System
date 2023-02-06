<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if (!Schema::hasTable('payment'))
            Schema::create('payment', function (Blueprint $table) {
                $table->string('studentid')->primary();
                $table->string('year')->default(date('Y'))->primary();
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
        Schema::dropIfExists('payment');
    }
}
