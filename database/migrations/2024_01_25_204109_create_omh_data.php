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
        Schema::create('omh_data', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('year')->index();
            $table->string('publication_status', 20)->index();
            $table->foreignId('dataset_id')->constrained('omh_datasets');
            $table->foreignId('region_id')->constrained('omh_regions');
            $table->foreignId('county_id')->constrained('omh_counties');
            $table->integer('capacity')->nullable();
            $table->float(column:'rate_per_k', places:1)->nullable();
        });
        DB::statement('ALTER TABLE omh_data ADD CONSTRAINT check_omhoc_publication_status CHECK( publication_status = "draft" OR  publication_status = "staging" OR publication_status = "production")');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('omh_data');
    }
};
