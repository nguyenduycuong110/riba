<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('image')->nullable();
            $table->unsignedBigInteger('scholarship_catalogue_id');
            $table->foreign('scholarship_catalogue_id')->references('id')->on('scholarship_catalogues')->onDelete('cascade');
            $table->unsignedBigInteger('policy_id');
            $table->foreign('policy_id')->references('id')->on('policies')->onDelete('cascade');
            $table->unsignedBigInteger('train_id');
            $table->foreign('train_id')->references('id')->on('trains')->onDelete('cascade');
            $table->longText('scholarship_policy')->nullable();
            $table->longText('introduce')->nullable();
            $table->longText('content')->nullable();
            $table->tinyInteger('publish')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
