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
        Schema::create('trevor_responses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('year')->index();
            $table->float('data')->nullable()->index();
            $table->foreignId('trevor_question_id')->constrained('trevor_questions');
            $table->text('publication_status');
            
        });

        DB::statement('ALTER TABLE trevor_responses ADD CONSTRAINT check_tr_publication_status CHECK( publication_status = "draft" OR  publication_status = "staging" OR publication_status = "production")');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trevor_responses');
    }
};
