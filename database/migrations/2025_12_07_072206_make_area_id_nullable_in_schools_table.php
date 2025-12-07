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
        Schema::table('schools', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['area_id']);
            // Modify column to nullable
            $table->unsignedBigInteger('area_id')->nullable()->change();
            // Add foreign key back with nullable support
            $table->foreign('area_id')->references('id')->on('school_areas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['area_id']);
            // Revert column to not nullable
            $table->unsignedBigInteger('area_id')->nullable(false)->change();
            // Add foreign key back with cascade
            $table->foreign('area_id')->references('id')->on('school_areas')->onDelete('cascade');
        });
    }
};
