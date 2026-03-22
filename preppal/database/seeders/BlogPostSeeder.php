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
                'excerpt' => 'A simple weekly system for shopping, cooking, portioning, and storing meals so healthy eating becomes easier, faster, and much more consistent.',
                'content' => "Meal prep does not need to take over your whole Sunday to be effective. The goal is to build a repeatable system that saves time during the week, reduces decision fatigue, and makes it easier to stay on track with your nutrition.\n\nStart by choosing a small structure you can repeat. A great beginner setup is 2 proteins, 2 carbohydrate sources, and 2 to 3 vegetables. For example, you might cook chicken and lean mince, rice and potatoes, then pair them with broccoli, peppers, and green beans. This gives enough variety without making your prep session too complicated.\n\nA simple 60-minute prep flow looks like this:\n1) Write a short shopping list before you go.\n2) Put carbs on first because they usually take longest.\n3) Cook protein in batches using trays, pans, or an air fryer.\n4) Prep vegetables while everything else cooks.\n5) Portion meals into containers before you get too tired to finish.\n\nIt also helps to keep one or two sauces or seasonings separate so meals do not all taste the same. Small changes in seasoning can make repeated meals feel much more enjoyable across the week.\n\nIf you are new to meal prep, do not aim for perfection. Start with just 3 lunches or 3 dinners and build from there. Once the routine feels easier, you can scale it up. The best meal prep system is the one you can actually repeat every week.",
                'cover_image' => 'images/blog/meal-prep-basics.png',
                'is_featured' => true,
                'views' => 420,
            ],
            [
                'title' => 'Cutting without starving: high-protein basics',
                'section' => 'nutrition',
                'category' => 'Cutting',
                'excerpt' => 'Learn how to make a calorie deficit more manageable with higher-protein meals, better food volume, and a structure that reduces cravings and hunger.',
                'content' => "A good cutting phase should feel controlled, not miserable. The biggest mistake people make is dropping calories too hard and ending up hungry, low on energy, and unable to stay consistent for more than a few days.\n\nOne of the best ways to make cutting easier is to prioritise protein in every meal. Protein helps with fullness, supports muscle retention, and makes meals feel more satisfying. Good practical choices include chicken, eggs, Greek yogurt, lean mince, tuna, cottage cheese, and whey protein.\n\nThe next step is adding food volume. Meals that include vegetables, salad, potatoes, fruit, or other filling lower-calorie foods often feel far more satisfying than small portions of calorie-dense foods. This does not mean you can never have foods you enjoy, but your base meals should make hunger easier to manage.\n\nA simple cutting structure looks like this:\n- Build each meal around a protein source.\n- Add vegetables or fruit where possible.\n- Keep snacks planned instead of random.\n- Avoid drinking too many calories without noticing.\n- Keep your calorie deficit moderate and realistic.\n\nIt is also important to remember that consistency beats aggression. A smaller deficit you can maintain usually gives better long-term results than a hard cut that leads to binge eating, burnout, or constant diet breaks.\n\nIf you want your cut to work, focus on meals that are simple, filling, and repeatable. The less exhausted you feel by the process, the more likely you are to stick to it.",
                'cover_image' => 'images/blog/cutting-high-protein.png',
                'views' => 310,
            ],
            [
                'title' => 'Bulking on a budget: student-friendly muscle meals',
                'section' => 'student',
                'category' => 'Bulking',
                'excerpt' => 'A realistic muscle-gain approach built around affordable staple foods, easy meal ideas, and repeatable eating habits that work on a student budget.',
                'content' => "Bulking on a budget is absolutely possible, but it works best when you stop chasing expensive 'fitness foods' and start building meals around affordable staples. Muscle gain comes from eating enough overall, getting sufficient protein, and repeating good habits over time.\n\nThe most budget-friendly foods for a gaining phase are often the least glamorous ones. Rice, pasta, oats, potatoes, eggs, milk, yogurt, peanut butter, frozen veg, beans, chicken thighs, tuna, and mince can go a long way without costing a fortune.\n\nA smart student bulking setup focuses on meals that are cheap, easy, and high enough in calories to help you stay in a surplus. Examples include:\n- Oats with milk, whey, and peanut butter.\n- Rice with chicken and vegetables.\n- Pasta with mince and sauce.\n- Bagels with eggs and cheese.\n- Yogurt bowls with granola, fruit, and nuts.\n\nThe key is not creating ten different meals. It is better to build 2 or 3 repeatable meals you actually like, then rotate sauces, seasonings, or sides to keep them interesting.\n\nLiquid calories can also help if you struggle to eat enough. Smoothies with milk, oats, banana, whey, and peanut butter can be a simple way to increase intake without feeling overly full.\n\nBudget bulking works when your routine is organised. Shop with a list, keep staple foods stocked, cook in bigger batches, and stop relying on random snacks or expensive takeaways. Simple meals done consistently will outperform a complicated plan you cannot afford to follow.",
                'cover_image' => 'images/blog/bulking-card.png',
                'views' => 280,
            ],
            [
                'title' => 'Macros explained: the simplest guide you’ll actually use',
                'section' => 'nutrition',
                'category' => 'Macros',
                'excerpt' => 'A practical explanation of protein, carbohydrates, and fats so you can build better meals without overcomplicating tracking or diet planning.',
                'content' => "Macros are simply the three main nutrients that provide energy in your diet: protein, carbohydrates, and fats. Understanding what each one does can make it much easier to build meals that support your goal.\n\nProtein is usually the first place to start. It supports muscle repair and maintenance, helps with fullness, and is especially important during both fat-loss and muscle-gain phases. Good sources include chicken, fish, eggs, Greek yogurt, cottage cheese, tofu, beans, and protein powders.\n\nCarbohydrates are your main source of quick and usable energy. They help fuel training, support performance, and make meals more satisfying. Rice, pasta, oats, potatoes, bread, fruit, and cereals are all common carb sources.\n\nFats are also essential. They support hormones, general health, and help make meals enjoyable and satisfying. Common fat sources include nuts, peanut butter, oils, avocado, cheese, and egg yolks.\n\nA simple way to think about macros is this:\n- Protein helps you recover and stay full.\n- Carbs help fuel activity and training.\n- Fats support health and meal satisfaction.\n\nYou do not need to obsess over every gram from day one. A useful starting point is to make sure each meal contains a clear protein source, then add carbs and fats in amounts that fit your goal and appetite.\n\nFor many people, macro awareness is less about perfection and more about structure. Once you understand the role of each macro, meal planning becomes simpler and more effective.",
                'cover_image' => 'images/blog/macros-explained.png',
                'views' => 260,
            ],
            [
                'title' => 'High-protein breakfast ideas (fast + repeatable)',
                'section' => 'recipes',
                'category' => 'Recipes',
                'excerpt' => 'Easy breakfast ideas with more protein, better fullness, and less effort — ideal for busy mornings, early lectures, work shifts, or gym days.',
                'content' => "A high-protein breakfast can make a big difference to your day. It can help with fullness, reduce random snacking later on, and make it easier to hit your daily protein target without trying to cram it all into lunch and dinner.\n\nThe best breakfasts are usually the ones that are fast and repeatable. You do not need a huge recipe every morning. You just need a few reliable options that fit your schedule.\n\nGood examples include:\n- Greek yogurt with fruit and granola.\n- An egg wrap with cheese and salsa.\n- Overnight oats mixed with whey protein.\n- Cottage cheese with fruit or honey.\n- Toast with eggs and a side of yogurt.\n\nIf mornings are rushed, prep helps a lot. Overnight oats can be made the night before. Yogurt bowls can be assembled in minutes. Egg wraps can be repeated through the week with different fillings.\n\nIt is also worth matching breakfast to your goal. If you are cutting, focus on protein and fullness. If you are bulking, add more carbs or calorie-dense extras like nut butter, granola, or extra bread.\n\nThe real win is repeatability. When breakfast becomes automatic, your whole day usually feels more organised. Choose 2 or 3 options you enjoy, rotate them, and keep the ingredients stocked so mornings are simple instead of chaotic.",
                'cover_image' => 'images/blog/high-protein-breakfast-ideas.png',
                'views' => 190,
            ],
            [
                'title' => 'Training consistency: the weekly plan that sticks',
                'section' => 'training',
                'category' => 'Training',
                'excerpt' => 'A realistic weekly training structure that helps you stay consistent, recover properly, and make progress without burnout or constant plan changes.',
                'content' => "The best training plan is not always the most advanced one. It is the one you can follow week after week without constantly missing sessions, changing exercises, or burning yourself out.\n\nA simple weekly structure is often all you need. For many people, 3 to 4 well-planned sessions per week is enough to make excellent progress. This gives you enough frequency to improve while still allowing room for recovery, work, study, and life.\n\nA good consistency-focused training week usually includes:\n- Set training days you can realistically stick to.\n- A small number of core lifts or key movements.\n- Some repetition from week to week so progress is measurable.\n- Enough rest between hard sessions.\n\nOne of the biggest mistakes people make is chasing novelty instead of progression. You do not need a brand-new plan every week. Repeating the basics and slowly improving them is what drives long-term results.\n\nTrack something simple: reps, weight, total sets, or even just completed sessions. Small improvements add up quickly when they are repeated for months.\n\nYou should also leave room for imperfect weeks. Missing one session does not mean the plan failed. It just means you get back on track with the next session instead of quitting entirely.\n\nConsistency is powerful because it makes progress predictable. A simple plan followed for six months will nearly always beat an exciting plan followed for two weeks.",
                'cover_image' => 'images/blog/training-consistency-weekly-plan.png',
                'views' => 240,
            ],
            [
                'title' => 'Meal prep storage: keep meals fresh (and safe)',
                'section' => 'meal-prep',
                'category' => 'Meal Prep',
                'excerpt' => 'Learn how to store prepared meals properly so they stay fresher, taste better, and remain practical to eat across the week.',
                'content' => "Good meal prep is not just about cooking. Storage matters just as much. If meals become soggy, dry, or unpleasant by day three, you are much less likely to stick to the routine.\n\nStart with the right containers. Containers that seal properly help keep meals fresh and make stacking in the fridge easier. It also helps to portion meals individually so you can grab them quickly during the week.\n\nA few simple storage habits make a big difference:\n- Let hot food cool slightly before sealing it.\n- Store sauces separately when possible.\n- Keep crunchy ingredients away from wet ingredients.\n- Label containers if you are prepping multiple days.\n- Refrigerate promptly and reheat thoroughly.\n\nMeal choice also affects storage quality. Some foods hold up better than others. Rice, pasta, potatoes, chicken, mince, roasted vegetables, and wraps can all work well, while delicate salads or crispy foods may not keep as nicely unless packed separately.\n\nIf you prep for several days, think about which meals should be eaten first. Meals with more delicate ingredients can be used earlier in the week, while sturdier meals can be saved for later.\n\nStorage is one of the biggest reasons meal prep either works or fails. When your meals still taste good on day three or four, the habit becomes much easier to maintain.",
                'cover_image' => 'images/blog/meal-prep-storage.png',
                'views' => 170,
            ],
            [
                'title' => 'Calories 101: how to estimate and adjust',
                'section' => 'nutrition',
                'category' => 'Calories',
                'excerpt' => 'A simple guide to estimating calorie intake, tracking trends, and making sensible adjustments based on actual progress rather than guesswork.',
                'content' => "Calories are the main driver of weight change, but that does not mean you need to become obsessed with numbers. What matters most is using calories as a practical tool rather than a source of stress.\n\nA good starting point is to estimate your intake target based on your goal. If you want to lose weight, you will usually need a calorie deficit. If you want to gain, you will usually need a surplus. Maintenance sits somewhere in the middle.\n\nThe easiest way to make calories useful is this:\n1) Pick a reasonable starting target.\n2) Follow it consistently for about a week.\n3) Watch your body weight and overall trend.\n4) Adjust slowly if progress is not moving in the direction you want.\n\nOne of the biggest mistakes people make is changing calories too quickly after only one or two days. Daily scale weight can fluctuate for many reasons, including salt, hydration, food volume, and stress. Trends matter more than isolated weigh-ins.\n\nIt also helps to focus on consistency before precision. Hitting roughly similar meals, portions, and habits each day often gives better results than perfectly tracking one day and wildly guessing the next.\n\nCalories do not need to be complicated. Estimate, observe, and adjust gradually. The goal is not mathematical perfection — it is building a system that gives you clear feedback over time.",
                'cover_image' => 'images/blog/calories-101-estimate-adjust.png',
                'views' => 220,
            ],
            [
                'title' => 'Healthy snacks that fit a busy schedule',
                'section' => 'student',
                'category' => 'Student',
                'excerpt' => 'Quick snack ideas that are practical, filling, and easier to fit into a busy day of lectures, work, commuting, gym sessions, or general daily life.',
                'content' => "Snacks can either support your routine or completely derail it. The difference usually comes down to planning. When you have no snack options ready, it becomes much easier to grab whatever is fastest and least satisfying.\n\nA good snack should be convenient, enjoyable, and suited to your goal. If you are trying to stay fuller, protein-rich snacks often work well. If you need more calories, you can combine protein with carbs or fats for something more substantial.\n\nSimple snack ideas include:\n- Protein yogurt\n- Fruit and nuts\n- Tuna pots\n- Protein bars\n- Jerky\n- Cottage cheese pots\n- Boiled eggs and fruit\n\nThe real trick is making snacks visible and easy to grab. Keep them in the same cupboard, fridge shelf, or section of your bag so they become part of your normal routine rather than an afterthought.\n\nFor students and busy schedules, portable snacks matter even more. Foods you can carry to uni, work, or the gym are often the ones that prevent long gaps without food and help you avoid impulse choices later.\n\nTreat snacks like mini meals. Plan them, portion them, and buy them on purpose. When snacks are organised, your overall nutrition becomes much easier to control.",
                'cover_image' => 'images/blog/healthy-snacks-busy-schedule.png',
                'views' => 150,
            ],
            [
                'title' => 'Wellness basics: sleep and stress for better results',
                'section' => 'wellness',
                'category' => 'Wellness',
                'excerpt' => 'Improve recovery, energy, focus, and consistency by paying attention to the two basics that often get ignored most: sleep and stress.',
                'content' => "Most people focus on training and food first, but recovery habits can have a huge effect on results. Poor sleep and constant stress often make everything else feel harder, including appetite control, motivation, gym performance, and mood.\n\nSleep affects how well you recover, how hungry you feel, how focused you are, and how much energy you bring into the day. Even a good nutrition plan feels harder to follow when you are tired all the time.\n\nA few simple sleep habits can help:
- Go to bed at a similar time each night.
- Reduce screens and bright light later in the evening.
- Set a caffeine cut-off earlier in the day.
- Create a short wind-down routine before sleep.\n\nStress matters too. When stress stays high for long periods, routines often become harder to maintain. You may skip training, eat more impulsively, or feel mentally exhausted even when your plan itself is simple.\n\nThis does not mean you need a perfect life to make progress. It just means recovery habits deserve attention. Even small improvements in sleep and stress management can make your training and nutrition feel more sustainable.\n\nBetter recovery supports better choices. When you feel rested and more in control, it becomes much easier to stay consistent with the basics that actually drive progress.",
                'cover_image' => 'images/blog/wellness-sleep-stress.png',
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