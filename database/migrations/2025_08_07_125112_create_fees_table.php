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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_fee_id')->constrained(
                table: 'grade_fees',
                indexName: 'fee_grade_fee_id'
            )->onDelete('cascade');
            $table->foreignId('student_id')->constrained(
                table: 'students',
                indexName: 'fee_student_id'
            )->onDelete('cascade');

            $table->float('amount');
            $table->date('due_date');
            $table->enum('status', ['paid', 'unpaid', 'partial']);
            $table->float('paid_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
