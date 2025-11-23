// Students & IDs: (Agraj Khanna 240195519 ID / Gurpreet Singh Sidhu 230237915 ID)
// Basic interactive helpers for admin frontend (mobile nav toggle + demo form handler)
(function () {
// Demo: intercept login form to show a friendly alert (remove when wiring real backend)
// ====================================================
// Fake Login System (localStorage-based authentication)
// ====================================================

var AUTH_KEY = "preppal_isLoggedIn";
function isLoggedIn() {
  return localStorage.getItem(AUTH_KEY) === "true";
}

function login() {
  localStorage.setItem(AUTH_KEY, "true");
}

function logout() {
  localStorage.removeItem(AUTH_KEY);
}

// Handle login form
var loginForm = document.getElementById("loginForm");

if (loginForm) {
  loginForm.addEventListener("submit", function (e) {
    e.preventDefault();

    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value.trim();

    // Hard-coded demo credentials
    if (email === "admin@preppal.com" && password === "123456") {
      login();
      alert("Login successful!");
      window.location.href = "index.html"; // redirect after login
    } else {
      alert("Incorrect email or password. Try admin@preppal.com / 123456");
    }
  });
}

// Handle logout button in nav
var logoutBtn = document.querySelector('a[href="login.html"].cta');

if (logoutBtn) {
  logoutBtn.addEventListener("click", function () {
    logout();
  });
}


  // Accessibility: allow Enter on CTA links (just ensures keyboard focus)
  var ctas = document.querySelectorAll('.cta');
  ctas.forEach(function (btn) {
    btn.addEventListener('keyup', function (e) {
      if (e.key === 'Enter') btn.click();
    });
  });

  // Auto-update footer year on every page (Agraj Khanna/240195519 ID)
  var yearEl = document.getElementById('year');
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }

 
  // Personalised calorie / macro calculator (calculator page)
  var calorieForm = document.getElementById('calorieForm');
  var calorieResultText = document.getElementById('calorieResultText');
  var macroList = document.getElementById('macroResultList');
  var planOutput = document.getElementById('caloriePlanOutput');
  var recommendedBtn = document.getElementById('recommendedPlanAdd');

  // Only run this part on the calculator page (where all elements exist)
  if (calorieForm && calorieResultText && macroList && planOutput && recommendedBtn) {
    // Map goals to PrepPal plans, prices, and images (matches store.html)
    var PLAN_CONFIG = {
      loss: {
        name: 'Fat Loss Meal Prep Plan',
        price: '49.99',
        image: 'images/chicken-bowl.png'
      },
      muscle: {
        name: 'Lean Muscle Meal Prep Plan',
        price: '59.99',
        image: 'images/chicken-bowl.png'
      },
      maintain: {
        name: 'Maintenance Meal Prep Plan',
        price: '54.99',
        image: 'images/vegan-bowl.png'
      },
      fibre: {
        name: 'High Fibre Meal Prep Plan',
        price: '52.99',
        image: 'images/vegan-bowl.png'
      }
    };

    function getActivityFactor(level) {
      switch (level) {
        case 'light':
          return 1.375;
        case 'moderate':
          return 1.55;
        case 'very':
          return 1.725;
        case 'sedentary':
        default:
          return 1.2;
      }
    }

    function calculateTargets(age, sex, height, weight, activity, goal) {
      // Mifflin–St Jeor BMR
      var bmr =
        10 * weight +
        6.25 * height -
        5 * age +
        (sex === 'male' ? 5 : -161);

      var maintenance = bmr * getActivityFactor(activity);

      var targetCalories = maintenance;
      if (goal === 'loss') {
        targetCalories = maintenance * 0.8; // ~20% deficit
      } else if (goal === 'muscle') {
        targetCalories = maintenance * 1.15; // ~15% surplus
      } else if (goal === 'fibre') {
        // keep roughly maintenance but with more plant foods
        targetCalories = maintenance * 0.95;
      }

      // Macros:
      // protein per kg based on goal
      var proteinPerKg =
        goal === 'muscle' ? 2.0 :
        goal === 'loss' ? 1.8 :
        1.6;

      var proteinGrams = proteinPerKg * weight;
      var proteinCals = proteinGrams * 4;

      // fats ~25% of calories
      var fatCals = targetCalories * 0.25;
      var fatGrams = fatCals / 9;

      // remaining calories to carbs
      var remainingCals = targetCalories - proteinCals - fatCals;
      if (remainingCals < 0) remainingCals = targetCalories * 0.2; // fallback
      var carbGrams = remainingCals / 4;

      return {
        calories: Math.round(targetCalories),
        protein: Math.round(proteinGrams),
        carbs: Math.round(carbGrams),
        fats: Math.round(fatGrams)
      };
    }

    calorieForm.addEventListener('submit', function (e) {
      e.preventDefault();

      var age = parseInt(document.getElementById('age').value, 10);
      var sex = document.getElementById('sex').value;
      var height = parseFloat(document.getElementById('height').value);
      var weight = parseFloat(document.getElementById('weight').value);
      var activity = document.getElementById('activity').value;
      var goal = document.getElementById('goal').value;

      if (!age || !height || !weight) {
        return;
      }

      var targets = calculateTargets(age, sex, height, weight, activity, goal);
      var planCfg = PLAN_CONFIG[goal];

      // Text summary
      var goalLabel =
        goal === 'loss'
          ? 'fat loss'
          : goal === 'muscle'
          ? 'lean muscle gain'
          : goal === 'maintain'
          ? 'weight maintenance'
          : 'higher fibre and overall health';

      calorieResultText.innerHTML =
        'For <strong>' +
        goalLabel +
        '</strong>, your estimated daily target is around <strong>' +
        targets.calories +
        ' kcal</strong>.';

      // === UPDATE THE RING ===
      var ringCaloriesEl = document.getElementById('ringCalories');
      var ringGraphic = document.querySelector('.ring-graphic');

      if (ringCaloriesEl) {
        ringCaloriesEl.textContent = targets.calories;
      }
      if (ringGraphic) {
        // Assume 3,000 kcal as a "full ring" for visual purposes
        var ratio = Math.min(targets.calories / 3000, 1);
        var angle = Math.round(ratio * 360);
        ringGraphic.style.setProperty('--progress', angle + 'deg');
      }

      // === MACROS LIST (cards) ===
      macroList.innerHTML =
        '<li><strong>Calories</strong><span>' +
        targets.calories +
        ' kcal</span></li>' +
        '<li><strong>Protein</strong><span>' +
        targets.protein +
        ' g / day</span></li>' +
        '<li><strong>Carbs</strong><span>' +
        targets.carbs +
        ' g / day</span></li>' +
        '<li><strong>Fats</strong><span>' +
        targets.fats +
        ' g / day</span></li>';

      // === PLAN RECOMMENDATION + CART BUTTON ===
      if (planCfg) {
        planOutput.innerHTML =
          '<strong>Recommended PrepPal plan:</strong> ' +
          planCfg.name +
          '.';

        // Configure the "add recommended plan" button so store.js can handle it
        recommendedBtn.style.display = 'inline-block';
        recommendedBtn.textContent =
          'Add ' + planCfg.name.replace(' Meal Prep Plan', '') + ' to cart';
        recommendedBtn.setAttribute('data-name', planCfg.name);
        recommendedBtn.setAttribute('data-price', planCfg.price);
        recommendedBtn.setAttribute('data-image', planCfg.image);
      } else {
        planOutput.innerHTML =
          '<strong>Recommended PrepPal plan:</strong> Please choose a goal.';
        recommendedBtn.style.display = 'none';
      }
    });
  }
})();
