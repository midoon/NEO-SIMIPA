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
        Schema::create('assessment_formulas', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // contoh: "Formula Semester 1"
            $table->string('academic_year'); // contoh: 2024/2025
            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_formulas');
    }
};
