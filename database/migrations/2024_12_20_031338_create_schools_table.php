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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');
            $table->string('logo');
            $table->string('motto');
            $table->text('vision');
            $table->text('mission');
            $table->string('url_video_profile');
            $table->longText('description');
            $table->text('welcome_text')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('url_instagram')->nullable();
            $table->string('url_facebook')->nullable();
            $table->string('url_youtube')->nullable();
            $table->string('url_tiktok')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
