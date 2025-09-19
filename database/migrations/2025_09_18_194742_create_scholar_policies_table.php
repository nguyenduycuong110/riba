<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('scholar_policies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('publish', [1,2])->default(1);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('scholar_policies');
    }
};
