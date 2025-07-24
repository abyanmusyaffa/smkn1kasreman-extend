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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained()->cascadeOnDelete();
            $table->string('position')->nullable();
            $table->string('company')->nullable();
            $table->enum('type', ['text', 'url']);
            $table->string('url')->nullable();
            $table->text('content')->nullable();
            $table->integer('rating');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }
    // public function up(): void
    // {
    //     Schema::create('testimonials', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('alumni_id')->constrained()->cascadeOnDelete();
    //         $table->text('content');
    //         $table->integer('rating');
    //         $table->boolean('show')->default(false);
    //         $table->timestamps();
    //     });
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
