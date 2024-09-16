<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentInfo>
 */
class StudentInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rfid' => strtoupper(fake()->lexify('???????????')),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->optional()->lastName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->phoneNumber(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'department_id' => Department::all()->random()->id,
            'birthdate' => fake()->date(),
            'profile_picture' => fake()->imageUrl(),
            'student_number' => strtoupper(fake()->bothify('???-####')),
            'guardian' => fake()->name(),
            'address' => fake()->address(),
        ];
    }
}
