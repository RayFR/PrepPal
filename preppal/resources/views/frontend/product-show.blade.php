@extends('layouts.app')

@section('title', $product->name)

@section('content')
@php
  $reviewCount = $product->reviews->count();
  $avg = $reviewCount ? (float) ($averageRating ?? 0) : 0;
  $roundedStars = $reviewCount ? (int) round($avg) : 0;

  $mainImgPath = $product->image_path ?: 'images/whey_protein.png';

  $productSlug = strtolower(trim($product->name));
  $productCategory = strtolower(trim($product->category ?? ''));

  $isWheyProtein = $productSlug === 'whey protein 1kg';
  $isCreatine = $productSlug === 'creatine monohydrate 300g';
  $isPreWorkout = $productSlug === 'pre-workout jay cutler';
  $isBcaa = $productSlug === 'bcaa powder 250g';
  $isMultivitamin = $productSlug === 'daily multivitamin 60 tablets';

  $isMeal = $productCategory === 'meal';

  // Detect clothing products.
  $isTank = str_contains($productSlug, 'tank');
  $isShorts = str_contains($productSlug, 'shorts');
  $isZip = str_contains($productSlug, 'zip');
  $isPants = str_contains($productSlug, 'jogger') || str_contains($productSlug, 'pants');
  $isGymGirlSet = str_contains($productSlug, 'gym girl set');
  $isClothing = $productCategory === 'clothing' || $isTank || $isShorts || $isZip || $isPants || $isGymGirlSet;

  // Detect equipment products.
  $isEquipment = $productCategory === 'equipment';
  $isShaker = $productSlug === 'preppal performance shaker';
  $isBelt = $productSlug === 'preppal heavy duty lifting belt';
  $isWraps = $productSlug === 'preppal wrist wraps';
  $isChalk = $productSlug === 'preppal liquid chalk';
  $isStraps = $productSlug === 'preppal wrist straps';

  $mealPlans = [
    'fat loss meal prep plan' => [
      'goal' => 'Fat loss',
      'overview' => 'A calorie-conscious weekly meal plan built around lean proteins, smart carbs, and portion control.',
      'highlights' => [
        '14 prepared meals per week',
        'High-protein, lower-calorie meal structure',
        'Designed to support cutting and consistent intake',
      ],
      'included' => [
        '7 lunch meals',
        '7 dinner meals',
        'Portion-controlled servings',
        'Simple reheating instructions',
      ],
      'protein_options' => [
        'chicken' => 'Chicken',
        'turkey' => 'Turkey',
        'salmon' => 'Salmon',
        'tofu' => 'Tofu',
      ],
      'carb_options' => [
        'rice' => 'Rice',
        'sweet_potato' => 'Sweet Potato',
        'potatoes' => 'Potatoes',
        'mixed_veg' => 'Extra Veg',
      ],
      'snack_options' => [
        'none' => 'No snack add-on',
        'protein_yogurt' => 'Protein Yogurt',
        'fruit_pot' => 'Fruit Pot',
        'protein_bar' => 'Protein Bar',
      ],
      'delivery_options' => [
        '14_meals' => '14 meals / week',
        '10_meals' => '10 meals / week',
      ],
      'example_meals' => [
        'Grilled chicken, rice and greens',
        'Turkey mince with seasoned potatoes',
        'Salmon with vegetables and light sauce',
        'Tofu bowl with roasted veg',
      ],
    ],

    'lean muscle meal prep plan' => [
      'goal' => 'Muscle gain',
      'overview' => 'A higher-calorie, performance-focused weekly meal plan with quality protein and training-friendly carbs.',
      'highlights' => [
        '14 prepared meals per week',
        'Higher-calorie portions for performance',
        'Built to support muscle growth and recovery',
      ],
      'included' => [
        '7 lunch meals',
        '7 dinner meals',
        'Larger carb portions',
        'Balanced protein in every meal',
      ],
      'protein_options' => [
        'chicken' => 'Chicken',
        'beef' => 'Lean Beef',
        'salmon' => 'Salmon',
        'tofu' => 'Tofu',
      ],
      'carb_options' => [
        'rice' => 'Rice',
        'pasta' => 'Pasta',
        'potatoes' => 'Potatoes',
        'sweet_potato' => 'Sweet Potato',
      ],
      'snack_options' => [
        'none' => 'No snack add-on',
        'overnight_oats' => 'Overnight Oats',
        'protein_yogurt' => 'Protein Yogurt',
        'protein_bar' => 'Protein Bar',
      ],
      'delivery_options' => [
        '14_meals' => '14 meals / week',
        '18_meals' => '18 meals / week',
      ],
      'example_meals' => [
        'Chicken, rice and peri veg',
        'Lean beef pasta bowl',
        'Salmon with potatoes and greens',
        'Tofu rice bowl with mixed vegetables',
      ],
    ],

    'maintenance meal prep plan' => [
      'goal' => 'Maintenance',
      'overview' => 'A balanced weekly plan for people who want convenience, consistency, and easy weight maintenance.',
      'highlights' => [
        '14 prepared meals per week',
        'Balanced calories and protein',
        'Ideal for routine, convenience, and steady intake',
      ],
      'included' => [
        '7 lunch meals',
        '7 dinner meals',
        'Balanced macro split',
        'Straightforward weekly structure',
      ],
      'protein_options' => [
        'chicken' => 'Chicken',
        'beef' => 'Lean Beef',
        'salmon' => 'Salmon',
        'tofu' => 'Tofu',
      ],
      'carb_options' => [
        'rice' => 'Rice',
        'potatoes' => 'Potatoes',
        'pasta' => 'Pasta',
        'mixed_veg' => 'Extra Veg',
      ],
      'snack_options' => [
        'none' => 'No snack add-on',
        'fruit_pot' => 'Fruit Pot',
        'protein_yogurt' => 'Protein Yogurt',
        'nuts' => 'Mixed Nuts',
      ],
      'delivery_options' => [
        '14_meals' => '14 meals / week',
        '10_meals' => '10 meals / week',
      ],
      'example_meals' => [
        'Chicken with herbed rice',
        'Beef with roasted potatoes',
        'Salmon pasta bowl',
        'Tofu and vegetable tray meal',
      ],
    ],

    'high fibre meal prep plan' => [
      'goal' => 'Digestive support',
      'overview' => 'A fibre-focused weekly meal plan built around gut-friendly ingredients, beans, grains, vegetables, and lighter proteins.',
      'highlights' => [
        '14 prepared meals per week',
        'Fibre-conscious ingredient choices',
        'Balanced meals built around digestion-friendly foods',
      ],
      'included' => [
        '7 lunch meals',
        '7 dinner meals',
        'Higher-fibre sides and vegetables',
        'Plant-forward meal choices',
      ],
      'protein_options' => [
        'chicken' => 'Chicken',
        'tofu' => 'Tofu',
        'beans' => 'Beans',
        'lentils' => 'Lentils',
      ],
      'carb_options' => [
        'brown_rice' => 'Brown Rice',
        'wholewheat_pasta' => 'Wholewheat Pasta',
        'sweet_potato' => 'Sweet Potato',
        'quinoa' => 'Quinoa',
      ],
      'snack_options' => [
        'none' => 'No snack add-on',
        'fruit_pot' => 'Fruit Pot',
        'yogurt' => 'Yogurt Pot',
        'nuts' => 'Mixed Nuts',
      ],
      'delivery_options' => [
        '14_meals' => '14 meals / week',
        '10_meals' => '10 meals / week',
      ],
      'example_meals' => [
        'Chicken with brown rice and greens',
        'Lentil quinoa bowl',
        'Tofu wholewheat pasta meal',
        'Bean and veg tray-bake meal',
      ],
    ],
  ];

  $mealPlan = $mealPlans[$productSlug] ?? null;

  $defaultMealProteinKey = $mealPlan ? array_key_first($mealPlan['protein_options']) : null;
  $defaultMealCarbKey = $mealPlan ? array_key_first($mealPlan['carb_options']) : null;
  $defaultMealSnackKey = $mealPlan ? array_key_first($mealPlan['snack_options']) : null;
  $defaultMealDeliveryKey = $mealPlan ? array_key_first($mealPlan['delivery_options']) : null;

  $productContent = [
    'fat loss meal prep plan' => [
      'description' => 'The Fat Loss Meal Prep Plan is designed for customers who want a simple, structured way to reduce calories without sacrificing satisfaction, routine, or protein intake. Each weekly plan is built around balanced, portion-controlled meals that help support a calorie deficit while still giving you enough fuel for work, study, training, and day-to-day life. Meals are centred on lean proteins, smart carbohydrate sources, and vegetables, making the plan practical for people who want convenience as well as consistency. Customers can also customise their weekly setup by choosing preferred proteins, carb bases, and add-ons, so the plan feels realistic to stick to rather than overly restrictive. It is ideal for people starting a cut, returning to a routine, or wanting ready-made meals that remove the stress of planning, cooking, and tracking every day.',
      'how_to_use' => 'Choose the Fat Loss plan size that best suits your week, customise your protein and carb choices, and add the plan to your cart. Once delivered, store chilled meals as instructed and heat each meal thoroughly before eating. Most customers use the plan for lunch and dinner across the week, while keeping breakfast and snacks flexible around their own calorie target. For best results, combine the plan with regular hydration, consistent activity, and a realistic daily routine. If your goal or schedule changes, you can update your selection before your next weekly order.',
      'faqs' => [
        ['q' => 'Who is this plan best for?', 'a' => 'This plan is best for customers aiming to reduce body weight or body fat while keeping meals convenient, high in protein, and portion controlled.'],
        ['q' => 'Do I get the same meals every day?', 'a' => 'No. The plan is built to give variety across the week, and the meal customiser lets you choose the protein and carb style that suits your preferences.'],
        ['q' => 'Can I still use this if I train regularly?', 'a' => 'Yes. Many customers use it during gym phases or cardio blocks because it supports a structured intake while still providing balanced meals.'],
      ],
    ],

    'lean muscle meal prep plan' => [
      'description' => 'The Lean Muscle Meal Prep Plan is built for customers who want convenient, performance-focused meals that support training, recovery, and steady muscle gain. The meals are designed around quality protein sources, substantial carbohydrate portions, and balanced sides so that customers can fuel sessions properly without relying on random takeaways or inconsistent meal prep at home. This plan is especially useful for people in a gaining phase, those training multiple times per week, or anyone who struggles to eat enough quality meals consistently. Rather than being a generic bulking plan, it aims to provide cleaner, better-balanced meals that support growth while still being practical for a busy schedule. Customers can choose meal styles and combinations that fit their taste and routine, making it easier to stay consistent over time.',
      'how_to_use' => 'Select the Lean Muscle plan size, choose your preferred protein and carbohydrate options, and place your order for the week. Once your meals arrive, refrigerate them according to the packaging guidance and heat each meal thoroughly before serving. Most customers use the plan around their busiest days, after training sessions, or as their main lunch and dinner meals throughout the week. For best results, pair the plan with regular strength training, sufficient water intake, and an overall calorie target that matches your goal. You can update your meal choices before your next order cycle if you want more variety.',
      'faqs' => [
        ['q' => 'Is this only for bodybuilders?', 'a' => 'No. It is suitable for anyone looking to increase food quality and protein intake while supporting training, sport, or a generally active lifestyle.'],
        ['q' => 'Are portions larger than the fat loss plan?', 'a' => 'Yes. This plan is designed to be more performance focused, so portions and meal structure are more supportive of muscle gain and recovery.'],
        ['q' => 'Can I customise the meals each week?', 'a' => 'Yes. You can choose from the available protein, carb, and add-on options to build a plan that suits your preferences.'],
      ],
    ],

    'maintenance meal prep plan' => [
      'description' => 'The Maintenance Meal Prep Plan is a balanced option for customers who want a reliable weekly meal routine without specifically cutting or aggressively bulking. It is designed to help maintain body weight while keeping food quality, convenience, and consistency high. Meals are structured to provide a steady mix of protein, carbohydrates, and vegetables, making them suitable for busy students, professionals, gym-goers, and anyone who wants prepared meals that fit easily into normal daily life. This plan works well for people who have already reached a comfortable body composition, are taking a break from intensive dieting phases, or simply want nutritious meals without the hassle of cooking every day. Customers can still customise key elements of the plan, so they have flexibility while keeping the overall structure straightforward and sustainable.',
      'how_to_use' => 'Choose your preferred weekly plan size, customise the protein and carb options you want included, and add the plan to your basket. After delivery, keep meals refrigerated and follow the on-pack heating instructions before eating. Many customers use the Maintenance plan as a dependable lunch and dinner solution during the working week, helping them stay consistent without needing to overthink food choices. It can also be used as a bridge between cutting and gaining phases, or simply as a convenient long-term routine. You can make changes to your selections before your next billing cycle if your schedule or preferences change.',
      'faqs' => [
        ['q' => 'Who should choose the maintenance plan?', 'a' => 'It is ideal for customers who want balanced prepared meals for routine, convenience, and weight maintenance rather than a specialist cutting or gaining approach.'],
        ['q' => 'Is this plan good for everyday use?', 'a' => 'Yes. It is specifically designed to be practical for regular weekly use, with balanced meals that fit easily into day-to-day life.'],
        ['q' => 'Can I switch to another plan later?', 'a' => 'Yes. If your goal changes, you can move to a different meal plan before your next order cycle.'],
      ],
    ],

    'high fibre meal prep plan' => [
      'description' => 'The High Fibre Meal Prep Plan is designed for customers who want more fibre-rich, balanced meals as part of a healthier everyday routine. It focuses on ingredients such as vegetables, pulses, grains, and other gut-friendly foods, while still keeping meals practical, satisfying, and protein-conscious. This plan is a good fit for customers who want to improve meal quality, increase fibre intake, and enjoy more plant-forward options without spending time preparing everything from scratch. It is not intended as a medical treatment, but it can be a helpful choice for people trying to build a more balanced and digestion-conscious diet. Customers can still personalise their weekly setup by choosing from the available meal components, making the plan more enjoyable and easier to stick to.',
      'how_to_use' => 'Choose the High Fibre plan size that fits your week, select your preferred options, and add the plan to your cart. After delivery, store meals chilled and heat them thoroughly before eating. Spread the meals across the week as part of a balanced diet and make sure you increase fibre intake alongside good fluid intake, as this helps meals fit more comfortably into your routine. Many customers use this plan for lunch and dinner while keeping breakfast and snacks simple. You can review and update your options before the next weekly order if you want to change flavours or meal combinations.',
      'faqs' => [
        ['q' => 'Is this plan vegetarian?', 'a' => 'It is plant-forward, but available options may still include different protein choices depending on the custom selections offered on the product page.'],
        ['q' => 'Will this plan help with digestion?', 'a' => 'It is designed around fibre-conscious ingredients and balanced meal choices, but it is not a medical product and results vary from person to person.'],
        ['q' => 'Do I need to drink more water with this plan?', 'a' => 'Yes. A good fluid intake is recommended whenever you increase fibre intake as part of your routine.'],
      ],
    ],

    'whey protein 1kg' => [
      'description' => 'PrepPal Whey Protein 1kg is a versatile everyday protein powder created for customers who want a convenient way to support their protein intake, recovery, and muscle maintenance. It mixes easily, comes in multiple flavours, and is suitable for a range of goals including building muscle, increasing total daily protein, or simply improving the nutritional quality of snacks and shakes. The formula is designed to fit easily into busy routines, whether you are using it after training, between lectures, during work breaks, or as part of breakfast. Because it is quick to prepare and simple to portion, it is ideal for customers who want a reliable protein option without complicated prep. It can be used on both training days and rest days depending on your intake target.',
      'how_to_use' => 'Add one serving to water or milk, shake well until smooth, and consume when convenient for your routine. Many customers use whey protein after training, between meals, or alongside breakfast to help increase daily protein intake. Adjust the liquid amount depending on whether you want a lighter shake or a creamier texture. It can also be blended into oats, yoghurt, or smoothies. Always follow the serving guidance on the label and use it as part of a balanced diet rather than as a full replacement for varied meals.',
      'faqs' => [
        ['q' => 'When is the best time to take whey protein?', 'a' => 'It can be used whenever it helps you meet your daily protein target, though many customers prefer it after training or between meals.'],
        ['q' => 'Can I use whey protein on rest days?', 'a' => 'Yes. Protein intake still matters on rest days, especially if you are trying to support recovery or maintain muscle mass.'],
        ['q' => 'Can it be mixed with milk instead of water?', 'a' => 'Yes. Mixing with milk can create a creamier texture and may increase calories and protein depending on the milk used.'],
      ],
    ],

    'creatine monohydrate 300g' => [
      'description' => 'PrepPal Creatine Monohydrate 300g is a simple, high-value training supplement for customers who want to support power output, repeated performance, and long-term training progress. Creatine is one of the most established sports supplements and is widely used by gym-goers, athletes, and active individuals because it is straightforward to use and easy to build into a routine. This product is suitable for people focused on strength work, sprint efforts, muscle gain phases, and general performance support. Because consistency matters more than timing perfection, this creatine is designed to be something customers can use daily without complication. It is available in multiple flavour options so it can fit more comfortably into everyday supplement habits.',
      'how_to_use' => 'Mix the recommended serving with water and take it daily, including on both training and rest days. The most important thing is consistency over time, so pick a time that is easy for you to stick to, such as with breakfast, before training, or after your workout. Stay well hydrated throughout the day while using creatine. You do not need a complicated routine to benefit from it; regular daily use is the key. Always follow the label instructions for serving size and storage.',
      'faqs' => [
        ['q' => 'Do I need to take creatine every day?', 'a' => 'Yes. Daily use is generally recommended so that it becomes part of a consistent routine, including on rest days.'],
        ['q' => 'When should I take creatine?', 'a' => 'Any consistent time of day is fine. The best time is the one you can realistically stick to.'],
        ['q' => 'Should I drink more water while taking creatine?', 'a' => 'Yes. Good hydration is recommended as part of normal supplement use and training support.'],
      ],
    ],

    'bcaa powder 250g' => [
      'description' => 'PrepPal BCAA Powder 250g is designed for customers who want a convenient intra-workout or between-meal drink option to support training sessions and supplement routines. It offers a light, flavoured way to stay on top of amino acid intake around exercise, especially for customers who prefer sipping something during longer or more intense workouts. This product can suit gym-goers, active students, and anyone who wants a simple addition to their supplement stack without heavy preparation. While it is not a replacement for an overall good diet and adequate daily protein intake, it can fit well into structured routines focused on training consistency, hydration, and session support.',
      'how_to_use' => 'Mix the suggested serving with water and sip during training or between meals depending on your preference. Many customers use BCAA powder as an intra-workout drink during longer sessions, cardio blocks, or busy days when they want something light and flavoured. Shake thoroughly before use and adjust the water amount to taste. Keep total daily nutrition in mind and use the product alongside a balanced diet and adequate protein intake.',
      'faqs' => [
        ['q' => 'When should I use BCAA powder?', 'a' => 'Most customers use it during workouts or between meals when they want a light supplement drink.'],
        ['q' => 'Is BCAA powder a substitute for protein?', 'a' => 'No. It is best seen as an additional supplement, not a replacement for total daily protein intake from food or protein shakes.'],
        ['q' => 'Can I use it on non-training days?', 'a' => 'Yes, though many customers mainly save it for training sessions or active days.'],
      ],
    ],

    'daily multivitamin 60 tablets' => [
      'description' => 'PrepPal Daily Multivitamin 60 tablets is an easy everyday supplement for customers who want a simple addition to their routine to support general nutritional coverage. It is aimed at people with busy schedules, active lifestyles, or inconsistent eating patterns who want a convenient daily product that is quick to take and easy to remember. A multivitamin is not a substitute for a varied diet, but it can be a practical part of a wider wellness routine that includes balanced meals, hydration, and regular activity. This product is particularly suitable for customers who prefer low-maintenance supplementation without needing multiple separate tablets or powders.',
      'how_to_use' => 'Take the recommended number of tablets with water, ideally alongside a meal, and use it consistently as part of your normal daily routine. Many customers take their multivitamin with breakfast or lunch because it is easier to remember that way. Do not exceed the stated serving size, and store the tablets in a cool, dry place out of direct sunlight. A multivitamin works best as a support product alongside balanced eating rather than as a replacement for it.',
      'faqs' => [
        ['q' => 'Should I take a multivitamin with food?', 'a' => 'Yes. Taking it with a meal is often the most practical and comfortable option for many customers.'],
        ['q' => 'Can this replace a healthy diet?', 'a' => 'No. It is designed to complement a balanced diet, not replace proper meals and good nutrition habits.'],
        ['q' => 'What time of day should I take it?', 'a' => 'Any consistent time is fine, though breakfast or lunch is often easiest for routine.'],
      ],
    ],

    'pre-workout jay cutler' => [
      'description' => 'Built in partnership with Jay Cutler, this exclusive PrepPal pre-workout was created to help take your training to the next level. We worked together to develop a product that reflects both PrepPal’s commitment to performance and Jay Cutler’s elite bodybuilding standards, resulting in a powerful formula designed for serious gym-goers. Made to support energy, focus, and workout intensity, this pre-workout is ideal for anyone who wants to feel fully prepared before training. Whether you are lifting heavy, chasing a pump, or pushing through a demanding session, it is designed to help you get in the right mindset and perform at your best. What makes this product special is the collaboration behind it. By combining PrepPal’s modern sports nutrition vision with the experience and reputation of Jay Cutler, we created a pre-workout that feels premium, performs strongly, and stands out from the rest. It is also easy to make part of your routine, with great flavour, a strong look, and a formula built for consistent use by people serious about progress.',
      'how_to_use' => 'Mix the recommended serving with water and consume before training according to the label guidance. Start with the lower end of the suggested serving if you are new to pre-workout products or want to assess tolerance first. Avoid taking it too close to bedtime, and do not combine it carelessly with other stimulant products. Many customers use it around 20 to 30 minutes before a gym session so it fits naturally into their warm-up routine. Always follow the label directions and use only as intended.',
      'faqs' => [
        ['q' => 'When should I take this pre-workout?', 'a' => 'Most customers take it shortly before training so it lines up with the start of their session.'],
        ['q' => 'Is it suitable for evening workouts?', 'a' => 'It depends on your stimulant tolerance. If you are sensitive to energising products, avoid taking it too close to bedtime.'],
        ['q' => 'Should beginners use a full serving straight away?', 'a' => 'No. It is better to begin with a smaller amount first to assess how you respond.'],
      ],
    ],

    'electrolyte hydration mix' => [
      'description' => 'PrepPal Electrolyte Hydration Mix is a convenient hydration support option for customers who want a simple powdered drink for workouts, sport, travel, or busy days. It is designed to be easy to mix, easy to carry, and practical for people who want something more purposeful than plain water during active routines. This product works well for gym-goers, runners, team sport players, or anyone who wants a portable hydration option around exercise and warm conditions. Because it comes in a mix format, it is also easy to keep in a bag, locker, or kitchen cupboard for regular use.',
      'how_to_use' => 'Mix one serving with water and shake or stir until dissolved. Use before, during, or after training depending on your needs, or keep it for active days when staying hydrated feels more difficult. Adjust water quantity to taste and always follow the serving guidance on the packaging. It should be used as part of normal fluid intake rather than as a substitute for regular hydration habits across the day.',
      'faqs' => [
        ['q' => 'When should I use the hydration mix?', 'a' => 'It can be used before, during, or after exercise, or on active days when you want a more convenient hydration option.'],
        ['q' => 'Is it only for gym sessions?', 'a' => 'No. It can also be useful for travel, warm weather, sport, or generally busy days.'],
        ['q' => 'Do I still need to drink plain water?', 'a' => 'Yes. This product should support your hydration routine, not fully replace normal water intake.'],
      ],
    ],

    'zero sugar electrolyte drink' => [
      'description' => 'PrepPal Zero Sugar Electrolyte Drink is a ready-to-drink hydration option for customers who want convenience, refreshment, and practical workout support without added sugar. It is ideal for keeping in the fridge, taking to the gym, or using on the go when mixing powders is not convenient. The product is designed for active customers who want something light, easy to drink, and suitable around training, travel, work, or everyday movement. Because it is pre-made, it is especially useful for people who value speed and simplicity in their routine.',
      'how_to_use' => 'Chill before drinking for the best taste, then consume whenever you want a convenient hydration option. Many customers use it before or during workouts, after sweating heavily, or during busy days when plain water feels less appealing. It can be enjoyed straight from the bottle and works well as part of a wider hydration routine. Store according to the label instructions once opened.',
      'faqs' => [
        ['q' => 'Is this drink suitable during workouts?', 'a' => 'Yes. It is a practical ready-to-drink option for training sessions and active days.'],
        ['q' => 'Does zero sugar mean it has no flavour?', 'a' => 'No. It is designed to stay refreshing and flavourful without relying on sugar.'],
        ['q' => 'Can I keep it in the fridge?', 'a' => 'Yes. Many customers prefer it chilled before use.'],
      ],
    ],

    'whey protein shake' => [
      'description' => 'PrepPal Whey Protein Shake is a ready-to-drink protein option for customers who want a fast, no-prep way to increase protein intake throughout the day. It is especially useful after training, during busy work or study schedules, or whenever making a full shake is inconvenient. The drink is designed to offer a smoother grab-and-go experience than powders, making it practical for gym bags, commuting, or keeping in the fridge for quick use. It is a strong choice for customers who value convenience and want an easy protein product that fits around real life.',
      'how_to_use' => 'Shake the bottle well before opening and enjoy chilled or at room temperature depending on preference. Many customers use it after workouts, as a quick snack between meals, or during busy days when preparing a normal shake is inconvenient. Once opened, refrigerate if required and consume according to the label guidance. Use it as part of your overall daily nutrition rather than as a replacement for balanced meals.',
      'faqs' => [
        ['q' => 'Is this best used after training?', 'a' => 'It works very well after training, but it can also be used any time you want a quick protein option.'],
        ['q' => 'Do I need a shaker bottle for this?', 'a' => 'No. It is ready to drink, so it is designed for convenience straight from the bottle.'],
        ['q' => 'Can I use it as a snack?', 'a' => 'Yes. Many customers use it as an easy high-protein snack between meals.'],
      ],
    ],

    'plant-based protein drink' => [
      'description' => 'PrepPal Plant-Based Protein Drink is a convenient ready-to-drink option for customers who want a vegan-friendly protein product that fits busy schedules. It is suitable for customers who avoid dairy, prefer plant-based choices, or simply want more variety in their protein options. The drink is designed to be practical, portable, and easy to use after exercise or between meals, making it a useful option for work, travel, gym bags, or everyday routines. It offers a more accessible way to support protein intake without needing to prepare shakes from scratch.',
      'how_to_use' => 'Shake well before use and enjoy chilled or at room temperature. Many customers use it after training, as a mid-day protein boost, or as a convenient backup option when they do not have time to prepare food. Follow the storage guidance on the packaging once opened. It is best used as part of a balanced diet and a routine that includes varied meals and hydration.',
      'faqs' => [
        ['q' => 'Is this suitable for customers avoiding dairy?', 'a' => 'Yes. It is intended as a plant-based alternative to traditional dairy-based ready-to-drink protein options.'],
        ['q' => 'Can I drink it after the gym?', 'a' => 'Yes. It is a convenient post-workout option as well as a general protein drink during the day.'],
        ['q' => 'Is it only for vegans?', 'a' => 'No. Anyone wanting a plant-based protein option can use it.'],
      ],
    ],

    'pre-workout energy drink' => [
      'description' => 'PrepPal Pre-Workout Energy Drink is a ready-to-drink option for customers who want a fast, convenient boost before training without needing to mix powders. It is ideal for gym-goers who train on the move, finish work and go straight to the gym, or simply prefer the ease of a chilled can or bottle before a session. The drink is designed to fit naturally into a pre-workout routine and suits people who value convenience, portability, and a more immediate grab-and-go format. It works well for strength sessions, conditioning, or active days where extra motivation is useful.',
      'how_to_use' => 'Drink shortly before training according to your tolerance and the label guidance. Many customers prefer to chill it first and consume it on the way to the gym or during their warm-up. Avoid taking it too late in the day if you are sensitive to energising drinks, and do not combine it carelessly with other stimulant products. Use it as intended and pay attention to serving advice on the packaging.',
      'faqs' => [
        ['q' => 'Is this a replacement for powdered pre-workout?', 'a' => 'It is an alternative format for customers who prefer convenience and portability over mixing powders.'],
        ['q' => 'When should I drink it?', 'a' => 'Most customers use it shortly before training so it aligns with the start of their session.'],
        ['q' => 'Can I take it in the evening?', 'a' => 'Only if you know you tolerate energising drinks well, as late use may affect sleep for some people.'],
      ],
    ],

    'bcaa energy drink' => [
      'description' => 'PrepPal BCAA Energy Drink is designed for customers who want a light, ready-to-drink performance beverage that fits around training and active routines. It combines the convenience of a bottled or canned format with the kind of session support many customers look for during gym workouts, cardio, or busy days. Because it is ready to drink, it is easy to take to the gym, keep chilled, or grab on the way out of the house. It is particularly useful for customers who prefer sipping a flavoured performance drink instead of mixing supplements separately.',
      'how_to_use' => 'Consume chilled before or during training, depending on your preference and the label guidance. Many customers use it for convenience on gym days, longer active sessions, or when they want a flavoured drink that feels more purposeful than a standard soft drink. Shake if directed on the packaging and store appropriately after opening. Use it alongside a balanced routine rather than in place of proper nutrition.',
      'faqs' => [
        ['q' => 'Is this best before or during a workout?', 'a' => 'It can suit either, depending on your routine and how you prefer to use performance drinks.'],
        ['q' => 'Do I need to mix anything with it?', 'a' => 'No. It is ready to drink for convenience.'],
        ['q' => 'Can I keep it chilled?', 'a' => 'Yes. Many customers prefer the taste when it is cold.'],
      ],
    ],

    'recovery shake' => [
      'description' => 'PrepPal Recovery Shake is a convenient post-workout drink designed for customers who want a more purposeful option after training sessions. It is aimed at people looking for an easy recovery product that fits into gym bags, busy schedules, and fast-paced routines without needing blenders or extra preparation. The drink is especially useful after strength sessions, sport, or demanding active days when having something ready to go makes consistency much easier. It supports the part of the routine that comes after the workout, helping customers stay organised with recovery nutrition.',
      'how_to_use' => 'Shake well and consume after training or at another point in the day when a recovery-style drink suits your routine. Many customers keep it chilled and use it shortly after finishing a workout because it is quick and convenient. Follow any on-pack guidance for storage once opened. Use it as part of a wider recovery approach that includes good meals, hydration, and adequate rest.',
      'faqs' => [
        ['q' => 'When should I drink the recovery shake?', 'a' => 'Most customers use it after training, though it can also be used later in the day when convenient.'],
        ['q' => 'Is it only for heavy gym sessions?', 'a' => 'No. It can also fit after sport, cardio, or other demanding active routines.'],
        ['q' => 'Does it replace a post-workout meal?', 'a' => 'Not necessarily. It works best as part of an overall recovery routine that still includes balanced meals.'],
      ],
    ],

    'green smoothie' => [
      'description' => 'PrepPal Green Smoothie is a light, convenient drink option for customers who want a more refreshing and wellness-focused product in their routine. It is well suited to mornings, busy afternoons, or lighter moments in the day when something smooth, simple, and easy to grab is more appealing than a heavier drink. The smoothie is designed to fit customers who want more variety in their choices, whether they are trying to improve daily habits, keep something chilled and ready to go, or simply enjoy a fresher style of beverage. It works well as part of a balanced lifestyle rather than as a replacement for full meals.',
      'how_to_use' => 'Shake before opening if needed, serve chilled for the best experience, and enjoy as part of your everyday routine. Many customers use it in the morning, alongside a light meal, or during the day when they want something more refreshing and convenient than preparing a smoothie themselves. Follow the storage guidance once opened. Use it as part of a balanced diet and not as a substitute for varied meals.',
      'faqs' => [
        ['q' => 'When is the best time to have the green smoothie?', 'a' => 'It is flexible and can work in the morning, during the day, or whenever you want a lighter ready-to-drink option.'],
        ['q' => 'Should it be served cold?', 'a' => 'Yes. Most customers prefer it chilled for the best taste and texture.'],
        ['q' => 'Is it meant to replace meals?', 'a' => 'No. It is best enjoyed as part of a balanced daily routine alongside normal meals.'],
      ],
    ],

    'preppal performance shaker' => [
      'description' => 'The PrepPal Performance Shaker is built for everyday gym use, whether you are mixing whey, pre-workout, hydration products, or simply carrying water through the day. It combines practical function with a bold PrepPal look, giving customers a clean branded shaker that feels premium both in the gym and on the go. It is easy to carry, easy to clean, and suitable for people who want their accessories to match the same high-performance feel as the rest of their training setup. With multiple product images shown in the gallery, customers can view the shaker from different angles before ordering.',
      'how_to_use' => 'Add your chosen powder and liquid, secure the lid fully, and shake until mixed. Rinse after use and wash thoroughly before the next session to keep the bottle fresh and ready for everyday training. It can be used for protein shakes, creatine, electrolyte mixes, pre-workout drinks, or plain water depending on your routine.',
      'faqs' => [
        ['q' => 'What can I use this shaker for?', 'a' => 'It can be used for whey protein, pre-workout, hydration mixes, creatine, or simply as an everyday water bottle.'],
        ['q' => 'Does the product page show more than one image?', 'a' => 'Yes. The shaker includes multiple gallery images so customers can view the product in more detail.'],
        ['q' => 'Is it suitable for everyday use?', 'a' => 'Yes. It is designed to work well both in the gym and as a general everyday training accessory.'],
      ],
    ],

    'preppal heavy duty lifting belt' => [
      'description' => 'The PrepPal Heavy Duty Lifting Belt is designed for customers who want extra support and stability during heavier training sessions. It is especially suitable for compound movements such as squats, deadlifts, rows, and other exercises where bracing and midsection support matter. The belt combines a strong, performance-led look with a sturdy feel, making it a practical piece of training equipment for both experienced lifters and customers building a more serious gym setup. The gallery shows different product images so customers can better understand the look and finish before purchasing.',
      'how_to_use' => 'Fasten the belt securely around the midsection before your heavier working sets, making sure it feels supportive without restricting normal breathing too much. It is most commonly used for big compound lifts where added trunk stability is helpful. Store it flat or hung up after use to help maintain shape over time.',
      'faqs' => [
        ['q' => 'What exercises is this belt best for?', 'a' => 'It is commonly used for squats, deadlifts, rows, and other heavier compound movements.'],
        ['q' => 'Should I wear it for every exercise?', 'a' => 'Not necessarily. Most customers save it for heavier sets where added support is most useful.'],
        ['q' => 'Does the page show more than one image?', 'a' => 'Yes. The belt includes alternate gallery images on the product page.'],
      ],
    ],

    'preppal wrist wraps' => [
      'description' => 'PrepPal Wrist Wraps are made for customers who want extra wrist support during pressing movements and demanding upper-body sessions. They are well suited to exercises such as bench press, shoulder press, machine pressing, and other sessions where wrist stability can improve comfort and confidence. The wraps also help complete a stronger overall gym look, making them a practical accessory for people building out their training essentials. Multiple gallery images let customers view the wraps more clearly before ordering.',
      'how_to_use' => 'Wrap them around the wrist firmly before pressing movements or other exercises where extra support feels useful. Adjust tightness to a level that feels secure but still comfortable for movement. After training, loosen and store them in a dry place ready for your next session.',
      'faqs' => [
        ['q' => 'When should I use wrist wraps?', 'a' => 'They are most useful during pressing exercises or heavier upper-body sessions where wrist support is helpful.'],
        ['q' => 'Can beginners use them too?', 'a' => 'Yes. They can be useful for both beginners and more experienced gym-goers depending on training style.'],
        ['q' => 'Are there multiple product images?', 'a' => 'Yes. The gallery includes additional wrap images for a better product view.'],
      ],
    ],

    'preppal liquid chalk' => [
      'description' => 'PrepPal Liquid Chalk is a practical grip support product for customers who want better hold during pulling movements, deadlifts, rows, calisthenics work, and other demanding exercises. It is designed to be a cleaner and more portable option than loose chalk, making it easier to keep in your gym bag and use when needed. This product is ideal for people whose grip starts to limit top sets or longer sessions, and it fits naturally into a more serious training routine.',
      'how_to_use' => 'Apply a small amount to the palms, spread it evenly across the hands, and allow it to dry briefly before lifting. Reapply only when needed and keep the bottle sealed between uses. Use it during sessions where extra grip support is useful, especially on pulling days.',
      'faqs' => [
        ['q' => 'What is liquid chalk best used for?', 'a' => 'It is especially useful for deadlifts, rows, pull movements, and other exercises where grip matters.'],
        ['q' => 'Is it cleaner than loose chalk?', 'a' => 'Yes. Many customers prefer it because it is more portable and generally less messy than traditional chalk.'],
        ['q' => 'Can I keep it in my gym bag?', 'a' => 'Yes. It is designed to be convenient for gym bags and on-the-go training use.'],
      ],
    ],

    'preppal wrist straps' => [
      'description' => 'PrepPal Wrist Straps are built for customers who want help with grip fatigue during heavier pulling movements and high-volume back work. They are especially useful on exercises such as deadlifts, rows, shrugs, and machine pulls where grip can become the weak point before the target muscles are fully challenged. These straps are a practical addition for lifters who want to push their sets harder while keeping a strong gym-ready PrepPal look. The product gallery includes alternate imagery so customers can see more of the product before purchase.',
      'how_to_use' => 'Loop the straps correctly around the wrist and bar before your working sets, then tighten them enough to assist grip without making setup uncomfortable. They are most useful during heavy or higher-rep pulling work where the hands begin to fatigue first. Store them dry after use and check them regularly as part of normal kit care.',
      'faqs' => [
        ['q' => 'What exercises are wrist straps most useful for?', 'a' => 'They are especially useful for deadlifts, rows, shrugs, machine pulls, and other grip-heavy training.'],
        ['q' => 'Are straps only for advanced lifters?', 'a' => 'No. Anyone whose grip limits pulling movements may find them useful.'],
        ['q' => 'Does the product page include more than one image?', 'a' => 'Yes. The straps use a multi-image gallery on the product page.'],
      ],
    ],
  ];

  $content = $productContent[$productSlug] ?? [
    'description' => $product->description,
    'how_to_use' => $isClothing
      ? 'Select your preferred size, review the fit guide if needed, and add the item to your cart. Once your order arrives, try it on indoors first to check the fit and comfort before training in it. Follow the care instructions on the garment label to help maintain colour, print quality, and fabric performance over time.'
      : ($isEquipment
          ? 'Use the product according to its intended training purpose and keep it clean, dry, and stored correctly between sessions. Check the product before use, especially if it is something worn or gripped during training, and follow any care guidance provided.'
          : 'Follow the directions provided on the product label and use the product consistently as part of your normal routine. Make sure you store it correctly, pay attention to serving guidance where relevant, and combine it with a balanced diet, hydration, and sensible everyday habits.'),
    'faqs' => $isClothing
      ? [
          ['q' => 'How do I choose the right size?', 'a' => 'Use the size selector and check the size guide on the product page before ordering if you are unsure.'],
          ['q' => 'Can I return clothing if it does not fit?', 'a' => 'Unused items should follow the store return policy, so check the returns information provided at checkout or on the site.'],
          ['q' => 'How should I wash this item?', 'a' => 'Follow the care label instructions on the garment to help preserve fit, fabric, and printed design quality.'],
        ]
      : ($isEquipment
          ? [
              ['q' => 'Is this product suitable for regular gym use?', 'a' => 'Yes. Equipment items are intended to fit naturally into normal gym routines depending on the product type.'],
              ['q' => 'How should I store it after use?', 'a' => 'Keep it dry, clean, and stored properly between sessions so it stays in good condition.'],
              ['q' => 'Will I see multiple product images?', 'a' => 'Yes, where available, equipment products can show multiple gallery images on the product page.'],
            ]
          : [
              ['q' => 'When will my order arrive?', 'a' => 'Most UK orders arrive within 2 to 4 working days, though timings may vary during busy periods.'],
              ['q' => 'How should I store this product?', 'a' => 'Store it according to the label guidance in a cool, dry place or chilled if stated on the packaging.'],
              ['q' => 'Can I use this product every day?', 'a' => 'That depends on the product type and label directions, so always follow the intended usage guidance provided.'],
            ]),
  ];

  $wheyFlavours = [
    'vanilla' => [
      'label' => 'Vanilla',
      'cart_name' => 'Whey Protein 1kg - Vanilla',
      'image' => asset('images/whey_proteinvanilla.png'),
      'gallery' => [
        asset('images/whey_proteinvanilla.png'),
      ],
    ],
    'banana' => [
      'label' => 'Banana',
      'cart_name' => 'Whey Protein 1kg - Banana',
      'image' => asset('images/whey_proteinban.png'),
      'gallery' => [
        asset('images/whey_proteinban.png'),
      ],
    ],
    'coffee' => [
      'label' => 'Coffee',
      'cart_name' => 'Whey Protein 1kg - Coffee',
      'image' => asset('images/whey_proteincafe.png'),
      'gallery' => [
        asset('images/whey_proteincafe.png'),
      ],
    ],
    'peanut_butter' => [
      'label' => 'Peanut Butter',
      'cart_name' => 'Whey Protein 1kg - Peanut Butter',
      'image' => asset('images/whey_protein.png'),
      'gallery' => [
        asset('images/whey_protein.png'),
      ],
    ],
    'chocolate' => [
      'label' => 'Chocolate',
      'cart_name' => 'Whey Protein 1kg - Chocolate',
      'image' => asset('images/whey_proteinchoc.png'),
      'gallery' => [
        asset('images/whey_proteinchoc.png'),
      ],
    ],
  ];

  $creatineFlavours = [
    'cool_blue' => [
      'label' => 'Cool Blue',
      'cart_name' => 'Creatine Monohydrate 300g - Cool Blue',
      'image' => asset('images/creatine_monohydrate.jpg'),
      'gallery' => [
        asset('images/creatine_monohydrate.jpg'),
        asset('images/creatine_monohydrate2.png'),
        asset('images/creatine_monohydrate-3.png'),
      ],
    ],
    'berry' => [
      'label' => 'Berry',
      'cart_name' => 'Creatine Monohydrate 300g - Berry',
      'image' => asset('images/creatine_monohydrateberry.png'),
      'gallery' => [
        asset('images/creatine_monohydrateberry.png'),
      ],
    ],
    'lime' => [
      'label' => 'Lime',
      'cart_name' => 'Creatine Monohydrate 300g - Lime',
      'image' => asset('images/creatine_monohydratelime.png'),
      'gallery' => [
        asset('images/creatine_monohydratelime.png'),
      ],
    ],
    'melon' => [
      'label' => 'Melon',
      'cart_name' => 'Creatine Monohydrate 300g - Melon',
      'image' => asset('images/creatine_monohydratemelon.png'),
      'gallery' => [
        asset('images/creatine_monohydratemelon.png'),
      ],
    ],
  ];

  $preWorkoutFlavours = [
    'grape' => [
      'label' => 'Grape',
      'cart_name' => 'Pre-workout Jay Cutler - Grape',
      'image' => asset('images/preworkoutjay.png'),
      'gallery' => [
        asset('images/preworkoutjay.png'),
      ],
    ],
    'pineapple' => [
      'label' => 'Pineapple',
      'cart_name' => 'Pre-workout Jay Cutler - Pineapple',
      'image' => asset('images/preworkoutpine.png'),
      'gallery' => [
        asset('images/preworkoutpine.png'),
      ],
    ],
    'lemon' => [
      'label' => 'Lemon',
      'cart_name' => 'Pre-workout Jay Cutler - Lemon',
      'image' => asset('images/preworkoutlemon.png'),
      'gallery' => [
        asset('images/preworkoutlemon.png'),
      ],
    ],
    'mango' => [
      'label' => 'Mango',
      'cart_name' => 'Pre-workout Jay Cutler - Mango',
      'image' => asset('images/preworkoutmango.png'),
      'gallery' => [
        asset('images/preworkoutmango.png'),
      ],
    ],
  ];

  $bcaaFlavours = [
    'fruit_punch' => [
      'label' => 'Fruit Punch',
      'cart_name' => 'BCAA Powder 250g - Fruit Punch',
      'image' => asset('images/bcaa_powder.jpg'),
      'gallery' => [
        asset('images/bcaa_powder.jpg'),
      ],
    ],
    'blueberry' => [
      'label' => 'Blueberry',
      'cart_name' => 'BCAA Powder 250g - Blueberry',
      'image' => asset('images/bcaa_powderblue.png'),
      'gallery' => [
        asset('images/bcaa_powderblue.png'),
      ],
    ],
  ];

  $equipmentVariants = [];

  if ($isShaker) {
    $equipmentVariants = [
      'standard' => [
        'label' => 'Standard',
        'cart_name' => 'PrepPal Performance Shaker',
        'image' => asset('images/shaker1.png'),
        'gallery' => [
          asset('images/shaker1.png'),
          asset('images/shaker2.png'),
        ],
      ],
    ];
  } elseif ($isBelt) {
    $equipmentVariants = [
      'standard' => [
        'label' => 'Standard',
        'cart_name' => 'PrepPal Heavy Duty Lifting Belt',
        'image' => asset('images/belt1.png'),
        'gallery' => [
          asset('images/belt1.png'),
          asset('images/belt2.png'),
        ],
      ],
    ];
  } elseif ($isWraps) {
    $equipmentVariants = [
      'standard' => [
        'label' => 'Standard',
        'cart_name' => 'PrepPal Wrist Wraps',
        'image' => asset('images/wraps1.png'),
        'gallery' => [
          asset('images/wraps1.png'),
          asset('images/wraps2.png'),
        ],
      ],
    ];
  } elseif ($isChalk) {
    $equipmentVariants = [
      'standard' => [
        'label' => 'Standard',
        'cart_name' => 'PrepPal Liquid Chalk',
        'image' => asset('images/chalk.png'),
        'gallery' => [
          asset('images/chalk.png'),
        ],
      ],
    ];
  } elseif ($isStraps) {
    $equipmentVariants = [
      'standard' => [
        'label' => 'Standard',
        'cart_name' => 'PrepPal Wrist Straps',
        'image' => asset('images/straps1.png'),
        'gallery' => [
          asset('images/straps1.png'),
          asset('images/straps2.png'),
        ],
      ],
    ];
  }

  $clothingVariants = [];

  if ($isTank) {
    $clothingVariants = [
      'black_s' => [
        'label' => 'Black - Small',
        'cart_name' => 'PrepPal Performance Tank - Black / Small',
        'image' => asset('images/tanktop.png'),
        'gallery' => [
          asset('images/tanktop.png'),
        ],
      ],
      'black_m' => [
        'label' => 'Black - Medium',
        'cart_name' => 'PrepPal Performance Tank - Black / Medium',
        'image' => asset('images/tanktop.png'),
        'gallery' => [
          asset('images/tanktop.png'),
        ],
      ],
      'black_l' => [
        'label' => 'Black - Large',
        'cart_name' => 'PrepPal Performance Tank - Black / Large',
        'image' => asset('images/tanktop.png'),
        'gallery' => [
          asset('images/tanktop.png'),
        ],
      ],
      'black_xl' => [
        'label' => 'Black - XL',
        'cart_name' => 'PrepPal Performance Tank - Black / XL',
        'image' => asset('images/tanktop.png'),
        'gallery' => [
          asset('images/tanktop.png'),
        ],
      ],
    ];
  } elseif ($isShorts) {
    $clothingVariants = [
      'black_s' => [
        'label' => 'Black - Small',
        'cart_name' => 'PrepPal Training Shorts - Black / Small',
        'image' => asset('images/shortsfront.png'),
        'gallery' => [
          asset('images/shortsfront.png'),
          asset('images/shortsback.png'),
        ],
      ],
      'black_m' => [
        'label' => 'Black - Medium',
        'cart_name' => 'PrepPal Training Shorts - Black / Medium',
        'image' => asset('images/shortsfront.png'),
        'gallery' => [
          asset('images/shortsfront.png'),
          asset('images/shortsback.png'),
        ],
      ],
      'black_l' => [
        'label' => 'Black - Large',
        'cart_name' => 'PrepPal Training Shorts - Black / Large',
        'image' => asset('images/shortsfront.png'),
        'gallery' => [
          asset('images/shortsfront.png'),
          asset('images/shortsback.png'),
        ],
      ],
      'black_xl' => [
        'label' => 'Black - XL',
        'cart_name' => 'PrepPal Training Shorts - Black / XL',
        'image' => asset('images/shortsfront.png'),
        'gallery' => [
          asset('images/shortsfront.png'),
          asset('images/shortsback.png'),
        ],
      ],
    ];
  } elseif ($isZip) {
    $clothingVariants = [
      'black_s' => [
        'label' => 'Black - Small',
        'cart_name' => 'PrepPal Zip Hoodie - Black / Small',
        'image' => asset('images/zipfront.png'),
        'gallery' => [
          asset('images/zipfront.png'),
          asset('images/zipback.png'),
        ],
      ],
      'black_m' => [
        'label' => 'Black - Medium',
        'cart_name' => 'PrepPal Zip Hoodie - Black / Medium',
        'image' => asset('images/zipfront.png'),
        'gallery' => [
          asset('images/zipfront.png'),
          asset('images/zipback.png'),
        ],
      ],
      'black_l' => [
        'label' => 'Black - Large',
        'cart_name' => 'PrepPal Zip Hoodie - Black / Large',
        'image' => asset('images/zipfront.png'),
        'gallery' => [
          asset('images/zipfront.png'),
          asset('images/zipback.png'),
        ],
      ],
      'black_xl' => [
        'label' => 'Black - XL',
        'cart_name' => 'PrepPal Zip Hoodie - Black / XL',
        'image' => asset('images/zipfront.png'),
        'gallery' => [
          asset('images/zipfront.png'),
          asset('images/zipback.png'),
        ],
      ],
    ];
  } elseif ($isPants) {
    $clothingVariants = [
      'black_s' => [
        'label' => 'Black - Small',
        'cart_name' => 'PrepPal Joggers - Black / Small',
        'image' => asset('images/pants.png'),
        'gallery' => [
          asset('images/pants.png'),
        ],
      ],
      'black_m' => [
        'label' => 'Black - Medium',
        'cart_name' => 'PrepPal Joggers - Black / Medium',
        'image' => asset('images/pants.png'),
        'gallery' => [
          asset('images/pants.png'),
        ],
      ],
      'black_l' => [
        'label' => 'Black - Large',
        'cart_name' => 'PrepPal Joggers - Black / Large',
        'image' => asset('images/pants.png'),
        'gallery' => [
          asset('images/pants.png'),
        ],
      ],
      'black_xl' => [
        'label' => 'Black - XL',
        'cart_name' => 'PrepPal Joggers - Black / XL',
        'image' => asset('images/pants.png'),
        'gallery' => [
          asset('images/pants.png'),
        ],
      ],
    ];
  } elseif ($isGymGirlSet) {
    $clothingVariants = [
      'black_s' => [
        'label' => 'Black - Small',
        'cart_name' => 'PrepPal Gym Girl Set - Black / Small',
        'image' => asset('images/gymgirlset.png'),
        'gallery' => [
          asset('images/gymgirlset.png'),
        ],
      ],
      'black_m' => [
        'label' => 'Black - Medium',
        'cart_name' => 'PrepPal Gym Girl Set - Black / Medium',
        'image' => asset('images/gymgirlset.png'),
        'gallery' => [
          asset('images/gymgirlset.png'),
        ],
      ],
      'black_l' => [
        'label' => 'Black - Large',
        'cart_name' => 'PrepPal Gym Girl Set - Black / Large',
        'image' => asset('images/gymgirlset.png'),
        'gallery' => [
          asset('images/gymgirlset.png'),
        ],
      ],
      'black_xl' => [
        'label' => 'Black - XL',
        'cart_name' => 'PrepPal Gym Girl Set - Black / XL',
        'image' => asset('images/gymgirlset.png'),
        'gallery' => [
          asset('images/gymgirlset.png'),
        ],
      ],
    ];
  }

  $activeFlavours = $isClothing
    ? $clothingVariants
    : ($isEquipment
        ? $equipmentVariants
        : ($isWheyProtein
            ? $wheyFlavours
            : ($isCreatine
                ? $creatineFlavours
                : ($isPreWorkout
                    ? $preWorkoutFlavours
                    : ($isBcaa ? $bcaaFlavours : [])))));

  $defaultFlavourKey = $isClothing
    ? (count($clothingVariants) ? array_key_first($clothingVariants) : null)
    : ($isEquipment
        ? (count($equipmentVariants) ? array_key_first($equipmentVariants) : null)
        : ($isWheyProtein
            ? 'vanilla'
            : ($isCreatine
                ? 'berry'
                : ($isPreWorkout
                    ? 'grape'
                    : ($isBcaa ? 'fruit_punch' : null)))));
@endphp

<main class="container main-content">

  <nav class="pp-breadcrumb">
    <a href="{{ url('/') }}">Home</a>
    <span>/</span>
    <a href="{{ route('store') }}">Store</a>
    <span>/</span>
    <span class="pp-crumb-current">{{ $product->name }}</span>
  </nav>

  <div class="pp-pdp">

    <section class="pp-pdp-left">

      <style>
        .pp-gal {
          display: grid;
          gap: 12px;
        }

        .pp-gal-frame{
          position: relative;
          overflow: hidden;
          border-radius: 18px;
          background: rgba(255,255,255,.04);
          border: 1px solid rgba(255,255,255,.10);
          box-shadow: 0 18px 50px rgba(0,0,0,.25);
          display: flex;
          align-items: center;
          justify-content: center;
          min-height: 0;
        }

        body:not([data-theme="dark"]) .pp-gal-frame{
          background: rgba(0,0,0,.02);
          border: 1px solid rgba(0,0,0,.08);
          box-shadow: 0 18px 50px rgba(0,0,0,.10);
        }

        .pp-gal-viewport{
          overflow: hidden;
          width: 100%;
        }

        .pp-gal-track{
          display: flex;
          width: 100%;
          will-change: transform;
          transition: transform .35s ease;
          touch-action: pan-y;
        }

        .pp-gal-slide{
          min-width: 100%;
          display: flex;
          align-items: center;
          justify-content: center;
        }

        .pp-gal-img{
          width: 100%;
          max-width: 720px;
          height: auto;
          max-height: 720px;
          object-fit: contain;
          object-position: center;
          display: block;
          margin: 0 auto;
          background: transparent;
          padding: 0;
          box-sizing: border-box;
        }

        @media (max-width: 980px){
          .pp-gal-img{
            max-width: 100%;
            max-height: 560px;
          }
        }

        @media (max-width: 520px){
          .pp-gal-img{
            max-height: 420px;
          }
        }

        .pp-gal-nav{
          position: absolute;
          top: 50%;
          transform: translateY(-50%);
          width: 46px;
          height: 46px;
          border-radius: 12px;
          border: 1px solid rgba(255,255,255,.16);
          background: rgba(0,0,0,.38);
          color: #fff;
          font-size: 28px;
          line-height: 1;
          display: grid;
          place-items: center;
          cursor: pointer;
          z-index: 5;
          opacity: 0;
          transition: opacity .18s ease;
        }

        .pp-gal-frame:hover .pp-gal-nav{ opacity: 1; }
        .pp-gal-prev{ left: 12px; }
        .pp-gal-next{ right: 12px; }
        .pp-gal-nav[disabled]{ opacity: .25 !important; cursor: not-allowed; }

        .pp-gal-dots{
          position: absolute;
          left: 50%;
          bottom: 12px;
          transform: translateX(-50%);
          display: flex;
          gap: 6px;
          z-index: 5;
        }

        .pp-gal-dot{
          width: 7px;
          height: 7px;
          border-radius: 999px;
          background: rgba(255,255,255,.35);
          border: 1px solid rgba(255,255,255,.25);
        }

        .pp-gal-dot.is-active{
          background: rgba(255,140,0,.95);
          border-color: rgba(255,140,0,.65);
        }

        .pp-gal-thumbs{
          display: flex;
          gap: 10px;
          overflow: auto;
          padding-bottom: 4px;
          scrollbar-width: thin;
        }

        .pp-gal-thumb{
          flex: 0 0 auto;
          width: 86px;
          height: 86px;
          border-radius: 14px;
          overflow: hidden;
          border: 1px solid rgba(255,255,255,.14);
          background: rgba(255,255,255,.05);
          cursor: pointer;
          padding: 0;
        }

        body:not([data-theme="dark"]) .pp-gal-thumb{
          border: 1px solid rgba(0,0,0,.10);
          background: rgba(0,0,0,.02);
        }

        .pp-gal-thumb img{
          width: 100%;
          height: 100%;
          object-fit: cover;
          display: block;
        }

        .pp-gal-thumb.is-active{
          outline: 2px solid rgba(255,140,0,.65);
          outline-offset: 2px;
        }

        .pp-option-group{
          margin: 18px 0 10px;
        }

        .pp-option-label{
          display: block;
          font-weight: 700;
          margin-bottom: 10px;
          color: inherit;
        }

        .pp-option-select{
          width: 100%;
          height: 54px;
          border-radius: 14px;
          border: 1px solid rgba(255,255,255,.12);
          background: #0f1830;
          color: #ffffff;
          padding: 0 16px;
          font-size: 1rem;
          font-weight: 600;
          outline: none;
        }

        .pp-option-select option{
          background: #0f1830;
          color: #ffffff;
        }

        body:not([data-theme="dark"]) .pp-option-select{
          border: 1px solid rgba(0,0,0,.10);
          background: #ffffff;
          color: #111827;
        }

        body:not([data-theme="dark"]) .pp-option-select option{
          background: #ffffff;
          color: #111827;
        }

        .pp-selected-flavour{
          margin-top: 8px;
          font-size: .95rem;
          opacity: .85;
        }

        .pp-size-guide-btn{
          margin-top: 12px;
          border: 1px solid rgba(255,140,0,.35);
          background: transparent;
          color: #ff8c00;
          border-radius: 12px;
          padding: 10px 14px;
          font-weight: 700;
          cursor: pointer;
          transition: .2s ease;
        }

        .pp-size-guide-btn:hover{
          background: rgba(255,140,0,.08);
        }

        .pp-size-guide-modal{
          position: fixed;
          inset: 0;
          z-index: 9999;
          display: none;
        }

        .pp-size-guide-modal.is-open{
          display: block;
        }

        .pp-size-guide-backdrop{
          position: absolute;
          inset: 0;
          background: rgba(0,0,0,.65);
        }

        .pp-size-guide-panel{
          position: relative;
          width: min(720px, calc(100% - 32px));
          margin: 6vh auto 0;
          background: #0f1830;
          color: #fff;
          border: 1px solid rgba(255,255,255,.12);
          border-radius: 20px;
          box-shadow: 0 24px 80px rgba(0,0,0,.35);
          padding: 24px;
          z-index: 2;
        }

        body:not([data-theme="dark"]) .pp-size-guide-panel{
          background: #ffffff;
          color: #111827;
          border: 1px solid rgba(0,0,0,.08);
        }

        .pp-size-guide-close{
          position: absolute;
          top: 12px;
          right: 12px;
          width: 40px;
          height: 40px;
          border-radius: 10px;
          border: 1px solid rgba(255,255,255,.12);
          background: rgba(255,255,255,.06);
          color: inherit;
          font-size: 24px;
          line-height: 1;
          cursor: pointer;
        }

        body:not([data-theme="dark"]) .pp-size-guide-close{
          border: 1px solid rgba(0,0,0,.10);
          background: rgba(0,0,0,.03);
        }

        .pp-size-guide-text,
        .pp-size-guide-note{
          opacity: .9;
          margin-top: 10px;
        }

        .pp-size-guide-table-wrap{
          overflow-x: auto;
          margin-top: 16px;
          border-radius: 14px;
        }

        .pp-size-guide-table{
          width: 100%;
          border-collapse: collapse;
          min-width: 520px;
        }

        .pp-size-guide-table th,
        .pp-size-guide-table td{
          text-align: left;
          padding: 14px 16px;
          border-bottom: 1px solid rgba(255,255,255,.10);
        }

        body:not([data-theme="dark"]) .pp-size-guide-table th,
        body:not([data-theme="dark"]) .pp-size-guide-table td{
          border-bottom: 1px solid rgba(0,0,0,.08);
        }

        .pp-size-guide-table th{
          color: #ff8c00;
          font-weight: 800;
        }

        .pp-nutrition{
          margin-top: 12px;
        }

        .pp-nutrition p{
          margin: 0 0 10px;
        }

        .pp-nutrition-table-wrap{
          overflow-x: auto;
          margin-top: 14px;
          border-radius: 14px;
        }

        .pp-nutrition-table{
          width: 100%;
          border-collapse: collapse;
          min-width: 520px;
        }

        .pp-nutrition-table th,
        .pp-nutrition-table td{
          text-align: left;
          padding: 14px 16px;
          border-bottom: 1px solid rgba(255,255,255,.10);
        }

        body:not([data-theme="dark"]) .pp-nutrition-table th,
        body:not([data-theme="dark"]) .pp-nutrition-table td{
          border-bottom: 1px solid rgba(0,0,0,.08);
        }

        .pp-nutrition-table th{
          color: #ff8c00;
          font-weight: 800;
        }

        .pp-demo-note{
          color: #ffb15c;
          font-size: .95rem;
        }

        .pp-faq h4{
          margin: 0 0 8px;
          font-size: 1.05rem;
        }

        .pp-faq p{
          margin: 0 0 18px;
          opacity: .92;
        }

        .pp-faq p:last-child{
          margin-bottom: 0;
        }
      </style>

      <div
        class="pp-gal"
        data-pp-gal
        data-main-src="{{ asset($mainImgPath) }}"
        data-is-whey="{{ $isWheyProtein ? '1' : '0' }}"
        data-is-creatine="{{ $isCreatine ? '1' : '0' }}"
        data-is-preworkout="{{ $isPreWorkout ? '1' : '0' }}"
        data-is-bcaa="{{ $isBcaa ? '1' : '0' }}"
        data-is-clothing="{{ $isClothing ? '1' : '0' }}"
        data-is-equipment="{{ $isEquipment ? '1' : '0' }}"
        data-default-flavour="{{ $defaultFlavourKey }}"
        data-flavour-images='@json($activeFlavours)'
      >
        <div class="pp-gal-frame">
          <button type="button" class="pp-gal-nav pp-gal-prev" data-pp-gal-prev aria-label="Previous image">‹</button>

          <div class="pp-gal-viewport" data-pp-gal-viewport>
            <div class="pp-gal-track" data-pp-gal-track></div>
          </div>

          <button type="button" class="pp-gal-nav pp-gal-next" data-pp-gal-next aria-label="Next image">›</button>

          <div class="pp-gal-dots" data-pp-gal-dots aria-label="Gallery dots"></div>
        </div>

        <div class="pp-gal-thumbs" data-pp-gal-thumbs aria-label="Gallery thumbnails"></div>
      </div>

    </section>

    <aside class="pp-pdp-right">
      <h1 class="pp-title">{{ $product->name }}</h1>
      <p class="pp-subtitle">
        @if ($isClothing)
          Clothing
        @elseif ($isEquipment)
          Equipment
        @elseif ($product->category === 'meal')
          Meal Prep Plan
        @elseif ($product->category === 'drink')
          Drink
        @else
          Supplement
        @endif
      </p>

      <div class="pp-rating">
        <span class="pp-stars">
          @for ($i = 1; $i <= 5; $i++)
            {{ $i <= $roundedStars ? '★' : '☆' }}
          @endfor
        </span>

        @if ($reviewCount)
          <span class="pp-rating-text">{{ number_format($avg, 1) }} ({{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }})</span>
        @else
          <span class="pp-rating-text">No reviews yet</span>
        @endif
      </div>

      <div class="pp-price-row">
        <div class="pp-price">
          <span
            data-money-gbp="{{ $product->price }}"
            data-money-suffix="{{ $product->category === 'meal' ? ' / week' : '' }}"
          >£{{ number_format($product->price, 2) }}{{ $product->category === 'meal' ? ' / week' : '' }}</span>
        </div>
        <div class="pp-stock">
          @if (isset($product->stock) && $product->stock <= 0)
            Out of stock
          @elseif (isset($product->stock) && isset($product->low_stock_threshold) && $product->stock <= $product->low_stock_threshold)
            Low stock
          @else
            In stock
          @endif
        </div>
      </div>

      <ul class="pp-benefits">
        @if ($isClothing)
          <li>Comfortable training fit</li>
          <li>Designed for gym and casual wear</li>
          <li>Signature PrepPal branding</li>
        @elseif ($isEquipment)
          <li>Built for regular gym use</li>
          <li>Performance-focused PrepPal design</li>
          <li>Practical training essential</li>
        @elseif ($product->category === 'meal')
          <li>14 chef-prepared meals included</li>
          <li>Choose your protein, carb, and add-ons</li>
          <li>Pause or cancel anytime</li>
        @else
          <li>Pairs well with your meal plan</li>
          <li>Routine-friendly dosing</li>
          <li>Great value per serving</li>
        @endif
      </ul>

      @if ($isMeal && $mealPlan)
        <div class="pp-meal-builder" style="
          margin: 1.1rem 0 1.2rem;
          border: 1px solid rgba(255,255,255,0.08);
          border-radius: 18px;
          padding: 1rem;
          background: rgba(255,255,255,0.03);
        ">
          <div style="margin-bottom: 0.9rem;">
            <div style="display:flex; justify-content:space-between; gap:1rem; flex-wrap:wrap; align-items:center;">
              <h3 style="margin:0; font-size:1.05rem; color:#ff8c00;">Build your meal plan</h3>
              <span style="
                display:inline-block;
                padding:0.35rem 0.7rem;
                border-radius:999px;
                background:rgba(255,140,0,.14);
                color:#ff9a1f;
                font-weight:700;
                font-size:0.85rem;
              ">
                {{ $mealPlan['goal'] }}
              </span>
            </div>

            <p style="margin:0.7rem 0 0; opacity:0.92;">{{ $mealPlan['overview'] }}</p>
          </div>

          <div style="
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(210px, 1fr));
            gap:0.85rem;
            margin-bottom:1rem;
          ">
            <div>
              <label for="ppMealProtein" class="pp-option-label">Protein</label>
              <select id="ppMealProtein" class="pp-option-select">
                @foreach($mealPlan['protein_options'] as $key => $label)
                  <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
              </select>
            </div>

            <div>
              <label for="ppMealCarb" class="pp-option-label">Carb / base</label>
              <select id="ppMealCarb" class="pp-option-select">
                @foreach($mealPlan['carb_options'] as $key => $label)
                  <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
              </select>
            </div>

            <div>
              <label for="ppMealSnack" class="pp-option-label">Snack add-on</label>
              <select id="ppMealSnack" class="pp-option-select">
                @foreach($mealPlan['snack_options'] as $key => $label)
                  <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
              </select>
            </div>

            <div>
              <label for="ppMealDelivery" class="pp-option-label">Plan size</label>
              <select id="ppMealDelivery" class="pp-option-select">
                @foreach($mealPlan['delivery_options'] as $key => $label)
                  <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div style="
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));
            gap:0.9rem;
            margin-bottom:1rem;
          ">
            <div style="
              border:1px solid rgba(255,255,255,.08);
              border-radius:14px;
              padding:0.9rem 1rem;
              background:rgba(0,0,0,.12);
            ">
              <p style="margin:0 0 .55rem; font-weight:700; color:#ff8c00;">What’s included</p>
              <ul style="margin:0; padding-left:1rem;">
                @foreach($mealPlan['included'] as $item)
                  <li style="margin-bottom:0.35rem;">{{ $item }}</li>
                @endforeach
              </ul>
            </div>

            <div style="
              border:1px solid rgba(255,255,255,.08);
              border-radius:14px;
              padding:0.9rem 1rem;
              background:rgba(0,0,0,.12);
            ">
              <p style="margin:0 0 .55rem; font-weight:700; color:#ff8c00;">Example meals</p>
              <ul style="margin:0; padding-left:1rem;">
                @foreach($mealPlan['example_meals'] as $mealExample)
                  <li style="margin-bottom:0.35rem;">{{ $mealExample }}</li>
                @endforeach
              </ul>
            </div>
          </div>

          <div style="
            border:1px solid rgba(255,140,0,.18);
            border-radius:14px;
            padding:0.85rem 1rem;
            background:rgba(255,140,0,.08);
          ">
            <p style="margin:0 0 .4rem; font-weight:800; color:#ffb15c;">Your selected plan</p>
            <p id="ppMealSummary" style="margin:0; color:#fff;">
              {{ $product->name }} — {{ $mealPlan['delivery_options'][$defaultMealDeliveryKey] ?? '' }}, {{ $mealPlan['protein_options'][$defaultMealProteinKey] ?? '' }}, {{ $mealPlan['carb_options'][$defaultMealCarbKey] ?? '' }}, {{ $mealPlan['snack_options'][$defaultMealSnackKey] ?? '' }}
            </p>
          </div>
        </div>
      @endif

      @if ($isWheyProtein || $isCreatine || $isPreWorkout || $isBcaa)
        <div class="pp-option-group">
          <label for="ppFlavourSelect" class="pp-option-label">Flavour:</label>
          <select id="ppFlavourSelect" class="pp-option-select">
            @foreach($activeFlavours as $key => $flavour)
              <option value="{{ $key }}" {{ $key === $defaultFlavourKey ? 'selected' : '' }}>
                {{ $flavour['label'] }}
              </option>
            @endforeach
          </select>
          <div class="pp-selected-flavour" id="ppSelectedFlavour">
            Selected flavour: {{ $defaultFlavourKey && isset($activeFlavours[$defaultFlavourKey]) ? $activeFlavours[$defaultFlavourKey]['label'] : 'None' }}
          </div>
        </div>
      @endif

      @if ($isClothing && count($activeFlavours))
        <div class="pp-option-group">
          <label for="ppSizeSelect" class="pp-option-label">Size:</label>
          <select id="ppSizeSelect" class="pp-option-select">
            @foreach($activeFlavours as $key => $variant)
              <option value="{{ $key }}" {{ $key === $defaultFlavourKey ? 'selected' : '' }}>
                {{ $variant['label'] }}
              </option>
            @endforeach
          </select>

          <div class="pp-selected-flavour" id="ppSelectedSize">
            Selected size: {{ $defaultFlavourKey && isset($activeFlavours[$defaultFlavourKey]) ? $activeFlavours[$defaultFlavourKey]['label'] : 'None' }}
          </div>

          <button type="button" class="pp-size-guide-btn" id="ppSizeGuideOpen">
            View size guide
          </button>
        </div>
      @endif

      <div class="pp-actions">
        <div class="pp-qty">
          <button type="button" class="pp-qty-btn" data-qty="-1" aria-label="Decrease quantity">−</button>
          <input class="pp-qty-input" type="number" min="1" value="1">
          <button type="button" class="pp-qty-btn" data-qty="+1" aria-label="Increase quantity">+</button>
        </div>

        <button
          type="button"
          class="cta pp-add add-to-cart"
          data-id="{{ $product->id }}"
          data-name="@if ($isMeal && $mealPlan){{ $product->name }} - {{ $mealPlan['delivery_options'][$defaultMealDeliveryKey] ?? '' }} / {{ $mealPlan['protein_options'][$defaultMealProteinKey] ?? '' }} / {{ $mealPlan['carb_options'][$defaultMealCarbKey] ?? '' }} / {{ $mealPlan['snack_options'][$defaultMealSnackKey] ?? '' }}@elseif (count($activeFlavours) && $defaultFlavourKey && isset($activeFlavours[$defaultFlavourKey])){{ $activeFlavours[$defaultFlavourKey]['cart_name'] }}@else{{ $product->name }}@endif"
          data-base-name="{{ $product->name }}"
          data-price="{{ $product->price }}"
          data-image="{{ count($activeFlavours) && $defaultFlavourKey && isset($activeFlavours[$defaultFlavourKey]) ? $activeFlavours[$defaultFlavourKey]['image'] : asset($product->image_path) }}"
          data-qty="1"
          data-variant="@if ($isMeal && $mealPlan){{ ($mealPlan['delivery_options'][$defaultMealDeliveryKey] ?? '') . ' | ' . ($mealPlan['protein_options'][$defaultMealProteinKey] ?? '') . ' | ' . ($mealPlan['carb_options'][$defaultMealCarbKey] ?? '') . ' | ' . ($mealPlan['snack_options'][$defaultMealSnackKey] ?? '') }}@elseif (count($activeFlavours) && $defaultFlavourKey && isset($activeFlavours[$defaultFlavourKey])){{ $activeFlavours[$defaultFlavourKey]['label'] }}@endif"
          @if (isset($product->stock) && $product->stock <= 0) disabled @endif
        >
          @if (isset($product->stock) && $product->stock <= 0)
            Out of stock
          @else
            Add to cart
          @endif
        </button>
      </div>

      <div class="pp-trust">
        <div class="pp-trust-item">✅ Quality checked</div>
        <div class="pp-trust-item">🚚 Fast UK delivery</div>
        <div class="pp-trust-item">🔒 Secure checkout</div>
      </div>

      <div class="pp-ship">
        <div class="pp-ship-row"><span>🚚</span> <strong>Delivery:</strong>&nbsp;2–4 working days (UK)</div>
        <div class="pp-ship-row"><span>↩️</span> <strong>Returns:</strong>&nbsp;14-day returns on unopened items</div>
      </div>

      <div class="pp-accordion">
        <details open>
          <summary>Description</summary>
          <p>{{ $content['description'] }}</p>
        </details>

        @if (!str_starts_with((string) $product->id, 'clothing-'))
          <details>
            <summary>Write a Review</summary>

            @if (session('success'))
              <p style="color: green; margin: 10px 0;">
                {{ session('success') }}
              </p>
            @endif

            <form method="POST" action="/products/{{ $product->id }}/reviews" class="pp-review-form">
              @csrf

              <div class="pp-review-field">
                <label>Rating</label>
                <select name="rating" required>
                  <option value="5">⭐⭐⭐⭐⭐</option>
                  <option value="4">⭐⭐⭐⭐</option>
                  <option value="3">⭐⭐⭐</option>
                  <option value="2">⭐⭐</option>
                  <option value="1">⭐</option>
                </select>
              </div>

              <div class="pp-review-field">
                <textarea name="comment" placeholder="Write your review (optional)"></textarea>
              </div>

              <button type="submit" class="cta pp-review-submit">
                Submit Review
              </button>
            </form>
          </details>
        @endif

        <section class="pp-reviews">
          <h3 class="pp-reviews-title">
            Customer Reviews ({{ $reviewCount }})
          </h3>

          @if ($product->reviews->isEmpty())
            <p class="pp-no-reviews">
              No reviews yet. Be the first to review this product.
            </p>
          @else
            @foreach ($product->reviews as $review)
              <article class="pp-review-card">
                <div class="pp-review-header">
                  <strong class="pp-review-user">
                    {{ $review->user->name ?? 'Customer' }}
                  </strong>

                  <span class="pp-review-stars">
                    @for ($i = 1; $i <= 5; $i++)
                      {{ $i <= $review->rating ? '★' : '☆' }}
                    @endfor
                  </span>
                </div>

                @if ($review->comment)
                  <p class="pp-review-comment">
                    {{ $review->comment }}
                  </p>
                @endif

                <div class="pp-review-meta">
                  Reviewed {{ optional($review->created_at)->diffForHumans() ?? 'recently' }}
                </div>

                @if (auth()->id() === ($review->user_id ?? null))
                  <div class="pp-review-actions">
                    <a href="{{ route('reviews.edit', $review->id) }}" class="pp-review-edit">Edit</a>

                    <span>·</span>
                    <form method="POST" action="{{ route('reviews.destroy', $review->id) }}" class="pp-review-delete">
                      @csrf
                      @method('DELETE')
                      <button type="submit">Delete</button>
                    </form>
                  </div>
                @endif
              </article>
            @endforeach
          @endif
        </section>

        <details>
          <summary>How to use</summary>
          <p>{{ $content['how_to_use'] }}</p>
        </details>

        @if ($isWheyProtein)
          <details>
            <summary>Nutritional Information</summary>

            <div class="pp-nutrition">
              <p><strong>Serving Size:</strong> 30g</p>
              <p><strong>Protein Per Serving:</strong> 25g</p>
              <p><strong>Suitable for all flavours:</strong> Vanilla, Banana, Coffee, Chocolate, Peanut Butter</p>

              <div class="pp-nutrition-table-wrap">
                <table class="pp-nutrition-table">
                  <thead>
                    <tr>
                      <th>Typical Values</th>
                      <th>Per 100g</th>
                      <th>Per 30g</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>Energy</td><td>1597kJ</td><td>479kJ</td></tr>
                    <tr><td>Energy</td><td>378kcal</td><td>113kcal</td></tr>
                    <tr><td>Fat</td><td>6.0g</td><td>1.8g</td></tr>
                    <tr><td>of which saturates</td><td>3.7g</td><td>1.1g</td></tr>
                    <tr><td>Carbohydrate</td><td>7.5g</td><td>2.2g</td></tr>
                    <tr><td>of which sugars</td><td>5.1g</td><td>1.5g</td></tr>
                    <tr><td>Protein</td><td>83.3g</td><td>25g</td></tr>
                    <tr><td>Salt</td><td>0.46g</td><td>0.14g</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </details>
        @endif

        @if ($isCreatine)
          <details>
            <summary>Nutritional Information</summary>

            <div class="pp-nutrition">
              <p><strong>Serving Size:</strong> 5g</p>
              <p><strong>Creatine Per Serving:</strong> 4.5g</p>
              <p><strong>Suitable for all flavours:</strong> Cool Blue, Berry, Lime, Melon</p>

              <div class="pp-nutrition-table-wrap">
                <table class="pp-nutrition-table">
                  <thead>
                    <tr>
                      <th>Typical Values</th>
                      <th>Per 100g</th>
                      <th>Per 5g</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>Energy</td><td>1540kJ</td><td>77kJ</td></tr>
                    <tr><td>Energy</td><td>362kcal</td><td>18kcal</td></tr>
                    <tr><td>Fat</td><td>0.2g</td><td>0.0g</td></tr>
                    <tr><td>of which saturates</td><td>0.1g</td><td>0.0g</td></tr>
                    <tr><td>Carbohydrate</td><td>3.0g</td><td>0.2g</td></tr>
                    <tr><td>of which sugars</td><td>1.0g</td><td>0.1g</td></tr>
                    <tr><td>Protein</td><td>0.0g</td><td>0.0g</td></tr>
                    <tr><td>Salt</td><td>0.10g</td><td>0.01g</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </details>
        @endif

        @if ($isPreWorkout)
          <details>
            <summary>Nutritional Information</summary>

            <div class="pp-nutrition">
              <p><strong>Serving Size:</strong> 20g</p>
              <p><strong>Active Blend Per Serving:</strong> 15g</p>
              <p><strong>Caffeine Per Serving:</strong> 220mg</p>
              <p><strong>Suitable for all flavours:</strong> Grape, Pineapple, Lemon, Mango</p>

              <div class="pp-nutrition-table-wrap">
                <table class="pp-nutrition-table">
                  <thead>
                    <tr>
                      <th>Typical Values</th>
                      <th>Per 100g</th>
                      <th>Per 20g</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>Energy</td><td>1480kJ</td><td>296kJ</td></tr>
                    <tr><td>Energy</td><td>350kcal</td><td>70kcal</td></tr>
                    <tr><td>Fat</td><td>0.5g</td><td>0.1g</td></tr>
                    <tr><td>of which saturates</td><td>0.1g</td><td>0.0g</td></tr>
                    <tr><td>Carbohydrate</td><td>12.0g</td><td>2.4g</td></tr>
                    <tr><td>of which sugars</td><td>4.0g</td><td>0.8g</td></tr>
                    <tr><td>Protein</td><td>5.0g</td><td>1.0g</td></tr>
                    <tr><td>Salt</td><td>0.60g</td><td>0.12g</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </details>
        @endif

        @if ($isBcaa)
          <details>
            <summary>Nutritional Information</summary>

            <div class="pp-nutrition">
              <p><strong>Serving Size:</strong> 12g</p>
              <p><strong>BCAAs Per Serving:</strong> 7g</p>
              <p><strong>Suitable for all flavours:</strong> Fruit Punch, Blueberry</p>

              <div class="pp-nutrition-table-wrap">
                <table class="pp-nutrition-table">
                  <thead>
                    <tr>
                      <th>Typical Values</th>
                      <th>Per 100g</th>
                      <th>Per 12g</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>Energy</td><td>1420kJ</td><td>170kJ</td></tr>
                    <tr><td>Energy</td><td>335kcal</td><td>40kcal</td></tr>
                    <tr><td>Fat</td><td>0.1g</td><td>0.0g</td></tr>
                    <tr><td>of which saturates</td><td>0.0g</td><td>0.0g</td></tr>
                    <tr><td>Carbohydrate</td><td>8.0g</td><td>1.0g</td></tr>
                    <tr><td>of which sugars</td><td>2.0g</td><td>0.2g</td></tr>
                    <tr><td>Protein</td><td>58.0g</td><td>7.0g</td></tr>
                    <tr><td>Salt</td><td>0.20g</td><td>0.02g</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </details>
        @endif

        @if ($isMultivitamin)
          <details>
            <summary>Nutritional Information</summary>

            <div class="pp-nutrition">
              <p><strong>Serving Size:</strong> 1 tablet</p>
              <p><strong>Servings Per Container:</strong> 60</p>

              <div class="pp-nutrition-table-wrap">
                <table class="pp-nutrition-table">
                  <thead>
                    <tr>
                      <th>Nutrient</th>
                      <th>Per Tablet</th>
                      <th>% NRV</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>Vitamin A</td><td>800µg</td><td>100%</td></tr>
                    <tr><td>Vitamin D</td><td>5µg</td><td>100%</td></tr>
                    <tr><td>Vitamin E</td><td>12mg</td><td>100%</td></tr>
                    <tr><td>Vitamin C</td><td>80mg</td><td>100%</td></tr>
                    <tr><td>Thiamin (B1)</td><td>1.1mg</td><td>100%</td></tr>
                    <tr><td>Riboflavin (B2)</td><td>1.4mg</td><td>100%</td></tr>
                    <tr><td>Niacin</td><td>16mg</td><td>100%</td></tr>
                    <tr><td>Vitamin B6</td><td>1.4mg</td><td>100%</td></tr>
                    <tr><td>Folic Acid</td><td>200µg</td><td>100%</td></tr>
                    <tr><td>Vitamin B12</td><td>2.5µg</td><td>100%</td></tr>
                    <tr><td>Biotin</td><td>50µg</td><td>100%</td></tr>
                    <tr><td>Pantothenic Acid</td><td>6mg</td><td>100%</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </details>
        @endif

        <details>
          <summary>FAQs</summary>
          <div class="pp-faq">
            @foreach($content['faqs'] as $faq)
              <h4>{{ $faq['q'] }}</h4>
              <p>{{ $faq['a'] }}</p>
            @endforeach
          </div>
        </details>
      </div>
    </aside>

  </div>

  @if ($isClothing)
    <div class="pp-size-guide-modal" id="ppSizeGuideModal" aria-hidden="true">
      <div class="pp-size-guide-backdrop" data-size-guide-close></div>

      <div class="pp-size-guide-panel" role="dialog" aria-modal="true" aria-labelledby="ppSizeGuideTitle">
        <button type="button" class="pp-size-guide-close" id="ppSizeGuideClose" aria-label="Close size guide">
          ×
        </button>

        <h3 id="ppSizeGuideTitle">Size Guide</h3>
        <p class="pp-size-guide-text">
          Use this as a general guide for fit. If you prefer an oversized fit, go one size up.
        </p>

        <div class="pp-size-guide-table-wrap">
          <table class="pp-size-guide-table">
            <thead>
              <tr>
                <th>Size</th>
                <th>Chest</th>
                <th>Waist</th>
                <th>UK Fit</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Small</td>
                <td>34–36"</td>
                <td>28–30"</td>
                <td>S</td>
              </tr>
              <tr>
                <td>Medium</td>
                <td>38–40"</td>
                <td>30–32"</td>
                <td>M</td>
              </tr>
              <tr>
                <td>Large</td>
                <td>42–44"</td>
                <td>34–36"</td>
                <td>L</td>
              </tr>
              <tr>
                <td>XL</td>
                <td>46–48"</td>
                <td>38–40"</td>
                <td>XL</td>
              </tr>
            </tbody>
          </table>
        </div>

        <p class="pp-size-guide-note">
          For leggings, shorts, joggers, and fitted sets, use waist as the main reference. For tanks and hoodies, use chest as the main reference.
        </p>
      </div>
    </div>
  @endif
</main>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const GALLERY_BY_MAIN = {
      "whey_protein.png": [
        "/images/whey_protein.png",
        "/images/whey_protein2.png",
        "/images/whey_protien3.png"
      ],
      "creatine_monohydrate.jpg": [
        "/images/creatine_monohydrate.jpg",
        "/images/creatine_monohydrate2.png",
        "/images/creatine_monohydrate-3.png"
      ],
      "creatine_monohydrate2.png": [
        "/images/creatine_monohydrate.jpg",
        "/images/creatine_monohydrate2.png",
        "/images/creatine_monohydrate-3.png"
      ],
      "creatine_monohydrate-3.png": [
        "/images/creatine_monohydrate.jpg",
        "/images/creatine_monohydrate2.png",
        "/images/creatine_monohydrate-3.png"
      ],
      "bcaa_powder.jpg": ["/images/bcaa_powder.jpg"],
      "multivitimins.jpg": ["/images/multivitimins.jpg"],
      "fat_loss_plan.png": ["/images/fat_loss_plan.png"],
      "lean_muscle_plan.jpg": ["/images/lean_muscle_plan.jpg"],
      "maintainance_plan.jpg": ["/images/maintainance_plan.jpg"],
      "high_fibre_plan.jpg": ["/images/high_fibre_plan.jpg"],
      "tanktop.png": ["/images/tanktop.png"],
      "shortsfront.png": ["/images/shortsfront.png", "/images/shortsback.png"],
      "shortsback.png": ["/images/shortsfront.png", "/images/shortsback.png"],
      "zipfront.png": ["/images/zipfront.png", "/images/zipback.png"],
      "zipback.png": ["/images/zipfront.png", "/images/zipback.png"],
      "pants.png": ["/images/pants.png"],
      "gymgirlset.png": ["/images/gymgirlset.png"],
      "shaker1.png": ["/images/shaker1.png", "/images/shaker2.png"],
      "shaker2.png": ["/images/shaker1.png", "/images/shaker2.png"],
      "belt1.png": ["/images/belt1.png", "/images/belt2.png"],
      "belt2.png": ["/images/belt1.png", "/images/belt2.png"],
      "wraps1.png": ["/images/wraps1.png", "/images/wraps2.png"],
      "wraps2.png": ["/images/wraps1.png", "/images/wraps2.png"],
      "chalk.png": ["/images/chalk.png"],
      "straps1.png": ["/images/straps1.png", "/images/straps2.png"],
      "straps2.png": ["/images/straps1.png", "/images/straps2.png"]
    };

    function uniq(arr) {
      const s = new Set();
      return arr.filter(x => {
        const k = String(x || '').trim();
        if (!k || s.has(k)) return false;
        s.add(k);
        return true;
      });
    }

    function fileFromUrl(u) {
      const clean = String(u || '').split('?')[0];
      return clean.split('/').pop();
    }

    document.querySelectorAll('[data-pp-gal]').forEach(root => {
      const mainSrc = root.getAttribute('data-main-src') || '';
      const isWhey = root.getAttribute('data-is-whey') === '1';
      const isCreatine = root.getAttribute('data-is-creatine') === '1';
      const isPreWorkout = root.getAttribute('data-is-preworkout') === '1';
      const isBcaa = root.getAttribute('data-is-bcaa') === '1';
      const isClothing = root.getAttribute('data-is-clothing') === '1';
      const isEquipment = root.getAttribute('data-is-equipment') === '1';
      const usesVariantGallery = isWhey || isCreatine || isPreWorkout || isBcaa || isClothing || isEquipment;
      const defaultVariant = root.getAttribute('data-default-flavour') || '';

      let flavourConfig = {};
      try {
        flavourConfig = JSON.parse(root.getAttribute('data-flavour-images') || '{}');
      } catch (e) {
        flavourConfig = {};
      }

      const track = root.querySelector('[data-pp-gal-track]');
      const thumbs = root.querySelector('[data-pp-gal-thumbs]');
      const dots = root.querySelector('[data-pp-gal-dots]');
      const prevBtn = root.querySelector('[data-pp-gal-prev]');
      const nextBtn = root.querySelector('[data-pp-gal-next]');
      const viewport = root.querySelector('[data-pp-gal-viewport]');

      if (!track || !viewport || !thumbs || !dots) return;

      let imgs = [];
      let index = 0;
      let paused = false;
      let timer = null;

      function currentImagesForVariant(variantKey) {
        if (usesVariantGallery && variantKey && flavourConfig[variantKey]) {
          if (Array.isArray(flavourConfig[variantKey].gallery) && flavourConfig[variantKey].gallery.length) {
            return uniq(flavourConfig[variantKey].gallery);
          }

          if (flavourConfig[variantKey].image) {
            return [flavourConfig[variantKey].image];
          }
        }

        const mainFile = fileFromUrl(mainSrc);
        return uniq((GALLERY_BY_MAIN[mainFile] || [mainSrc]));
      }

      function setActiveUI() {
        thumbs.querySelectorAll('.pp-gal-thumb').forEach((b, i) => b.classList.toggle('is-active', i === index));
        dots.querySelectorAll('.pp-gal-dot').forEach((d, i) => d.classList.toggle('is-active', i === index));

        const single = imgs.length <= 1;
        if (prevBtn) prevBtn.style.display = single ? 'none' : '';
        if (nextBtn) nextBtn.style.display = single ? 'none' : '';
        dots.style.display = single ? 'none' : '';
      }

      function render() {
        track.style.transform = `translateX(${-index * 100}%)`;
        setActiveUI();
      }

      function go(i) {
        const max = imgs.length - 1;
        index = Math.max(0, Math.min(max, i));
        render();
      }

      function next() {
        go(index >= imgs.length - 1 ? 0 : index + 1);
      }

      function prev() {
        go(index <= 0 ? imgs.length - 1 : index - 1);
      }

      function buildGallery(newImages) {
        imgs = uniq(newImages);
        index = 0;

        track.innerHTML = imgs.map(src => `
          <div class="pp-gal-slide">
            <img class="pp-gal-img" src="${src}" alt="Product image">
          </div>
        `).join('');

        thumbs.innerHTML = imgs.map((src, i) => `
          <button type="button" class="pp-gal-thumb ${i === 0 ? 'is-active' : ''}" data-go="${i}">
            <img src="${src}" alt="Thumb ${i + 1}">
          </button>
        `).join('');

        dots.innerHTML = imgs.length > 1 ? imgs.map((_, i) => `
          <span class="pp-gal-dot ${i === 0 ? 'is-active' : ''}" data-dot="${i}"></span>
        `).join('') : '';

        render();
      }

      prevBtn?.addEventListener('click', () => {
        paused = true;
        prev();
      });

      nextBtn?.addEventListener('click', () => {
        paused = true;
        next();
      });

      thumbs.addEventListener('click', (e) => {
        const b = e.target.closest('[data-go]');
        if (!b) return;
        paused = true;
        go(parseInt(b.dataset.go, 10) || 0);
      });

      root.addEventListener('mouseenter', () => paused = true);
      root.addEventListener('mouseleave', () => paused = false);

      let sx = 0;
      let sy = 0;
      let down = false;

      viewport.addEventListener('touchstart', (ev) => {
        const t = ev.touches[0];
        sx = t.clientX;
        sy = t.clientY;
        down = true;
        paused = true;
      }, { passive: true });

      viewport.addEventListener('touchend', (ev) => {
        if (!down) return;
        down = false;
        const t = ev.changedTouches[0];
        const dx = t.clientX - sx;
        const dy = t.clientY - sy;
        if (Math.abs(dy) > Math.abs(dx)) return;
        if (dx > 40) prev();
        if (dx < -40) next();
      }, { passive: true });

      function start() {
        stop();
        if (imgs.length <= 1) return;
        timer = setInterval(() => {
          if (!paused) next();
        }, 4000);
      }

      function stop() {
        if (timer) clearInterval(timer);
        timer = null;
      }

      buildGallery(currentImagesForVariant(defaultVariant));
      start();
      window.addEventListener('beforeunload', stop);

      const flavourSelect = document.getElementById('ppFlavourSelect');
      const selectedFlavourText = document.getElementById('ppSelectedFlavour');
      const sizeSelect = document.getElementById('ppSizeSelect');
      const selectedSizeText = document.getElementById('ppSelectedSize');
      const addBtn = document.querySelector('.pp-add.add-to-cart');

      function applyVariant(variantKey, selectedTextEl, selectedPrefix) {
        const variant = flavourConfig[variantKey];
        if (!variant || !addBtn) return;

        addBtn.dataset.variant = variant.label;
        addBtn.dataset.name = variant.cart_name;
        addBtn.dataset.image = variant.image;

        if (selectedTextEl) {
          selectedTextEl.textContent = `${selectedPrefix}: ${variant.label}`;
        }

        stop();
        buildGallery(currentImagesForVariant(variantKey));
        start();
      }

      if ((isWhey || isCreatine || isPreWorkout || isBcaa) && flavourSelect) {
        flavourSelect.addEventListener('change', () => {
          applyVariant(flavourSelect.value, selectedFlavourText, 'Selected flavour');
        });

        applyVariant(flavourSelect.value, selectedFlavourText, 'Selected flavour');
      }

      if (isClothing && sizeSelect) {
        sizeSelect.addEventListener('change', () => {
          applyVariant(sizeSelect.value, selectedSizeText, 'Selected size');
        });

        applyVariant(sizeSelect.value, selectedSizeText, 'Selected size');
      }

      if (isEquipment && defaultVariant) {
        applyVariant(defaultVariant, null, '');
      }
    });

    const qtyWrap = document.querySelector('.pp-qty');
    const qtyInput = document.querySelector('.pp-qty-input');
    const addBtn = document.querySelector('.pp-add.add-to-cart');
    const mealProteinSelect = document.getElementById('ppMealProtein');
    const mealCarbSelect = document.getElementById('ppMealCarb');
    const mealSnackSelect = document.getElementById('ppMealSnack');
    const mealDeliverySelect = document.getElementById('ppMealDelivery');
    const mealSummary = document.getElementById('ppMealSummary');

    function syncMealPlanSelection() {
      if (!addBtn || !mealProteinSelect || !mealCarbSelect || !mealSnackSelect || !mealDeliverySelect) return;

      const proteinLabel = mealProteinSelect.options[mealProteinSelect.selectedIndex]?.text || '';
      const carbLabel = mealCarbSelect.options[mealCarbSelect.selectedIndex]?.text || '';
      const snackLabel = mealSnackSelect.options[mealSnackSelect.selectedIndex]?.text || '';
      const deliveryLabel = mealDeliverySelect.options[mealDeliverySelect.selectedIndex]?.text || '';
      const baseName = addBtn.dataset.baseName || addBtn.dataset.name || 'Meal Plan';

      const variantText = `${deliveryLabel} | ${proteinLabel} | ${carbLabel} | ${snackLabel}`;
      const cartName = `${baseName} - ${deliveryLabel} / ${proteinLabel} / ${carbLabel} / ${snackLabel}`;

      addBtn.dataset.variant = variantText;
      addBtn.dataset.name = cartName;

      if (mealSummary) {
        mealSummary.textContent = `${baseName} — ${deliveryLabel}, ${proteinLabel}, ${carbLabel}, ${snackLabel}`;
      }
    }

    [mealProteinSelect, mealCarbSelect, mealSnackSelect, mealDeliverySelect].forEach(select => {
      select?.addEventListener('change', syncMealPlanSelection);
    });

    syncMealPlanSelection();

    if (qtyWrap && qtyInput && addBtn && !addBtn.disabled) {
      const clampQty = (n) => {
        const v = Number.isFinite(n) ? n : 1;
        return Math.max(1, Math.floor(v));
      };

      const sync = () => {
        addBtn.dataset.qty = String(clampQty(parseInt(qtyInput.value || '1', 10)));
      };

      qtyWrap.addEventListener('click', (e) => {
        const btn = e.target.closest('.pp-qty-btn');
        if (!btn) return;

        const delta = btn.dataset.qty === '+1' ? 1 : -1;
        const current = clampQty(parseInt(qtyInput.value || '1', 10));
        qtyInput.value = String(clampQty(current + delta));
        sync();
      });

      qtyInput.addEventListener('input', sync);
      qtyInput.addEventListener('change', sync);

      addBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();

        if (!window.Cart || typeof window.Cart.addItem !== 'function') return;

        const id = addBtn.dataset.id;
        const name = addBtn.dataset.name;
        const price = parseFloat(addBtn.dataset.price || '0') || 0;
        const image = addBtn.dataset.image || '';
        const qty = clampQty(parseInt(addBtn.dataset.qty || '1', 10));
        const variant = addBtn.dataset.variant || '';

        for (let i = 0; i < qty; i++) {
          window.Cart.addItem(id, name, price, image, { variant });
        }

        const cartDisplay = document.getElementById('cartDisplay');
        if (cartDisplay && window.Cart.getCount) {
          cartDisplay.textContent = `Cart (${window.Cart.getCount()})`;
        }

        window.dispatchEvent(new CustomEvent('pp:cartUpdated'));
      }, true);

      sync();
    }

    const sizeGuideModal = document.getElementById('ppSizeGuideModal');
    const sizeGuideOpen = document.getElementById('ppSizeGuideOpen');
    const sizeGuideClose = document.getElementById('ppSizeGuideClose');
    const sizeGuideBackdrop = document.querySelector('[data-size-guide-close]');

    if (sizeGuideModal && sizeGuideOpen) {
      const openSizeGuide = () => {
        sizeGuideModal.classList.add('is-open');
        sizeGuideModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
      };

      const closeSizeGuide = () => {
        sizeGuideModal.classList.remove('is-open');
        sizeGuideModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
      };

      sizeGuideOpen.addEventListener('click', openSizeGuide);
      sizeGuideClose?.addEventListener('click', closeSizeGuide);
      sizeGuideBackdrop?.addEventListener('click', closeSizeGuide);

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sizeGuideModal.classList.contains('is-open')) {
          closeSizeGuide();
        }
      });
    }
  });
</script>
@endsection
