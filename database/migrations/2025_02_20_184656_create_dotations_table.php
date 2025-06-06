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
        Schema::create('dotations', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable();
            $table->string('n_bon')->nullable();
            $table->decimal('value',10,2)->unsigned()->nullable();
            $table->foreignIdFor(\App\Models\Car::class)->nullable();
            $table->foreignIdFor(\App\Models\Personnel::class)->nullable();
            $table->foreignIdFor(\App\Models\Mission::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dotations');
    }
};
