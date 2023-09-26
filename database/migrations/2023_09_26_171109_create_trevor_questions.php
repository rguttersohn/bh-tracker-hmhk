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
        Schema::create('trevor_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('question');
            $table->text('explanation')->nullable();
            $table->text('source_url')->nullable();
            $table->text('source_notes')->nullable();
            $table->text('publication_status');
            $table->foreignId('trevor_category_id')->nullable()->constrained('trevor_categories');
        });

        DB::statement('ALTER TABLE trevor_questions ADD CONSTRAINT check_tq_publication_status CHECK( publication_status = "draft" OR  publication_status = "staging" OR publication_status = "production")');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trevor_questions');
    }
};
