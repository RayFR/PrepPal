/*
  Student & ID: (Agraj Khanna 240195519 ID / Gurpreet Singh Sidhu 230237915 ID)
  Description: Calculator Functionailty
*/


(function () {
  function $(id) { return document.getElementById(id); }
  function clamp(n, min, max) { return Math.max(min, Math.min(max, n)); }

  const form = $("calorieForm");
  if (!form) return;

  // Elements
  const results = $("calorieResults");
  const ringGraphic = document.querySelector(".ring-graphic");

  const ringCalories = $("ringCalories");
  const macroCalories = $("macroCalories");
  const macroProtein = $("macroProtein");
  const macroCarbs = $("macroCarbs");
  const macroFats = $("macroFats");

  const barProtein = $("barProtein");
  const barCarbs = $("barCarbs");
  const barFats = $("barFats");

  const resultText = $("calorieResultText");
  const statusPill = $("mfpStatus");

  const planOutput = $("caloriePlanOutput");
  const planRecoImage = $("planRecoImage");
  const planRecoPrice = $("planRecoPrice");
  const planRecoTag = $("planRecoTag");

  const addBtn = $("recommendedPlanAdd");

  // These exist in your HTML
  const ringSub = document.querySelector(".mfp-ring-sub");
  const ringTitle = document.querySelector(".mfp-ring-title");

  // -----------------------------
  // HARD FORCE HIDE BUTTON
  // -----------------------------
  function hardHideAddBtn() {
    if (!addBtn) return;
    addBtn.hidden = true;          // attribute
    addBtn.disabled = true;        // prevent clicks
    addBtn.style.display = "none"; // fallback if styles override hidden
  }

  function showAddBtn() {
    if (!addBtn) return;
    addBtn.hidden = false;
    addBtn.disabled = false;
    addBtn.style.display = ""; // let CSS take over
  }

  // Hide immediately and again when DOM is ready (covers load order issues)
  hardHideAddBtn();
  document.addEventListener("DOMContentLoaded", hardHideAddBtn);

  // If user changes inputs after calculating, hide until recalculated
  ["age", "sex", "height", "weight", "activity", "goal"].forEach((id) => {
    const el = $(id);
    if (!el) return;
    el.addEventListener("input", hardHideAddBtn);
    el.addEventListener("change", hardHideAddBtn);
  });

  // -----------------------------
  // Submit handler
  // -----------------------------
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const age = parseFloat($("age")?.value);
    const height = parseFloat($("height")?.value);
    const weight = parseFloat($("weight")?.value);
    const sex = $("sex")?.value;
    const activity = $("activity")?.value;
    const goal = $("goal")?.value;

    // Validation
    if (![age, height, weight].every((v) => Number.isFinite(v)) || !sex || !activity || !goal) {
      if (resultText) resultText.textContent = "Please fill in all fields before calculating.";
      if (statusPill) statusPill.textContent = "Ready";
      if (ringCalories) ringCalories.textContent = "0";
      if (ringSub) ringSub.textContent = "Shown as % of your maintenance (fill in details)";
      if (ringTitle) ringTitle.textContent = "Daily calories";
      hardHideAddBtn();
      return;
    }

    // --- BMR (Mifflin–St Jeor) ---
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

    const activityMult = levels[activity] ?? 1.2;

    // Maintenance calories (baseline)
    const maintenance = Math.round(bmr * activityMult);

    // Goal calories
    let calories = maintenance;
    if (goal === "loss") calories -= 400;
    if (goal === "muscle") calories += 300;
    calories = Math.round(calories);

    // --- Macros (practical split) ---
    const protein = Math.round(weight * 1.8);
    const fats = Math.round((calories * 0.25) / 9);
    const carbs = Math.max(0, Math.round((calories - (protein * 4 + fats * 9)) / 4));

    // -----------------------------
    // UI updates
    // -----------------------------
    if (results) results.classList.add("has-results");
    if (statusPill) statusPill.textContent = "Updated";

    if (ringCalories) ringCalories.textContent = calories;

    if (macroCalories) macroCalories.textContent = `${calories} kcal`;
    if (macroProtein) macroProtein.textContent = `${protein} g`;
    if (macroCarbs) macroCarbs.textContent = `${carbs} g`;
    if (macroFats) macroFats.textContent = `${fats} g`;

    // Bars (visual scale only)
    const pPct = clamp(protein / 220, 0, 1) * 100;
    const cPct = clamp(carbs / 420, 0, 1) * 100;
    const fPct = clamp(fats / 140, 0, 1) * 100;

    if (barProtein) barProtein.style.width = `${pPct}%`;
    if (barCarbs) barCarbs.style.width = `${cPct}%`;
    if (barFats) barFats.style.width = `${fPct}%`;

    // -----------------------------
    // Ring progress based on MAINTENANCE
    // -----------------------------
    // pct = goal / maintenance (e.g. cut 0.85, bulk 1.12)
    const pct = clamp(calories / maintenance, 0, 1.5);
    const pctForRing = clamp(pct, 0, 1); // ring fills up to 100%
    const deg = pctForRing * 360;

    if (ringSub) {
      ringSub.textContent = `Shown as % of your maintenance (${maintenance} kcal/day)`;
    }

    if (ringTitle) {
      ringTitle.textContent = `Daily calories • ${Math.round(pct * 100)}%`;
    }

    if (ringGraphic) {
      ringGraphic.style.setProperty("--progress", "0deg");
      requestAnimationFrame(() => {
        ringGraphic.style.setProperty("--progress", `${deg}deg`);
      });
    }

    // Result sentence
    const goalLabel =
      goal === "loss" ? "fat loss" :
      goal === "muscle" ? "muscle gain" :
      goal === "maintain" ? "maintenance" :
      "higher fibre";

    if (resultText) {
      resultText.innerHTML =
        `For <strong>${goalLabel}</strong>, your estimated daily target is around <strong>${calories} kcal</strong>.`;
    }

    // -----------------------------
    // Recommended plan
    // -----------------------------
    let planName, planPrice, planImage, tagText;

    if (goal === "loss") {
      planName = "Fat Loss Meal Prep Plan";
      planPrice = "49.99";
      planImage = "/images/fat_loss_plan.png";
      tagText = "Cut-friendly";
    } else if (goal === "muscle") {
      planName = "Lean Muscle Meal Prep Plan";
      planPrice = "59.99";
      planImage = "/images/lean_muscle_plan.jpg";
      tagText = "High protein";
    } else if (goal === "maintain") {
      planName = "Maintenance Meal Prep Plan";
      planPrice = "54.99";
      planImage = "/images/maintainance_plan.jpg";
      tagText = "Balanced";
    } else {
      planName = "High Fibre Meal Prep Plan";
      planPrice = "52.99";
      planImage = "/images/high_fibre_plan.jpg";
      tagText = "Gut-friendly";
    }

    if (planOutput) if (planOutput) planOutput.textContent = planName;
    if (planRecoPrice) planRecoPrice.textContent = `£${planPrice}`;
    if (planRecoTag) planRecoTag.textContent = tagText;
    if (planRecoImage) planRecoImage.src = planImage;

    // Update datasets then show button
    if (addBtn) {
      addBtn.dataset.name = planName;
      addBtn.dataset.price = planPrice;
      addBtn.dataset.image = planImage;
      showAddBtn();
    }
  });

})();

// Subtle glow-follow on header
(() => {
  const hero = document.querySelector('.calc-hero');
  if (!hero) return;

  hero.addEventListener('mousemove', (e) => {
    const r = hero.getBoundingClientRect();
    const x = ((e.clientX - r.left) / r.width) * 100;
    hero.style.setProperty('--mx', `${x}%`);
  });
})();

