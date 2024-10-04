<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Candidate::create([
            "name" => "John Doe",
            "email" => "john.doe@example.com",
            "phone" => "123-456-7890",
            "status" => 1,
            "address" => "123 Main St, Cityville",
            "resume_path" => "resume.pdf",
        ]);
    }
}
