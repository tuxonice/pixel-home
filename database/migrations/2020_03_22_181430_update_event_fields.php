<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEventFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->float('diff_temperature', 4, 2)->default(0.0)->after('temperature');
            $table->float('diff_humidity', 4, 2)->default(0.0)->after('humidity');
            $table->integer('diff_time')->default(0.0)->after('added_on');
            $table->dropColumn('sensor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
