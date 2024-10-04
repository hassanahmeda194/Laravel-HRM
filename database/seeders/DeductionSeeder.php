<?php

namespace Database\Seeders;

use App\Models\Deduction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Deduction::insert([
            ['name' => 'unpaid', 'deduct_amount' => '100'],
            ['name' => 'halfday', 'deduct_amount' => '50']
        ]);
    }
}
