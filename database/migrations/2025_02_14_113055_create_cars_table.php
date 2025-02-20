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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('plate')->nullable();
            $table->string('model')->nullable();
            $table->unsignedInteger('kilometrage')->nullable();
            $table->unsignedInteger('tank_capacity')->nullable();
            $table->string('motor')->nullable();
            $table->string('n_chassis')->nullable();
            $table->foreignIdFor(\App\Models\CarBrand::class)->nullable();
            $table->foreignIdFor(\App\Models\CarType::class)->nullable();
            $table->foreignIdFor(\App\Models\Fuel::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
