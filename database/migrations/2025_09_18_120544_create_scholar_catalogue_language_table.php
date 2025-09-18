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
        Schema::create('scholar_catalogue_language', function (Blueprint $table) {
            $table->unsignedBigInteger('scholar_catalogue_id');
            $table->unsignedBigInteger('language_id');
            $table->foreign('scholar_catalogue_id')->references('id')->on('scholar_catalogues')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('name');
            $table->string('canonical')->unique();
            $table->text('description');
            $table->longText('content');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->text('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholar_catalogue_language');
    }
};
