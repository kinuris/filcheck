<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $deparments = [
            "College of Arts and Sciences",
            "College of Business and Accountancy",
            "College of Engineering",
            "College of Computer Studies",
            "College of Education",
            "College of Nursing",
            "College of Medicine",
            "College of Law",
            "College of Architecture",
            "College of Tourism and Hospitality Management",
            "College of Agriculture",
            "College of Criminal Justice",
            "College of Fine Arts and Design",
            "College of Dentistry",
            "College of Pharmacy",
            "College of Public Administration and Governance",
            "College of Social Work",
            "College of Communication and Media Studies",
            "College of Fisheries and Aquatic Sciences",
            "College of Maritime Education",
            "College of Music and Performing Arts",
            "College of Veterinary Medicine"
        ];

        foreach ($deparments as $department) {
            Department::query()->create([
                'name' => $department,
                'code' => preg_replace('/[^A-Z]/', '', $department),
            ]);
        }
    }
}
