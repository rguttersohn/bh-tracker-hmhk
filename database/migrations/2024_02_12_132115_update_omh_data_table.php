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
        Schema::table('omh_datasets',function(Blueprint $table){
            $table->text('rate_description');
            $table->text('capacity_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('omh_datasets', function(Blueprint $table){
            $table->dropColumn('rate_description');
            $table->dropColumn('capacity_description');
        });
    }
};
