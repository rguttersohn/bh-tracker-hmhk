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
        Schema::create('pulse_treatment_results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('week');
            $table->text('date_range');
            $table->foreignId('pulse_question_id')->nullable()->constrained('pulse_treatment_questions');
            $table->foreignId('pulse_response_id')->nullable()->constrained('pulse_treatment_responses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pulse_treatment_results');
    }
};

