<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('device_sensor', function (Blueprint $table) {
            $table->string('chart_type', 128)->default('LineSeries')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_sensor', function (Blueprint $table) {
            $table->dropColumn('chart_type');
        });
    }
};
