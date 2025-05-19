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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->enum('sexe', ['Homme', 'Femme'])->nullable();
            $table->string('ppr')->nullable();
            $table->string('cnie')->nullable();
            $table->string('driving_license')->nullable();
            $table->string('grade')->nullable();
            $table->date('birthdate')->nullable();
            $table->date('recruitment_date')->nullable();
            $table->boolean('is_driver')->nullable();
            $table->enum('situation',['Célébataire','Marié(e)','Remarié(e)','Divorcé(e)','Veuf(ve)'])->nullable();
            $table->unsignedInteger('children')->nullable();
            $table->unsignedInteger('leave_days')->default(22);

            $table->foreignIdFor(\App\Models\Department::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
