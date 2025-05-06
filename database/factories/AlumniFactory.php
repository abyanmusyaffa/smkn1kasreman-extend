<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Alumni;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumni>
 */
class AlumniFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition(): array
    {
        return [
            'nis' => $this->generateUniqueNIS(),
            'nisn' => fake()->unique()->randomNumber(8, true),
            'name' => fake()->name(),
            'gender' => fake()->randomElement(['male', 'female']),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->date(),
            'enrollment_year' => '2022',
            'academic_year' => '2024/2025',
            // 'passing_year' => fake()->year(),
            // 'status' =>fake()->randomElement(['active', 'passing']),
            'status' => 'active',
            'username' => fake()->unique()->regexify('[A-D]{3}[0-3]{2}'),
            'password' => Hash::make('alumni'),
            'group_id' => fake()->numberBetween(1, 8),
        ];
    }

    private function generateUniqueNIS()
    {
        $part1 = fake()->unique()->numberBetween(1000, 9999); // 4 digit
        $part2 = fake()->numberBetween(0, 999);               // 3 digit
        $part3 = fake()->numberBetween(0, 999);               // 3 digit

        $part2 = str_pad($part2, 3, '0', STR_PAD_LEFT);
        $part3 = str_pad($part3, 3, '0', STR_PAD_LEFT);

        return "{$part1}/{$part2}.{$part3}";
    }
}
