<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('points', function (Blueprint $table) {
            $table->foreign('sensor_id')->references('id')->on('sensors');
            $table->foreign('device_id')->references('id')->on('devices');
        });
        

        Schema::table('device_sensor', function (Blueprint $table) {
            $table->foreign('sensor_id')->references('id')->on('sensors');
            $table->foreign('device_id')->references('id')->on('devices');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
