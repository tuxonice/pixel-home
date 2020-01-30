<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64);
            $table->float('temperature', 4, 2)->nullable();
            $table->float('humidity', 4, 2)->nullable();
            $table->boolean('flood')->nullable();
            $table->float('battery', 4, 2)->nullable();
            $table->timestamp('added_on', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensor');
    }
}
