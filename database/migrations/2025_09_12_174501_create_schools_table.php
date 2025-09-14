<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('map')->nullable();
            $table->text('link_website')->nullable();
            $table->string('logo')->nullable();
            $table->text('album')->nullable();
            $table->text('video')->nullable();
            $table->longText('description')->nullable();
            $table->text('panorama')->nullable();
            $table->longText('information')->nullable();
            $table->longText('introduction')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
