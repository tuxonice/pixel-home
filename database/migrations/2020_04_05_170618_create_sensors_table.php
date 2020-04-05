<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sensor_type_id');
            $table->unsignedBigInteger('device_id');
            $table->string('name', 128);
            $table->string('unit', 64)->comment('i.e. temperature, humidity');
            $table->string('unit_symbol', 64)->comment('i.e. ºC, %');
            $table->boolean('active')->default(0);
            $table->softDeletes('deleted_at');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensors');
    }
}
