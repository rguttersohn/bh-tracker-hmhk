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
        Schema::create('sexual_id_constraints', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('slug');
            $table->text('label');
            $table->text('explanation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sexual_id_constraints');
    }
};