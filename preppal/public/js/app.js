// Students & IDs: (Agraj Khanna 240195519 / Gurpreet Singh Sidhu 230237915)
// Global helpers: theme toggle, footer year, calculator logic

(function () {
  // ------------------------------
  // Footer year
  // ------------------------------
  var yearEl = document.getElementById('year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  // ------------------------------
  // THEME TOGGLE
  // ------------------------------
  var THEME_KEY = 'preppal_theme';

  function applyTheme(theme) {
    if (theme !== 'dark') theme = 'light';
    document.body.setAttribute('data-theme', theme);

    var toggle = document.getElementById('themeToggle');
    if (toggle) toggle.textContent = theme === 'dark' ? '🌙' : '☀️';
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

  // ------------------------------
  // DOM Ready features
  // ------------------------------
  document.addEventListener('DOMContentLoaded', () => {
    // ------------------------------
    // Auth tabs (login/register page)
    // ------------------------------
    const tabs = document.querySelectorAll('.auth-tab');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    if (tabs.length && loginForm && registerForm) {
      tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          tabs.forEach(t => t.classList.remove('auth-tab-active'));
          tab.classList.add('auth-tab-active');

          const mode = tab.getAttribute('data-mode');
          loginForm.classList.toggle('auth-form-active', mode === 'login');
          registerForm.classList.toggle('auth-form-active', mode === 'register');
        });
      });
    }

    // ------------------------------
    // Password eye toggles (login + register)
    // ------------------------------
    document.querySelectorAll('.pp-pass-toggle').forEach((btn) => {
      btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-target');
        const input = document.getElementById(id);
        if (!input) return;

        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';

        btn.setAttribute('aria-pressed', String(show));
        btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
      });
    });

    // ------------------------------
    // Register password rules live checker
    // ------------------------------
    const pw = document.getElementById('registerPassword');
    const confirmPw = document.getElementById('registerConfirmPassword');
    const rulesWrap = document.getElementById('ppPassRules');
    const registerFormEl = document.getElementById('registerForm');

    function ensureToastContainer() {
      let container = document.getElementById('toastContainer');

      if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        document.body.appendChild(container);
      }

      return container;
    }

    function showToast(message, subtext) {
      const container = ensureToastContainer();

      const toast = document.createElement('div');
      toast.className = 'pp-toast';
      toast.innerHTML = `
        <div class="pp-toast__icon">!</div>
        <div class="pp-toast__content">
          <div class="pp-toast__title">${message}</div>
          ${subtext ? `<div class="pp-toast__text">${subtext}</div>` : ''}
        </div>
      `;

      container.appendChild(toast);

      requestAnimationFrame(() => {
        toast.classList.add('show');
      });

      setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');

        setTimeout(() => {
          if (toast.parentNode) toast.parentNode.removeChild(toast);
        }, 300);
      }, 2800);
    }

    if (pw && rulesWrap) {
      const ruleLen = rulesWrap.querySelector('[data-rule="len"]');
      const ruleNum = rulesWrap.querySelector('[data-rule="num"]');
      const ruleSym = rulesWrap.querySelector('[data-rule="sym"]');

      function refreshRules() {
        const v = pw.value || "";
        const okLen = v.length >= 6;
        const okNum = /\d/.test(v);
        const okSym = /[^A-Za-z0-9]/.test(v);

        if (ruleLen) ruleLen.classList.toggle('is-ok', okLen);
        if (ruleNum) ruleNum.classList.toggle('is-ok', okNum);
        if (ruleSym) ruleSym.classList.toggle('is-ok', okSym);
      }

      pw.addEventListener('input', refreshRules);
      refreshRules();
    }

    // ------------------------------
    // Register password match check
    // ------------------------------
    if (registerFormEl && pw && confirmPw) {
      function passwordsMatch() {
        return pw.value.trim() !== '' && confirmPw.value.trim() !== '' && pw.value === confirmPw.value;
      }

      function setMismatchState(show) {
        confirmPw.classList.toggle('pp-input-error', show);
        pw.classList.toggle('pp-input-error', show && confirmPw.value.trim() !== '');
      }

      confirmPw.addEventListener('input', () => {
        if (confirmPw.value.trim() === '') {
          setMismatchState(false);
          return;
        }

        setMismatchState(!passwordsMatch());
      });

      pw.addEventListener('input', () => {
        if (confirmPw.value.trim() === '') {
          setMismatchState(false);
          return;
        }

        setMismatchState(!passwordsMatch());
      });

      registerFormEl.addEventListener('submit', function (e) {
        if (!passwordsMatch()) {
          e.preventDefault();
          setMismatchState(true);

          showToast(
            "Passwords do not match",
            "Please make sure both password fields are the same."
          );

          confirmPw.focus();
        }
      });
    }

    // ------------------------------
    // CTA keyboard accessibility
    // ------------------------------
    var ctas = document.querySelectorAll('.cta');
    ctas.forEach(function (btn) {
      btn.addEventListener('keyup', function (e) {
        if (e.key === 'Enter') btn.click();
      });
    });
  });

  // ------------------------------
  // CALCULATOR LOGIC (UNCHANGED)
  // ------------------------------
  var calorieForm = document.getElementById('calorieForm');
  var calorieResultText = document.getElementById('calorieResultText');
  var macroList = document.getElementById('macroResultList');
  var planOutput = document.getElementById('caloriePlanOutput');
  var recommendedBtn = document.getElementById('recommendedPlanAdd');

  if (calorieForm && calorieResultText && macroList && planOutput && recommendedBtn) {
    var PLAN_CONFIG = {
      loss: { name: 'Fat Loss Meal Prep Plan', price: '49.99', image: '/images/fat_loss_plan.png' },
      muscle: { name: 'Lean Muscle Meal Prep Plan', price: '59.99', image: '/images/lean_muscle_plan.jpg' },
      maintain: { name: 'Maintenance Meal Prep Plan', price: '54.99', image: '/images/maintainance_plan.jpg' },
      fibre: { name: 'High Fibre Meal Prep Plan', price: '52.99', image: '/images/high_fibre_plan.jpg' }
    };

    function getActivityFactor(activity) {
      switch (activity) {
        case 'sedentary': return 1.2;
        case 'light': return 1.375;
        case 'moderate': return 1.55;
        case 'active': return 1.725;
        case 'very_active': return 1.9;
        default: return 1.2;
      }
    }

    function calculateTargets(age, sex, height, weight, activity, goal) {
      var bmr = 10 * weight + 6.25 * height - 5 * age + (sex === 'male' ? 5 : -161);
      var maintenance = bmr * getActivityFactor(activity);

      var targetCalories =
        goal === 'loss' ? maintenance * 0.8 :
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

      var goalLabel =
        goal === 'loss' ? 'fat loss' :
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
        recommendedBtn.textContent = 'Add ' + planCfg.name.replace(' Meal Prep Plan', '') + ' to cart';
      } else {
        planOutput.innerHTML = '<strong>Recommended PrepPal plan:</strong> Please choose a goal.';
        recommendedBtn.style.display = 'none';
      }
    });
  }
})();

// ------------------------------
// Profile dropdown (top right)
// ------------------------------
document.addEventListener('DOMContentLoaded', () => {
  const dd = document.getElementById('profileDD');
  const btn = document.getElementById('profileBtn');
  if (!dd || !btn) return;

  function closeDD() {
    dd.classList.remove('open');
    btn.setAttribute('aria-expanded', 'false');
  }

  function toggleDD() {
    const isOpen = dd.classList.toggle('open');
    btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  }

  btn.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    toggleDD();
  });

  document.addEventListener('click', (e) => {
    if (!dd.contains(e.target)) closeDD();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeDD();
  });
});