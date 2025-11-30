// Students & IDs: (Agraj Khanna 240195519 ID / Gurpreet Singh Sidhu 230237915 ID)
// Global helpers: auth (localStorage), theme toggle, footer year, calculator logic

(function () {
  // =========================
  // AUTH & USER MANAGEMENT
  // =========================
  var CURRENT_USER_KEY = 'preppal_currentUser';
  var USERS_KEY = 'preppal_users';
  var LEGACY_AUTH_KEY = 'preppal_isLoggedIn'; // keep for backward compatibility

  function loadUsers() {
    try {
      var raw = localStorage.getItem(USERS_KEY);
      if (!raw) return [];
      var list = JSON.parse(raw);
      return Array.isArray(list) ? list : [];
    } catch (e) {
      console.warn('Could not parse users from storage', e);
      return [];
    }
  }

  function saveUsers(list) {
    try {
      localStorage.setItem(USERS_KEY, JSON.stringify(list || []));
    } catch (e) {
      console.warn('Could not save users', e);
    }
  }

  function findUserByEmail(email) {
    var users = loadUsers();
    email = (email || '').toLowerCase();
    return users.find(function (u) { return (u.email || '').toLowerCase() === email; }) || null;
  }

  function seedAdminUser() {
    var users = loadUsers();
    var existingAdmin = users.find(function (u) { return u.isAdmin; });
    if (!existingAdmin) {
      users.push({
        id: 'admin',
        name: 'PrepPal Admin',
        email: 'admin@preppal.com',
        password: '123456', // demo only – not secure for production
        isAdmin: true,
        createdAt: new Date().toISOString()
      });
      saveUsers(users);
    }
  }

  function getCurrentUser() {
    try {
      var raw = localStorage.getItem(CURRENT_USER_KEY);
      if (!raw) return null;
      return JSON.parse(raw);
    } catch (e) {
      return null;
    }
  }

  function setCurrentUser(user) {
    if (!user) {
      localStorage.removeItem(CURRENT_USER_KEY);
      localStorage.removeItem(LEGACY_AUTH_KEY);
      return;
    }
    var payload = {
      id: user.id,
      name: user.name,
      email: user.email,
      isAdmin: !!user.isAdmin
    };
    localStorage.setItem(CURRENT_USER_KEY, JSON.stringify(payload));
    localStorage.setItem(LEGACY_AUTH_KEY, 'true');
  }

  function logout() {
    setCurrentUser(null);
  }

  seedAdminUser();

  // =========================
  // AUTH UI (nav + forms)
  // =========================

  function updateAuthUI() {
    var user = getCurrentUser();
    var isAdmin = user && user.isAdmin;

    // Auth button in navbar
    var authBtn = document.getElementById('authButton');
    if (authBtn) {
      if (user) {
        authBtn.textContent = 'Log Out';
        authBtn.setAttribute('data-mode', 'logout');
      } else {
        // keep "Get Started" on home if already set
        if (!authBtn.getAttribute('data-original-text')) {
          authBtn.setAttribute('data-original-text', authBtn.textContent || 'Sign In');
        }
        var original = authBtn.getAttribute('data-original-text') || 'Sign In';
        authBtn.textContent = original;
        authBtn.removeAttribute('data-mode');
        authBtn.href = 'login.html';
      }
    }

    // Optional: show/hide admin-only nav items
    var adminLinks = document.querySelectorAll('.nav-admin-only');
    adminLinks.forEach(function (el) {
      el.style.display = isAdmin ? '' : 'none';
    });

    var guestOnly = document.querySelectorAll('.nav-guest-only');
    guestOnly.forEach(function (el) {
      el.style.display = user ? 'none' : '';
    });

    var userOnly = document.querySelectorAll('.nav-user-only');
    userOnly.forEach(function (el) {
      el.style.display = user && !isAdmin ? '' : 'none';
    });
  }

  // Handle navbar auth button (login vs logout)
  var authButton = document.getElementById('authButton');
  if (authButton) {
    authButton.addEventListener('click', function (e) {
      var mode = authButton.getAttribute('data-mode');
      if (mode === 'logout') {
        e.preventDefault();
        logout();
        updateAuthUI();
        window.location.href = 'index.html';
      }
      // otherwise normal link to login.html
    });
  }

  // Login form handler
  var loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var emailEl = document.getElementById('loginEmail');
      var passEl = document.getElementById('loginPassword');
      if (!emailEl || !passEl) return;

      var email = emailEl.value.trim();
      var password = passEl.value.trim();
      if (!email || !password) return;

      var user = findUserByEmail(email);
      if (!user || user.password !== password) {
        alert('Incorrect email or password. Try again.\nAdmin demo: admin@preppal.com / 123456');
        return;
      }

      setCurrentUser(user);
      alert('Welcome back, ' + (user.name || 'PrepPal user') + '!');
      updateAuthUI();

      if (user.isAdmin) {
        window.location.href = 'admin.html';
      } else {
        window.location.href = 'index.html';
      }
    });
  }

  // Registration form handler
  var registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', function (e) {
      e.preventDefault();

      var nameEl = document.getElementById('regName');
      var emailEl = document.getElementById('regEmail');
      var passEl = document.getElementById('regPassword');
      var pass2El = document.getElementById('regPassword2');

      var name = nameEl.value.trim();
      var email = emailEl.value.trim();
      var password = passEl.value;
      var password2 = pass2El.value;

      if (!name || !email || !password || !password2) {
        alert('Please fill in all fields.');
        return;
      }
      if (password.length < 6) {
        alert('Password should be at least 6 characters.');
        return;
      }
      if (password !== password2) {
        alert('Passwords do not match.');
        return;
      }
      if (findUserByEmail(email)) {
        alert('An account with that email already exists. Try signing in.');
        return;
      }

      var users = loadUsers();
      var newUser = {
        id: 'user_' + Date.now(),
        name: name,
        email: email,
        password: password,
        isAdmin: false,
        createdAt: new Date().toISOString()
      };
      users.push(newUser);
      saveUsers(users);

      setCurrentUser(newUser);
      updateAuthUI();
      alert('Account created! You are now signed in, ' + name + '.');

      window.location.href = 'index.html';
    });
  }

  // Auth tabs on login page
  var authTabs = document.querySelectorAll('.auth-tab');
  if (authTabs.length) {
    authTabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        var mode = tab.getAttribute('data-mode'); // "login" or "register"

        authTabs.forEach(function (t) { t.classList.remove('auth-tab-active'); });
        tab.classList.add('auth-tab-active');

        var forms = document.querySelectorAll('.auth-form');
        forms.forEach(function (form) {
          form.classList.remove('auth-form-active');
        });

        var targetId = mode === 'register' ? 'registerForm' : 'loginForm';
        var targetForm = document.getElementById(targetId);
        if (targetForm) {
          targetForm.classList.add('auth-form-active');
        }
      });
    });
  }

  // =========================
  // CTA keyboard accessibility
  // =========================
  var ctas = document.querySelectorAll('.cta');
  ctas.forEach(function (btn) {
    btn.addEventListener('keyup', function (e) {
      if (e.key === 'Enter') btn.click();
    });
  });

  // =========================
  // Auto-update footer year
  // =========================
  var yearEl = document.getElementById('year');
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }

  // =========================
  // THEME TOGGLE (light/dark)
  // =========================
  var THEME_KEY = 'preppal_theme';

  function applyTheme(theme) {
    if (theme !== 'dark') theme = 'light';
    var body = document.body;
    if (!body) return;
    body.setAttribute('data-theme', theme);

    var toggle = document.getElementById('themeToggle');
    if (toggle) {
      toggle.textContent = theme === 'dark' ? '🌙' : '☀️';
    }
  }

  function initTheme() {
    var stored = localStorage.getItem(THEME_KEY);
    if (!stored) {
      stored = 'light';
    }
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

  // =========================
  // CALCULATOR LOGIC
  // =========================
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
      var bmr =
        10 * weight +
        6.25 * height -
        5 * age +
        (sex === 'male' ? 5 : -161);

      var maintenance = bmr * getActivityFactor(activity);

      var targetCalories = maintenance;
      if (goal === 'loss') {
        targetCalories = maintenance * 0.8;
      } else if (goal === 'muscle') {
        targetCalories = maintenance * 1.15;
      } else if (goal === 'fibre') {
        targetCalories = maintenance * 0.95;
      }

      var proteinPerKg =
        goal === 'muscle' ? 2.0 :
        goal === 'loss' ? 1.8 :
        1.6;

      var proteinGrams = proteinPerKg * weight;
      var proteinCals = proteinGrams * 4;

      var fatCals = targetCalories * 0.25;
      var fatGrams = fatCals / 9;

      var remainingCals = targetCalories - proteinCals - fatCals;
      if (remainingCals < 0) remainingCals = targetCalories * 0.2;
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

      var ringCaloriesEl = document.getElementById('ringCalories');
      var ringGraphic = document.querySelector('.ring-graphic');

      if (ringCaloriesEl) {
        ringCaloriesEl.textContent = targets.calories;
      }
      if (ringGraphic) {
        var ratio = Math.min(targets.calories / 3000, 1);
        var angle = Math.round(ratio * 360);
        ringGraphic.style.setProperty('--progress', angle + 'deg');
      }

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

      if (planCfg) {
        planOutput.innerHTML =
          '<strong>Recommended PrepPal plan:</strong> ' +
          planCfg.name +
          '.';

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