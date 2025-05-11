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
        Schema::create('deplacements', function (Blueprint $table) {
            $table->id();
            $table->integer('km_depart')->unsigned()->nullable();
            $table->integer('km_arrivee')->unsigned()->nullable();
            $table->string('motif')->nullable();
            $table->date('date')->nullable();
            $table->foreignIdFor(\App\Models\Car::class)->nullable()->constrained();
            $table->foreignIdFor(\App\Models\Personnel::class)->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deplacements');
    }
};
