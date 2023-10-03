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
        Schema::create('pulse_results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float('data')->nullable();
            $table->foreignId('pulse_week_id')->nullabe()->constrained('pulse_weeks');
            $table->foreignId('pulse_question_id')->nullable()->constrained('pulse_questions');
            $table->foreignId('pulse_response_id')->nullable()->constrained('pulse_responses');
            $table->text('publication_status');

        });

        DB::statement('ALTER TABLE pulse_results ADD CONSTRAINT check_pr_publication_status CHECK( publication_status = "draft" OR  publication_status = "staging" OR publication_status = "production")');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pulse_results');
    }
};

