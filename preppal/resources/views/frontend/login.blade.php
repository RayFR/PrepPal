<!--
  Students & IDs: Agraj Khanna(240195519) / Musab Ahmed Rashid (230084799) / Gurpreet Singh Sidhu (230237915)
  File: login.html
  Description: Login + registration page for customers and admin
  Date: Nov 2025
-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>PrepPal • Sign In</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>
  <main class="container" style="padding:4rem 1rem;">
    <section class="card" style="max-width:520px;margin:0 auto;">
      <h2 style="margin-top:0;">Welcome to PrepPal</h2>
      <p style="font-size:0.9rem;color:#666;margin-top:0.25rem;">
        Create an account to access the calculator, meals, and dashboard.
      </p>

      <!-- Tabs -->
      <div class="auth-tabs">
        <button type="button" class="auth-tab auth-tab-active" data-mode="login">Sign In</button>
        <button type="button" class="auth-tab" data-mode="register">Create account</button>
      </div>

      <!-- LOGIN FORM -->
      <form id="loginForm" class="auth-form auth-form-active" method="POST" action="{{ route('login') }}">
        @csrf

        <label>Email</label>
        <input type="email" name="email" placeholder="you@example.com" required />

        <label style="margin-top:.75rem;">Password</label>
        <input type="password" name="password" placeholder="••••••••" required />

        @error('email')
            <p style="color:red;font-size:.9rem;">{{ $message }}</p>
        @enderror

        <div style="margin-top:1.1rem; display:flex; gap:1rem; align-items:center; justify-content:space-between;">
          <button class="cta" type="submit">Sign In</button>
          <a href="{{ route('home') }}" style="color:#666; text-decoration:none;">Back to site</a>
        </div>

        <p class="auth-note">
          Admin demo login: <strong>admin@preppal.com</strong> / <strong>123456</strong>
        </p>
      </form>


      <!-- REGISTER FORM -->
      <form id="registerForm" class="auth-form" method="POST" action="{{ route('register') }}">
        @csrf

        <label>Full name</label>
        <input type="text" name="name" placeholder="Your name" required />

        <label style="margin-top:.75rem;">Email</label>
        <input type="email" name="email" placeholder="you@example.com" required />

        <label style="margin-top:.75rem;">Password</label>
        <input type="password" name="password" minlength="6" required />

        <label style="margin-top:.75rem;">Confirm password</label>
        <input type="password" name="password_confirmation" minlength="6" required />

        @error('email')
            <p style="color:red;font-size:.9rem;">{{ $message }}</p>
        @enderror

        <button class="cta" type="submit" style="margin-top:1.1rem;">Create account</button>
      </form>
    </section>
  </main>

  <footer class="footer">
    <div class="container">© <span id="year"></span> PrepPal — Eat better, live easier.</div>
  </footer>

  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/store.js') }}"></script>

  <!-- Simple tab switcher (this is SAFE) -->
  <script>
      const tabs = document.querySelectorAll('.auth-tab');
      const forms = document.querySelectorAll('.auth-form');

      tabs.forEach(tab => {
          tab.addEventListener('click', () => {
              tabs.forEach(t => t.classList.remove('auth-tab-active'));
              forms.forEach(f => f.classList.remove('auth-form-active'));

              tab.classList.add('auth-tab-active');
              document.getElementById(tab.dataset.mode + 'Form').classList.add('auth-form-active');
          });
      });
  </script>
</body>
</html>
