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
        Schema::create('equipe_personnel', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Equipe::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Personnel::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipe_personnel');
    }
};
