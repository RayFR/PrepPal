<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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
            ],
            [
                'name' => 'Pre-workout Jay Cutler',
                'description' => 'A high-energy pre-workout formula designed to support focus, intensity, and training performance before tough sessions.',
                'price' => 29.99,
                'image_path' => 'images/preworkoutjay.png',
                'category' => 'supplement',
                'stock' => 120,
                'low_stock_threshold' => 8,
            ],

            // DRINKS
            [
                'name' => 'Electrolyte Hydration Mix',
                'description' => 'Hydration powder sachets for workouts.',
                'price' => 12.99,
                'image_path' => 'images/preppal_electrolyteSachets.png',
                'category' => 'drink',
                'stock' => 30,
                'low_stock_threshold' => 5,
            ],
            [
                'name' => 'Zero Sugar Electrolyte Drink',
                'description' => 'Zero sugar hydration drink.',
                'price' => 2.99,
                'image_path' => 'images/preppal_zerosugarelectrolyte.png',
                'category' => 'drink',
                'stock' => 40,
                'low_stock_threshold' => 5,
            ],
            [
                'name' => 'Whey Protein Shake',
                'description' => 'Ready to drink protein shake.',
                'price' => 3.49,
                'image_path' => 'images/preppal_wheyprotein.png',
                'category' => 'drink',
                'stock' => 35,
                'low_stock_threshold' => 5,
            ],
            [
                'name' => 'Plant-Based Protein Drink',
                'description' => 'Vegan protein drink.',
                'price' => 3.79,
                'image_path' => 'images/preppal_plantbasedprotein.png',
                'category' => 'drink',
                'stock' => 25,
                'low_stock_threshold' => 5,
            ],
            [
                'name' => 'Pre-Workout Energy Drink',
                'description' => 'Boost energy before workouts.',
                'price' => 2.49,
                'image_path' => 'images/preppal_preworkoutdrink.png',
                'category' => 'drink',
                'stock' => 50,
                'low_stock_threshold' => 5,
            ],
            [
                'name' => 'BCAA Energy Drink',
                'description' => 'Supports endurance and recovery.',
                'price' => 2.99,
                'image_path' => 'images/preppal_BCAAenergydrink.png',
                'category' => 'drink',
                'stock' => 45,
                'low_stock_threshold' => 5,
            ],
            [
                'name' => 'Recovery Shake',
                'description' => 'Post-workout recovery drink.',
                'price' => 3.99,
                'image_path' => 'images/Preppal_recoveryshake.png',
                'category' => 'drink',
                'stock' => 30,
                'low_stock_threshold' => 5,
            ],
            [
                'name' => 'Green Smoothie',
                'description' => 'Healthy detox smoothie.',
                'price' => 2.79,
                'image_path' => 'images/preppal_greensmoothie.png',
                'category' => 'drink',
                'stock' => 20,
                'low_stock_threshold' => 5,
            ],

            // EQUIPMENT
            [
                'name' => 'PrepPal Performance Shaker',
                'description' => 'A durable everyday shaker bottle built for protein shakes, intra-workout drinks, and daily hydration. Includes a premium PrepPal branded design and extra gallery views on the product page.',
                'price' => 9.99,
                'image_path' => 'images/shaker1.png',
                'category' => 'equipment',
                'stock' => 40,
                'low_stock_threshold' => 6,
            ],
            [
                'name' => 'PrepPal Heavy Duty Lifting Belt',
                'description' => 'A sturdy lifting belt designed to support heavy compound movements such as squats and deadlifts. Product page includes alternate belt imagery.',
                'price' => 34.99,
                'image_path' => 'images/belt1.png',
                'category' => 'equipment',
                'stock' => 18,
                'low_stock_threshold' => 4,
            ],
            [
                'name' => 'PrepPal Wrist Wraps',
                'description' => 'Supportive wrist wraps built for pressing movements and upper-body sessions. Includes extra product imagery when viewed on the product page.',
                'price' => 14.99,
                'image_path' => 'images/wraps1.png',
                'category' => 'equipment',
                'stock' => 28,
                'low_stock_threshold' => 5,
            ],
            [
                'name' => 'PrepPal Liquid Chalk',
                'description' => 'Grip-focused liquid chalk designed for deadlifts, rows, pull work, and demanding gym sessions.',
                'price' => 9.99,
                'image_path' => 'images/chalk.png',
                'category' => 'equipment',
                'stock' => 26,
                'low_stock_threshold' => 5,
            ],
            [
                'name' => 'PrepPal Wrist Straps',
                'description' => 'Heavy-duty lifting straps made to help reduce grip fatigue during pulling movements. Includes alternate gallery imagery on the product page.',
                'price' => 12.99,
                'image_path' => 'images/straps1.png',
                'category' => 'equipment',
                'stock' => 24,
                'low_stock_threshold' => 5,
            ],

        ]);
    }
}