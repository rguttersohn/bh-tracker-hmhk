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
        Schema::create('risky_responses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('year');
            $table->float('data');
            $table->foreignId('risky_question_id')->constrained();
            $table->foreignId('gender_constraint_id')->nullable()->constrained();
            $table->foreignId('sexual_id_constraint_id')->nullable()->constrained();
            $table->foreignId('race_constraint_id')->nullable()->constrained();
            $table->foreignID('grade_constraint_id')->nullable()->constrainted();
            $table->text('publication_status');
           
        });

        DB::statement('ALTER TABLE risky_responses ADD CONSTRAINT check_rr_publication_status CHECK( publication_status = "draft" OR  publication_status = "staging" OR publication_status = "production")');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risky_responses');
        DB::statement('ALTER TABLE risky_responses DROP CHECK check_rr_publication_status');

    }
};
