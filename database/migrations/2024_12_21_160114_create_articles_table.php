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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('photo');
            $table->longtext('content');
            $table->enum('category', ['news', 'announcement', 'enrollment']);
            $table->json('tags');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_headline')->default(false);
            $table->boolean('is_published')->default(true);
            $table->string('organization_type')->nullable();
            $table->bigInteger('organization_id')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
