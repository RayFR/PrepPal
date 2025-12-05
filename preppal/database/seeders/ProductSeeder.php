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
                'description' => 'A structured 8-week fat-loss programme designed for sustainable weight reduction. Includes calorie-controlled meals with high-protein ingredients, fresh vegetables, whole grains, and targeted macronutrients to support fat burning while maintaining muscle mass. Perfect for individuals looking to reduce body fat without extreme dieting.',
                'price' => 49.99,
                'image_path' => 'images/fat_loss_plan.png',
                'category' => 'meal',
            ],
            [
                'name' => 'Lean Muscle Meal Prep Plan',
                'description' => 'A performance-focused meal plan built to maximise muscle growth, support training recovery, and maintain consistent energy levels. Features high-protein meals, complex carbohydrates, and nutrient-dense ingredients ideal for athletes, gym-goers, and anyone wanting to build lean muscle safely and efficiently.',
                'price' => 59.99,
                'image_path' => 'images/lean_muscle_plan.jpg',
                'category' => 'meal',
            ],
            [
                'name' => 'Maintenance Meal Prep Plan',
                'description' => 'A balanced 8-week programme tailored for individuals who want to maintain weight, stabilise energy levels, and enjoy nutritious meals daily. Includes measured portions, balanced macros, and a rotation of flavour-rich dishes designed to help you stay healthy without restricting yourself.',
                'price' => 54.99,
                'image_path' => 'images/maintainance_plan.jpg',
                'category' => 'meal',
            ],
            [
                'name' => 'High Fibre Meal Prep Plan',
                'description' => 'A plant-forward nutrition plan centered around gut-healthy ingredients, whole foods, and naturally fiber-rich recipes. Ideal for improving digestion, reducing bloating, and supporting long-term metabolic health. Provides a diverse range of colourful meals packed with vitamins and minerals.',
                'price' => 52.99,
                'image_path' => 'images/high_fibre_plan.jpg',
                'category' => 'meal',
            ],

            // SUPPLEMENTS
            [
                'name' => 'Whey Protein 1kg',
                'description' => 'A smooth, easy-mix whey protein powder formulated to support lean muscle growth and post-workout recovery. Provides a complete amino acid profile and is ideal for shakes, smoothies, or adding extra protein to recipes. Perfect for athletes and everyday fitness enthusiasts.',
                'price' => 24.99,
                'image_path' => 'images/whey_protein.png',
                'category' => 'supplement',
            ],
            [
                'name' => 'Creatine Monohydrate 300g',
                'description' => 'A premium-grade creatine monohydrate supplement backed by decades of scientific research. Helps increase strength, improve training performance, and boost muscular endurance. Suitable for both beginners and advanced lifters seeking improved workout output.',
                'price' => 14.99,
                'image_path' => 'images/creatine_monohydrate.jpg',
                'category' => 'supplement',
            ],
            [
                'name' => 'BCAA Powder 250g',
                'description' => 'A fast-absorbing blend of essential branched-chain amino acids (L-Leucine, L-Isoleucine, L-Valine) that support muscle repair, reduce fatigue, and improve endurance during training. Great for sipping before or during workouts to maintain peak performance.',
                'price' => 19.99,
                'image_path' => 'images/bcaa_powder.jpg',
                'category' => 'supplement',
            ],
            [
                'name' => 'Daily Multivitamin 60 tablets',
                'description' => 'A comprehensive daily multivitamin containing essential vitamins, minerals, and antioxidants designed to support overall health, immunity, and long-term wellbeing. Ideal for filling nutritional gaps and boosting energy levels throughout the day.',
                'price' => 11.99,
                'image_path' => 'images/multivitimins.jpg',
                'category' => 'supplement',
            ]

        ]);
    }
}
