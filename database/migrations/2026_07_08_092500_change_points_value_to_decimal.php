<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('points', function (Blueprint $table) {
            $table->decimal('value', 8, 2)->default(0.00)->change();
        });
    }

    public function down(): void
    {
        Schema::table('points', function (Blueprint $table) {
            $table->float('value', 8, 2)->default(0.0)->change();
        });
    }
};
