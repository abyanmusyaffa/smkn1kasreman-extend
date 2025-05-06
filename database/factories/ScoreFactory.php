<?php

namespace Database\Factories;

use App\Models\Alumni;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Score>
 */
class ScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil satu alumni acak beserta relasi group dan major
        $alumni = Alumni::with('groups.majors')->inRandomOrder()->first();

        // Ambil major dari group alumni
        $majorId = optional($alumni->groups->majors)->id;

        // Ambil subject yang cocok dengan major alumni (atau umum)
        $subject = Subject::where(function ($q) use ($majorId) {
            $q->whereNull('major_id')
              ->orWhere('major_id', $majorId);
        })->inRandomOrder()->first();

        return [
            'alumni_id' => $alumni->id,
            'subject_id' => $subject->id,
            'score'      => $this->faker->randomFloat(2, 70, 98),
        ];
    }
}
