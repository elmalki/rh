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
        Schema::create('pointage_worker', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\DailyWorker::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Pointage::class)->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('pointage_worker');
    }
};
