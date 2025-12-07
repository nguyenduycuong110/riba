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
        Schema::table('majors', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['major_catalogue_id']);
            // Make column nullable since we use many-to-many relationship via pivot table
            $table->unsignedBigInteger('major_catalogue_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            // Revert column to not nullable
            $table->unsignedBigInteger('major_catalogue_id')->nullable(false)->change();
            // Add foreign key back
            $table->foreign('major_catalogue_id')->references('id')->on('major_catalogues')->onDelete('cascade');
        });
    }
};
