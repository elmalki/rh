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
        Schema::create('car_maintenance_type', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Car::class)->constrained();
            $table->foreignIdFor(\App\Models\MaintenanceType::class)->constrained();
            $table->integer('km')->nullable();
            $table->integer('next_km')->nullable();
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_maintenance_type');
    }
};
