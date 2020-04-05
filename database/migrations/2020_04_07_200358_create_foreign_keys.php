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
        
        Schema::table('data_points', function (Blueprint $table) {
            $table->foreign('sensor_id')->references('id')->on('sensors');
        });
        

        Schema::table('sensors', function (Blueprint $table) {
            $table->foreign('sensor_type_id')->references('id')->on('sensor_types');
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
