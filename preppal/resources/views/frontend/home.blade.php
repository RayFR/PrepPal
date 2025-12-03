<!--
  Student&ID: Agraj Khanna(240195519)
  File: index.html
  Description: Homepage with navigation, welcome text, and footer
  Date: Oct 30, Thursday 2025
-->

<!--
  Student & ID: Gurpreet Singh Sidhu (230237915)
  Role: Designer
  File: index.html
  Description: Homepage with navigation, hero section, and footer for PrepPal.
  Date: Nov 2025
-->

<!--
  Student & ID: Musab Ahmed Rashid (230084799)
  Role: Designer
  File: index.html
  Description: Homepage with navigation, hero section, and footer for PrepPal.
  Date: Nov 2025
-->

@extends('layouts.app')

@section('title', 'PrepPal – Home')

@section('content')

<!-- Hero Section -->
<section class="hero">
    <div class="hero-text">
        <h1>Healthy Eating Made Simple</h1>
        <p>Personalized meals and supplements for your lifestyle goals.</p>

        <div class="hero-actions">
            <a href="{{ route('login') }}" class="cta">Get Started</a>
            <a href="#how-it-works" class="hero-secondary">How it works</a>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="main-content">

    <h2>Welcome to PrepPal</h2>
    <p>
        PrepPal is your go-to platform for meal prepping and nutrition
        management. Discover tailored meal plans, track your nutrition,
        and stay consistent with your goals — all in one place.
    </p>

    <!-- Pills navigation -->
    <div class="pill-nav">
        <a href="#how-it-works" class="pill-link">How it works</a>
        <a href="#plans" class="pill-link">Plans &amp; meals</a>
        <a href="#our-story" class="pill-link">Our goal</a>
    </div>

    <!-- HOW IT WORKS -->
    <section id="how-it-works" class="page-section info-section">
        <h3>How PrepPal works</h3>
        <p class="info-lead">
            We combine a simple macro calculator with ready-made meal prep plans so you always know what to eat.
        </p>

        <div class="info-grid">
            <div class="card">
                <h4>1. Calculate your targets</h4>
                <p>Use the calorie &amp; macro calculator to estimate your daily needs based on your body and activity.</p>
            </div>

            <div class="card">
                <h4>2. Choose a PrepPal plan</h4>
                <p>Pick from fat loss, lean muscle, maintenance or high-fibre plans that match your goals.</p>
            </div>

            <div class="card">
                <h4>3. Add meals &amp; supplements</h4>
                <p>Add meal prep plans and supplements to your cart. Your choices stay saved while you browse.</p>
            </div>
        </div>
    </section>

    <!-- PLANS -->
    <section id="plans" class="page-section info-section">
        <h3>Plans &amp; meals</h3>
        <p class="info-lead">
            Ready-made weekly plans designed around your calories and macros.
        </p>

        <div class="info-grid">
            <div class="card">
                <h4>Fat loss</h4>
                <p>Lower-calorie, high-protein meals to help you lean down without feeling starved.</p>
            </div>

            <div class="card">
                <h4>Lean muscle</h4>
                <p>Higher-calorie plans with extra carbs and protein to support training and recovery.</p>
            </div>

            <div class="card">
                <h4>High-fibre</h4>
                <p>Plant-forward meals with plenty of fibre and micronutrients for long-term health.</p>
            </div>
        </div>

        <div class="info-cta">
            <a href="{{ route('store') }}" class="cta">Explore meals &amp; supplements</a>
        </div>
    </section>

    <!-- OUR GOAL -->
    <section id="our-story" class="page-section info-section">
        <h3>Our goal</h3>
        <p class="info-lead">
            PrepPal was built to make meal prep and nutrition feel simple, not stressful.
        </p>
        <p>
            Instead of tracking every single food from scratch, we focus on curated weekly plans that already
            match your calorie and macro targets. You choose a goal, we handle the meal prep ideas.
        </p>
    </section>

</div>

@endsection