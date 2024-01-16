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
        Schema::create('omh_outpatient_capacities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('year');
            $table->foreignId('region_id')->constrained('omh_regions');
            $table->foreignId('county_id')->constrained('omh_counties');
            $table->integer('capacity');
            $table->float(column:'rate_per_k', places:1);
            $table->text('publication_status');
        });
        DB::statement('ALTER TABLE omh_outpatient_capacities ADD CONSTRAINT check_omhoc_publication_status CHECK( publication_status = "draft" OR  publication_status = "staging" OR publication_status = "production")');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('omh_outpatient_capacities');
    }
};
