<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\BlogPost;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        // Default image so cards/posts never show a broken image
        $defaultCover = 'images/blog/default-card.png';

        $posts = [
            [
                'title' => 'Meal Prep Basics: the 60-minute Sunday system',
                'section' => 'meal-prep',
                'category' => 'Meal Prep',
                'excerpt' => 'A simple weekly routine that makes eating well automatic — shop, prep, portion, repeat.',
                'content' => "If your week gets busy, meal prep is your cheat code.\n\n1) Pick 2 proteins + 2 carbs + 3 veg\n2) Cook in batches\n3) Portion into containers\n4) Keep one sauce for variety\n\nTip: Start small — prep 3 lunches first. Consistency beats perfection.",
                'cover_image' => 'images/blog/meal-prep-basics.png', // ✅ custom
                'is_featured' => true,
                'views' => 420,
            ],
            [
                'title' => 'Cutting without starving: high-protein basics',
                'section' => 'nutrition',
                'category' => 'Cutting',
                'excerpt' => 'How to lose fat without feeling miserable — smarter calories, better meals and routine.',
                'content' => "Cutting works when your meals are filling.\n\n- Prioritise protein each meal\n- Add volume: veg + low-cal sides\n- Keep snacks planned\n- Don’t cut too hard too fast\n\nA steady deficit is easier to maintain and gives better results long term.",
                'cover_image' => 'images/blog/cutting-high-protein.png', // ✅ custom
                'views' => 310,
            ],
            [
                'title' => 'Bulking on a budget: student-friendly muscle meals',
                'section' => 'student',
                'category' => 'Bulking',
                'excerpt' => 'A muscle-building plan that doesn’t destroy your bank account — staples that go far.',
                'content' => "Budget bulking is about smart staples.\n\nGo-to foods:\n- Rice, pasta, oats\n- Eggs, chicken, beans\n- Frozen veg\n- Greek yogurt\n\nPlan 2–3 repeatable meals and rotate sauces/spices for variety.",
                'cover_image' => 'images/blog/bulking-card.png', // ✅ custom
                'views' => 280,
            ],
            [
                'title' => 'Macros explained: the simplest guide you’ll actually use',
                'section' => 'nutrition',
                'category' => 'Macros',
                'excerpt' => 'Protein, carbs and fats — what they do and how to set them for your goal.',
                'content' => "Macros are just the building blocks of calories.\n\nProtein: supports muscle + satiety\nCarbs: fuel training + performance\nFats: hormones + overall health\n\nStart with protein, then build meals around carbs/fats that fit your daily target.",
                'cover_image' => 'images/blog/macros-explained.png', // ✅ custom
                'views' => 260,
            ],
            [
                'title' => 'High-protein breakfast ideas (fast + repeatable)',
                'section' => 'recipes',
                'category' => 'Recipes',
                'excerpt' => 'Breakfast that keeps you full — easy options for early lectures or work shifts.',
                'content' => "Quick options:\n- Greek yogurt + fruit + granola\n- Egg wrap + cheese + salsa\n- Overnight oats + whey\n- Cottage cheese bowl\n\nMake it repeatable. Your future self will thank you.",
                'cover_image' => $defaultCover,
                'views' => 190,
            ],
            [
                'title' => 'Training consistency: the weekly plan that sticks',
                'section' => 'training',
                'category' => 'Training',
                'excerpt' => 'A simple structure that keeps you progressing without burnout.',
                'content' => "Keep it simple:\n\n- 3–4 sessions per week\n- Repeat the basics\n- Track your lifts\n- Add a little each week\n\nSmall improvements compound faster than chaotic routines.",
                'cover_image' => $defaultCover,
                'views' => 240,
            ],
            [
                'title' => 'Meal prep storage: keep meals fresh (and safe)',
                'section' => 'meal-prep',
                'category' => 'Meal Prep',
                'excerpt' => 'Containers, fridge rules and how to avoid soggy meals.',
                'content' => "Storage tips:\n- Cool food before sealing\n- Keep sauces separate\n- Label days\n- Reheat safely\n\nIf it tastes good on day 3, you’ll actually stick to it.",
                'cover_image' => 'images/blog/meal-prep-storage.png', // ✅ custom (NEW)
                'views' => 170,
            ],
            [
                'title' => 'Calories 101: how to estimate and adjust',
                'section' => 'nutrition',
                'category' => 'Calories',
                'excerpt' => 'Stop guessing — estimate, track for a week, then adjust based on results.',
                'content' => "Calories are the main driver of weight change.\n\nStep-by-step:\n1) Set a starting target\n2) Track for 7 days\n3) Adjust slowly based on progress\n\nConsistency matters more than any single day.",
                'cover_image' => $defaultCover,
                'views' => 220,
            ],
            [
                'title' => 'Healthy snacks that fit a busy schedule',
                'section' => 'student',
                'category' => 'Student',
                'excerpt' => 'Grab-and-go snacks that don’t wreck your macros.',
                'content' => "Simple snacks:\n- Protein yogurt\n- Fruit + nuts\n- Tuna pots\n- Protein bars\n- Jerky\n\nPlan snacks like meals — it removes decision fatigue.",
                'cover_image' => $defaultCover,
                'views' => 150,
            ],
            [
                'title' => 'Wellness basics: sleep and stress for better results',
                'section' => 'wellness',
                'category' => 'Wellness',
                'excerpt' => 'If your sleep is bad, everything feels harder. Here’s the simple fix list.',
                'content' => "Sleep affects hunger, training and mood.\n\nTry:\n- Same bedtime\n- Less screens late\n- Caffeine cut-off\n- Evening wind-down\n\nBetter recovery = better results.",
                'cover_image' => $defaultCover,
                'views' => 140,
            ],
        ];

        foreach ($posts as $p) {
            $slug = Str::slug($p['title']);

            BlogPost::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $p['title'],
                    'slug' => $slug,
                    'section' => $p['section'],
                    'category' => $p['category'],
                    'excerpt' => $p['excerpt'],
                    'content' => $p['content'],
                    'cover_image' => $p['cover_image'] ?? $defaultCover,
                    'is_featured' => $p['is_featured'] ?? false,
                    'views' => $p['views'] ?? 0,
                    'published' => true,
                    'published_at' => now()->subDays(rand(1, 20)),
                ]
            );
        }
    }
}