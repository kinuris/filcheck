<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\StudentInfo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Department::query()->create([
            'name' => 'College of Computer Studies',
            'code' => 'CCS',
        ]);

        $this->call(DepartmentSeeder::class);

        User::query()->create([
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->optional()->lastName(),
            'last_name' => fake()->lastName(),
            'rfid' => str_pad(fake()->unique()->randomNumber(8), 10, '0'),
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
            'rfid' => str_pad(fake()->unique()->randomNumber(8), 10, '0'),
            'department_id' => Department::all()->random()->id,
            'profile_picture' => fake()->imageUrl(),
            'role' => 'Teacher',
            'gender' => fake()->randomElement(['Male', 'Female']),
            'birthdate' => fake()->date(),
            'phone_number' => fake()->phoneNumber(),
            'username' => 'teacher',
            'password' => bcrypt('password'),
        ]);

        StudentInfo::query()->create([
            'rfid' => str_pad(fake()->unique()->randomNumber(8), 10, '0'),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->optional()->lastName(),
            'last_name' => fake()->lastName(),
            'gender' => 'Male',
            'student_number' => str_pad(fake()->unique()->randomNumber(8), 10, '0'),
            'phone_number' => fake()->phoneNumber(),
            'profile_picture' => fake()->imageUrl(),
            'guardian' => fake()->name(),
            'birthdate' => fake()->date(),
            'department_id' => Department::all()->random()->id,
            'address' => fake()->address(),
            'year' => fake()->numberBetween(1, 4),
            'section' => 'BSCS-4A',
        ]);
    }
}
