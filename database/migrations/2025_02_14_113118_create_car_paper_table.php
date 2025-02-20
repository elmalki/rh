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
        Schema::create('car_paper', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Paper::class)->nullable();
            $table->foreignIdFor(\App\Models\Car::class)->nullable();
            $table->string('file', 100)->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_paper');
    }
};
