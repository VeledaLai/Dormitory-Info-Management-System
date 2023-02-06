<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if (!Schema::hasTable('access_card'))
            Schema::create('access_card', function (Blueprint $table) {
                $table->string('studentid')->primary();
                $table->string('buildingid');
                $table->string('status')->default(0);

                $table->foreign('buildingid')->references('buildingid')->on('dormitory');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_card');
    }
}
