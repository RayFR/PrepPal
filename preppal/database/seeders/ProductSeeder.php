<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run()
{
    DB::table('products')->insert([

        [
            'name' => 'Fat Loss Meal Prep Plan',
            'description' => '8-week structured fat loss programme...',
            'price' => 49.99,
            'image_path' => 'images/fat_loss_plan.png',
            'category' => 'meal',
        ],
        [
            'name' => 'Lean Muscle Meal Prep Plan',
            'description' => 'Performance-focused meal programme...',
            'price' => 59.99,
            'image_path' => 'images/lean_muscle_plan.jpg',
            'category' => 'meal',
        ],
        [
            'name' => 'Maintenance Meal Prep Plan',
            'description' => 'Balanced 8-week meal programme...',
            'price' => 54.99,
            'image_path' => 'images/maintainance_plan.jpg',
            'category' => 'meal',
        ],
        [
            'name' => 'High Fibre Meal Prep Plan',
            'description' => 'Plant-forward meals for gut health...',
            'price' => 52.99,
            'image_path' => 'images/high_fibre_plan.jpg',
            'category' => 'meal',
        ],

        // Supplements
        [
            'name' => 'Whey Protein 1kg',
            'description' => 'Smooth and easy-mix whey protein...',
            'price' => 24.99,
            'image_path' => 'images/protein-shake.png',
            'category' => 'supplement',
        ],
        [
            'name' => 'Creatine Monohydrate 300g',
            'description' => 'Clinically supported creatine supplement...',
            'price' => 14.99,
            'image_path' => 'images/creatine_monohydrate.jpg',
            'category' => 'supplement',
        ],
        [
            'name' => 'BCAA Powder 250g',
            'description' => 'Branched-chain amino acids...',
            'price' => 19.99,
            'image_path' => 'images/protein-shake.png',
            'category' => 'supplement',
        ],
        [
            'name' => 'Daily Multivitamin 60 tablets',
            'description' => 'All-round micronutrient support...',
            'price' => 11.99,
            'image_path' => 'images/vegan-bowl.png',
            'category' => 'supplement',
        ]

    ]);
}

}
