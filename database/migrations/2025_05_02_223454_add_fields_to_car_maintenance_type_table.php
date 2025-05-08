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
        Schema::table('car_maintenance_type', function (Blueprint $table) {
            $table->text('observation')->nullable();
            $table->decimal('montant',12,2)->unsigned()->nullable();
            $table->foreignIdFor(\App\Models\Maintenance::class)->nullable()->after('car_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_maintenance_type', function (Blueprint $table) {
            //
        });
    }
};
