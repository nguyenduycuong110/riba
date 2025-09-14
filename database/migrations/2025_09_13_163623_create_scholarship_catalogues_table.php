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
        Schema::create('scholarship_catalogues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('note');
            $table->tinyInteger('publish')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('scholarship_catalogues');
    }
};
