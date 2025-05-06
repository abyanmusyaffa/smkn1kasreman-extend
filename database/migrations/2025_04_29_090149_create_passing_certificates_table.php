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
        Schema::create('passing_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('letterhead');
            $table->string('address');
            $table->string('school');
            $table->string('npsn');
            $table->string('phone');
            $table->string('email');
            $table->string('zip_code');
            $table->string('regency');
            $table->string('number')->nullable();
            $table->date('date')->nullable();
            $table->datetime('release_date');
            $table->string('logo');
            $table->string('stamp');
            $table->string('qrcode');
            $table->string('headmaster');
            $table->string('nip');
            $table->string('signature');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passing_certificates');
    }
};
