<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Department::factory(15)->create();

        User::query()->create([
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->optional()->lastName(),
            'last_name' => fake()->lastName(),
            'department_id' => Department::all()->random()->id,
            'profile_picture' => fake()->imageUrl(),
            'role' => 'Admin',
            'gender' => 'Male',
            'birthdate' => fake()->date(),
            'phone_number' => fake()->phoneNumber(),
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::query()->create([
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->optional()->lastName(),
            'last_name' => fake()->lastName(),
            'department_id' => Department::all()->random()->id,
            'profile_picture' => fake()->imageUrl(),
            'role' => 'Teacher',
            'gender' => fake()->randomElement(['Male', 'Female']),
            'birthdate' => fake()->date(),
            'phone_number' => fake()->phoneNumber(),
            'username' => 'teacher',
            'password' => bcrypt('password'),
        ]);
    }
}
