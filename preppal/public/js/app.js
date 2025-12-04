// Students & IDs: (Agraj Khanna 240195519 ID / Gurpreet Singh Sidhu 230237915 ID)
// Global helpers: theme toggle, footer year, calculator logic (AUTH REMOVED FOR LARAVEL)

(function () {



  function updateAuthUI() {
  }

  var authButton = document.getElementById('authButton');
  if (authButton) {
    authButton.removeAttribute('data-mode');
  }


  var loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function () {
      
    });
  }

  var registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', function () {
    });
  }

  // Auth tabs on login page 
  var authTabs = document.querySelectorAll('.auth-tab');
  if (authTabs.length) {
    authTabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        var mode = tab.getAttribute('data-mode');
        authTabs.forEach(t => t.classList.remove('auth-tab-active'));
        tab.classList.add('auth-tab-active');

        var forms = document.querySelectorAll('.auth-form');
        forms.forEach(f => f.classList.remove('auth-form-active'));

        var targetId = mode === 'register' ? 'registerForm' : 'loginForm';
        var targetForm = document.getElementById(targetId);
        if (targetForm) targetForm.classList.add('auth-form-active');
      });
    });
  }

 
  // CTA keyboard accessibility
 var ctas = document.querySelectorAll('.cta');
  ctas.forEach(function (btn) {
    btn.addEventListener('keyup', function (e) {
      if (e.key === 'Enter') btn.click();
    });
  });


  var yearEl = document.getElementById('year');
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }

  
  // THEME TOGGLE
  var THEME_KEY = 'preppal_theme';

  function applyTheme(theme) {
    if (theme !== 'dark') theme = 'light';
    document.body.setAttribute('data-theme', theme);

    var toggle = document.getElementById('themeToggle');
    if (toggle) {
      toggle.textContent = theme === 'dark' ? '🌙' : '☀️';
    }
  }

  function initTheme() {
    var stored = localStorage.getItem(THEME_KEY) || 'light';
    applyTheme(stored);

    var toggle = document.getElementById('themeToggle');
    if (toggle) {
      toggle.addEventListener('click', function () {
        var current = document.body.getAttribute('data-theme') || 'light';
        var next = current === 'light' ? 'dark' : 'light';
        localStorage.setItem(THEME_KEY, next);
        applyTheme(next);
      });
    }
  }

  initTheme();
  updateAuthUI();

  // CALCULATOR LOGIC (UNCHANGED)
  var calorieForm = document.getElementById('calorieForm');
  var calorieResultText = document.getElementById('calorieResultText');
  var macroList = document.getElementById('macroResultList');
  var planOutput = document.getElementById('caloriePlanOutput');
  var recommendedBtn = document.getElementById('recommendedPlanAdd');

  if (calorieForm && calorieResultText && macroList && planOutput && recommendedBtn) {

   var PLAN_CONFIG = {
  loss: {
    name: 'Fat Loss Meal Prep Plan',
    price: '49.99',
    image: '/images/fat_loss_plan.png'
  },

  muscle: {
    name: 'Lean Muscle Meal Prep Plan',
    price: '59.99',
    image: '/images/lean_muscle_plan.jpg'
  },

  maintain: {
    name: 'Maintenance Meal Prep Plan',
    price: '54.99',
    image: '/images/maintainance_plan.jpg'
  },

  fibre: {
    name: 'High Fibre Meal Prep Plan',
    price: '52.99',
    image: '/images/high_fibre_plan.jpg'
  }
};


    function calculateTargets(age, sex, height, weight, activity, goal) {
      var bmr = 10 * weight + 6.25 * height - 5 * age + (sex === 'male' ? 5 : -161);
      var maintenance = bmr * getActivityFactor(activity);
      var targetCalories = goal === 'loss' ? maintenance * 0.8 :
                           goal === 'muscle' ? maintenance * 1.15 :
                           goal === 'fibre' ? maintenance * 0.95 :
                           maintenance;

      var proteinPerKg = goal === 'muscle' ? 2.0 : goal === 'loss' ? 1.8 : 1.6;

      var protein = proteinPerKg * weight;
      var fat = (targetCalories * 0.25) / 9;
      var remaining = targetCalories - (protein * 4) - (fat * 9);
      var carbs = (remaining < 0 ? targetCalories * 0.2 : remaining) / 4;

      return {
        calories: Math.round(targetCalories),
        protein: Math.round(protein),
        carbs: Math.round(carbs),
        fats: Math.round(fat)
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

      if (!age || !height || !weight) return;

      var targets = calculateTargets(age, sex, height, weight, activity, goal);
      var planCfg = PLAN_CONFIG[goal];

      var goalLabel = goal === 'loss' ? 'fat loss' :
                      goal === 'muscle' ? 'lean muscle gain' :
                      goal === 'maintain' ? 'weight maintenance' :
                      'higher fibre and overall health';

      calorieResultText.innerHTML =
        'For <strong>' + goalLabel +
        '</strong>, your estimated daily target is around <strong>' +
        targets.calories + ' kcal</strong>.';

      var ringCaloriesEl = document.getElementById('ringCalories');
      var ringGraphic = document.querySelector('.ring-graphic');
      if (ringCaloriesEl) ringCaloriesEl.textContent = targets.calories;

      if (ringGraphic) {
        var ratio = Math.min(targets.calories / 3000, 1);
        ringGraphic.style.setProperty('--progress', Math.round(ratio * 360) + 'deg');
      }

      macroList.innerHTML =
        '<li><strong>Calories</strong><span>' + targets.calories + ' kcal</span></li>' +
        '<li><strong>Protein</strong><span>' + targets.protein + ' g / day</span></li>' +
        '<li><strong>Carbs</strong><span>' + targets.carbs + ' g / day</span></li>' +
        '<li><strong>Fats</strong><span>' + targets.fats + ' g / day</span></li>';

      if (planCfg) {
        planOutput.innerHTML = '<strong>Recommended PrepPal plan:</strong> ' + planCfg.name + '.';
        recommendedBtn.style.display = 'inline-block';
        recommendedBtn.setAttribute('data-name', planCfg.name);
        recommendedBtn.setAttribute('data-price', planCfg.price);
        recommendedBtn.setAttribute('data-image', planCfg.image);
        recommendedBtn.textContent =
          'Add ' + planCfg.name.replace(' Meal Prep Plan', '') + ' to cart';
      } else {
        planOutput.innerHTML = '<strong>Recommended PrepPal plan:</strong> Please choose a goal.';
        recommendedBtn.style.display = 'none';
      }

    });
  }

  document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll('.auth-tab');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('auth-tab-active'));
            tab.classList.add('auth-tab-active');

            const mode = tab.dataset.mode;

            document.getElementById('loginForm').classList.toggle('auth-form-active', mode === 'login');
            document.getElementById('registerForm').classList.toggle('auth-form-active', mode === 'register');
        });
    });
});


})();
