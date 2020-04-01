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
        });
        
        Schema::table('events', function (Blueprint $table) {
            $table->float('diff_humidity', 4, 2)->default(0.0)->after('humidity');
        });
        
        Schema::table('events', function (Blueprint $table) {
            $table->integer('diff_time')->default(0)->after('added_on');
        });
        
        Schema::table('events', function (Blueprint $table) {
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
        Schema::table('events', function (Blueprint $table) {
            $table->string('sensor', 64);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('diff_time');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('diff_humidity');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('diff_temperature');
        });

    }
}
