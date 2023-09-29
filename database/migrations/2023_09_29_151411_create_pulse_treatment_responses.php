<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pulse_responses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug', 100);
            $table->text('label');
            $table->foreignId('pulse_question_id')->nullable()->constrained('pulse_questions');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pulse_responses');
    }
};
