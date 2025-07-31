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
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('expertise_program');
            $table->string('expertise_concentration');
            $table->string('alias');
            $table->json('contacts');
            $table->longText('description');
            $table->integer('study_group');
            $table->integer('study_period');
            $table->integer('total_students');
            $table->string('logo');
            $table->json('galleries');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
