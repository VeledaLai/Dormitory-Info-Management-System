<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Dormitory;
use Illuminate\Support\Facades\DB;

class CreateDormitoryRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if (!Schema::hasTable('dormitory_records')) {
            Schema::create('dormitory_records', function (Blueprint $table) {
                $table->string('dormitoryid')->primary();
                $table->integer('remaining_beds')->nullable();
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
        Schema::dropIfExists('dormitory_records');
    }
}
