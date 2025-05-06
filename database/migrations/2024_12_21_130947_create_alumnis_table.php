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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->string('nisn');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('address')->nullable();
            $table->string('address_village')->nullable();
            $table->string('address_subdistrict')->nullable();
            $table->string('address_regency')->nullable();
            $table->string('address_province')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->string('academic_year');
            $table->string('enrollment_year');
            $table->string('passing_year')->nullable();
            $table->enum('status', ['active', 'passing', 'transferred', 'dropped']);
            $table->string('username');
            $table->string('password');
            $table->foreignId('group_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }
    // public function up(): void
    // {
    //     Schema::create('alumnis', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->string('username');
    //         $table->string('password');
    //         $table->string('photo')->nullable()->default('default/alumni.svg');
    //         $table->string('class');
    //         $table->foreignId('major_id')->constrained()->cascadeOnDelete();
    //         $table->string('position')->nullable();
    //         $table->string('company')->nullable();
    //         $table->timestamps();
    //     });
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
