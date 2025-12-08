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
        Schema::create('assessment_formula_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formula_id')->constrained('assessment_formulas')->onDelete('cascade');
            $table->foreignId('assessment_type_id')->constrained('assessment_types')->onDelete('cascade');
            $table->decimal('weight', 5, 2); // bobot dalam persen, contoh: 60.00
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_formula_details');
    }
};
