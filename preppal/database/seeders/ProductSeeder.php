<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([

            // MEAL PLANS
            [
                'name' => 'Fat Loss Meal Prep Plan',
                'description' => 'A structured 8-week fat-loss programme designed for sustainable weight reduction.',
                'price' => 49.99,
                'image_path' => 'images/fat_loss_plan.png',
                'category' => 'meal',
                'stock' => 25,
                'low_stock_threshold' => 5,
            ],
            [
                'name' => 'Lean Muscle Meal Prep Plan',
                'description' => 'A performance-focused meal plan built to maximise muscle growth.',
                'price' => 59.99,
                'image_path' => 'images/lean_muscle_plan.jpg',
                'category' => 'meal',
                'stock' => 20,
                'low_stock_threshold' => 5,
            ],
            [
                'name' => 'Maintenance Meal Prep Plan',
                'description' => 'A balanced programme tailored for individuals who want to maintain weight.',
                'price' => 54.99,
                'image_path' => 'images/maintainance_plan.jpg',
                'category' => 'meal',
                'stock' => 18,
                'low_stock_threshold' => 5,
            ],
            [
                'name' => 'High Fibre Meal Prep Plan',
                'description' => 'A plant-forward nutrition plan centered around gut-healthy ingredients.',
                'price' => 52.99,
                'image_path' => 'images/high_fibre_plan.jpg',
                'category' => 'meal',
                'stock' => 15,
                'low_stock_threshold' => 5,
            ],

            // SUPPLEMENTS
            [
                'name' => 'Whey Protein 1kg',
                'description' => 'A smooth whey protein powder formulated to support lean muscle growth.',
                'price' => 24.99,
                'image_path' => 'images/whey_protein.png',
                'category' => 'supplement',
                'stock' => 50,
                'low_stock_threshold' => 10,
            ],
            [
                'name' => 'Creatine Monohydrate 300g',
                'description' => 'A premium-grade creatine monohydrate supplement.',
                'price' => 14.99,
                'image_path' => 'images/creatine_monohydrate.jpg',
                'category' => 'supplement',
                'stock' => 40,
                'low_stock_threshold' => 10,
            ],
            [
                'name' => 'BCAA Powder 250g',
                'description' => 'A fast-absorbing blend of essential branched-chain amino acids.',
                'price' => 19.99,
                'image_path' => 'images/bcaa_powder.jpg',
                'category' => 'supplement',
                'stock' => 30,
                'low_stock_threshold' => 8,
            ],
            [
                'name' => 'Daily Multivitamin 60 tablets',
                'description' => 'A comprehensive daily multivitamin.',
                'price' => 11.99,
                'image_path' => 'images/multivitimins.jpg',
                'category' => 'supplement',
                'stock' => 35,
                'low_stock_threshold' => 8,
            ]

        ]);
    }
}