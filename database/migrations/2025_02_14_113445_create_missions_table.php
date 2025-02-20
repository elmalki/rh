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
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('mission')->nullable();
            $table->date('depart_date')->nullable();
            $table->date('return_date')->nullable();
            $table->foreignIdFor(\App\Models\Personnel::class)->nullable();
            $table->foreignIdFor(\App\Models\MissionObjective::class)->nullable();
            $table->foreignIdFor(\App\Models\Destination::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
