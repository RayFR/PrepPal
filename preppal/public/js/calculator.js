/*
  Student & ID: (Agraj Khanna 240195519 ID / Gurpreet Singh Sidhu 230237915 ID)
  Description: Calculator Functionailty
*/

(function () {

    // Helpers
    function $(id) { return document.getElementById(id); }

    const form = $("calorieForm");
    const results = $("calorieResults");

    const ringCalories = $("ringCalories");
    const macroCalories = $("macroCalories");
    const macroProtein = $("macroProtein");
    const macroCarbs = $("macroCarbs");
    const macroFats = $("macroFats");
    const planOutput = $("caloriePlanOutput");
    const addBtn = $("recommendedPlanAdd");

    if (!form) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const age = parseFloat($("age").value);
        const height = parseFloat($("height").value);
        const weight = parseFloat($("weight").value);
        const sex = $("sex").value;
        const activity = $("activity").value;
        const goal = $("goal").value;

        // --- BMR calculation ---
        let bmr;
        if (sex === "male") {
            bmr = 10 * weight + 6.25 * height - 5 * age + 5;
        } else {
            bmr = 10 * weight + 6.25 * height - 5 * age - 161;
        }

        // --- Activity multiplier ---
        const levels = {
            sedentary: 1.2,
            light: 1.375,
            moderate: 1.55,
            very: 1.725
        };
        let calories = bmr * levels[activity];

        // --- Goals ---
        if (goal === "loss") calories -= 400;
        if (goal === "muscle") calories += 300;

        calories = Math.round(calories);

        // --- Macros ---
        const protein = Math.round(weight * 1.8);
        const fats = Math.round((calories * 0.25) / 9);
        const carbs = Math.round((calories - (protein * 4 + fats * 9)) / 4);

        // ---- UPDATE UI ----

        // Donut ring text
        ringCalories.textContent = calories;

        // Macro cards
        macroCalories.textContent = calories + " kcal";
        macroProtein.textContent = protein + " g";
        macroCarbs.textContent = carbs + " g";
        macroFats.textContent = fats + " g";

        // Explanation text
        $("calorieResultText").innerHTML =
            `For <strong>${goal === "loss" ? "fat loss" :
                           goal === "muscle" ? "muscle gain" :
                           goal === "maintain" ? "maintenance" :
                           "higher fibre"}</strong>, 
            your estimated daily target is around <strong>${calories} kcal</strong>.`;

        // Recommended plan
        let planName, planPrice, planImage;
        if (goal === "loss") {
            planName = "Fat Loss Meal Prep Plan";
            planPrice = "49.99";
            planImage = "/images/fat_loss_plan.png";
        } else if (goal === "muscle") {
            planName = "Lean Muscle Meal Prep Plan";
            planPrice = "59.99";
            planImage = "/images/lean_muscle_plan.jpg";
        } else if (goal === "maintain") {
            planName = "Maintenance Meal Prep Plan";
            planPrice = "54.99";
            planImage = "/images/maintainance_plan.jpg";
        } else {
            planName = "High Fibre Meal Prep Plan";
            planPrice = "52.99";
            planImage = "/images/high_fibre_plan.jpg";
        }

        planOutput.innerHTML =
            `<strong>Recommended PrepPal plan:</strong> ${planName}.`;

        addBtn.dataset.name = planName;
        addBtn.dataset.price = planPrice;
        addBtn.dataset.image = planImage;
        addBtn.style.display = "inline-block";

    });

})();
