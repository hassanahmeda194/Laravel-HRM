<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Salaries and Wages',
            'Office Supplies',
            'Utilities',
            'Rent and Lease',
            'Travel and Transportation',
            'Maintenance and Repairs',
            'Insurance',
            'Professional Services',
            'Training and Development',
            'Marketing and Advertising',
        ];

        foreach ($categories as $category) {
            ExpenseCategory::create(['name' => $category]);
        }
        $assets = [
            [
                'name' => 'Office Desk',
                'description' => 'Wooden office desk',
                'value' => 250.00,
                'purchase_date' => '2023-01-15',
            ],
            [
                'name' => 'Office Chair',
                'description' => 'Ergonomic office chair',
                'value' => 150.00,
                'purchase_date' => '2023-02-10',
            ],
            [
                'name' => 'Laptop',
                'description' => 'Dell Inspiron laptop',
                'value' => 1200.00,
                'purchase_date' => '2023-03-05',
            ],
            [
                'name' => 'Printer',
                'description' => 'HP LaserJet Pro',
                'value' => 300.00,
                'purchase_date' => '2023-04-20',
            ],
            [
                'name' => 'Conference Table',
                'description' => 'Large conference table',
                'value' => 800.00,
                'purchase_date' => '2023-05-15',
            ],
            [
                'name' => 'Whiteboard',
                'description' => 'Magnetic whiteboard',
                'value' => 100.00,
                'purchase_date' => '2023-06-01',
            ],
            [
                'name' => 'Projector',
                'description' => 'Epson projector',
                'value' => 600.00,
                'purchase_date' => '2023-07-10',
            ],
            [
                'name' => 'Air Conditioner',
                'description' => 'Split AC unit',
                'value' => 500.00,
                'purchase_date' => '2023-08-20',
            ],
            [
                'name' => 'Television',
                'description' => 'Samsung 40 inch TV',
                'value' => 400.00,
                'purchase_date' => '2023-09-15',
            ],
            [
                'name' => 'Safe',
                'description' => 'Steel safe for important documents',
                'value' => 200.00,
                'purchase_date' => '2023-10-01',
            ],
        ];

        DB::table('assets')->insert($assets);
    }
}
