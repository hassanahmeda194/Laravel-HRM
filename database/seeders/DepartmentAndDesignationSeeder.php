<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentAndDesignationSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $department = Department::insert([
            ['name' => 'Administration', 'is_active' => 1],
            ['name' => 'HR', 'is_active' => 1],
            ['name' => 'IT', 'is_active' => 1],
            ['name' => 'Finance', 'is_active' => 1],
            ['name' => 'Brands', 'is_active' => 1],
            ['name' => 'Business Unit 01 (Book)', 'is_active' => 1],
            ['name' => 'Business Unit 02 (Article)', 'is_active' => 1],
            ['name' => 'Business Unit 03 (E commerce)', 'is_active' => 1],
        ]);
        $designation = Designation::insert([
            ['name' => 'Admin', 'department_id' => 1,  'is_active' => 1],
            ['name' => 'HR', 'department_id' => 2,  'is_active' => 1],
            ['name' => 'IT', 'department_id' => 3,  'is_active' => 1],
            ['name' => 'Sales Manager', 'department_id' => 6,  'is_active' => 1],
            ['name' => 'Sales Executive', 'department_id' => 6,  'is_active' => 1],
            ['name' => 'Designer', 'department_id' => 5,  'is_active' => 1],
            ['name' => 'Developer', 'department_id' => 5,  'is_active' => 1],
            ['name' => 'Writer', 'department_id' => 5,  'is_active' => 1],
            ['name' => 'Seo', 'department_id' => 5,  'is_active' => 1],
            ['name' => 'Publication', 'department_id' => 7,  'is_active' => 1],
        ]);
    }
}
