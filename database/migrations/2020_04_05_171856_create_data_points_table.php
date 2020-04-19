<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('sensor_id');
            $table->float('value',8,2)->default(0.0);
            $table->timestampTz('added_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_points');
    }
}
