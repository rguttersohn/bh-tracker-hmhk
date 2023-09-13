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
        Schema::create('risky_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('slug');
            $table->text('question');
            $table->text('explanation')->nullable();
            $table->text('source_url')->nullable();
            $table->text('source_notes')->nullable();
            $table->text('publication_status');
        });

        DB::statement('ALTER TABLE risky_questions ADD CONSTRAINT check_rq_publication_status CHECK( publication_status = "draft" OR  publication_status = "staging" OR publication_status = "production")');


    }

    /**
     * Reverse the migrations.sai
     */
    public function down(): void
    {
        Schema::dropIfExists('risky_questions');
        DB::statement('ALTER TABLE risky_questions DROP CHECK check_rq_publication_status');
    }
};
