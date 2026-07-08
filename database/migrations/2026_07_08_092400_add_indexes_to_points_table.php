<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('points', function (Blueprint $table) {
            $table->index(['device_id', 'sensor_id', 'added_on'], 'points_device_sensor_added_on_idx');
        });
    }

    public function down(): void
    {
        Schema::table('points', function (Blueprint $table) {
            $table->dropIndex('points_device_sensor_added_on_idx');
        });
    }
};
