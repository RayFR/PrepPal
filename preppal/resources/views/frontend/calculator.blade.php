@extends('layouts.app')

@section('title', 'Calculator')

@section('content')

<main class="container main-content">
    <section class="hero small-hero">
        <div class="hero-text">
            <h1>Find Your Perfect PrepPal Plan</h1>
            <p>Enter your details to see your estimated calories, macros, and the plan we recommend.</p>
        </div>
    </section>

    <section class="card calorie-planner">
        <div class="calorie-header">
            <h2 style="margin-top:0;">Personalised Plan Calculator</h2>
            <p>This tool uses Mifflin–St Jeor to estimate your needs. It’s a guide only.</p>

            <div class="calorie-tag-row">
                <span class="pill pill-soft">Step 1 · Your details</span>
                <span class="pill pill-soft">Step 2 · Targets</span>
                <span class="pill pill-soft">Step 3 · PrepPal plan</span>
            </div>
        </div>

        <form id="calorieForm" class="calorie-form" autocomplete="off">
            <div class="calorie-grid">

                <div>
                    <label for="age">Age</label>
                    <input id="age" name="age" type="number" min="16" max="90" required placeholder="Years" />
                </div>

                <div>
                    <label for="sex">Sex</label>
                    <select id="sex" name="sex" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div>
                    <label for="height">Height (cm)</label>
                    <input id="height" name="height" type="number" min="130" max="220" required placeholder="e.g. 175" />
                </div>

                <div>
                    <label for="weight">Weight (kg)</label>
                    <input id="weight" name="weight" type="number" min="40" max="200" required placeholder="e.g. 75" />
                </div>

                <div>
                    <label for="activity">Activity level</label>
                    <select id="activity" name="activity" required>
                        <option value="sedentary">Sedentary</option>
                        <option value="light">Lightly active</option>
                        <option value="moderate">Moderately active</option>
                        <option value="very">Very active</option>
                    </select>
                </div>

                <div>
                    <label for="goal">Goal</label>
                    <select id="goal" name="goal" required>
                        <option value="loss">Lose fat</option>
                        <option value="muscle">Gain muscle</option>
                        <option value="maintain">Maintain weight</option>
                        <option value="fibre">Higher fibre</option>
                    </select>
                </div>

            </div>

            <button type="submit" class="cta primary-cta" style="margin-top:1rem;">
                🔍 Calculate my plan
            </button>
        </form>

        <div id="calorieResults" class="calorie-results" aria-live="polite">
            <div class="calorie-summary">
                <div class="calorie-ring">
                    <div class="ring-graphic">
                        <div class="ring-inner">
                            <span id="ringCalories">0</span>
                            <small>kcal / day</small>
                        </div>
                    </div>
                    <p class="ring-caption">Estimated target</p>
                </div>

                <div class="summary-text">
                    <h3>Your daily target</h3>
                    <p id="calorieResultText">Enter your details to see your estimate.</p>
                </div>
            </div>

           

    <div class="macro-card">
        <span class="macro-icon">🔥</span>
        <div class="macro-info">
            <h4>Calories</h4>
            <p id="macroCalories">–</p>
        </div>
    </div>

    <div class="macro-card">
        <span class="macro-icon">💪</span>
        <div class="macro-info">
            <h4>Protein</h4>
            <p id="macroProtein">–</p>
        </div>
    </div>

    <div class="macro-card">
        <span class="macro-icon">🍚</span>
        <div class="macro-info">
            <h4>Carbs</h4>
            <p id="macroCarbs">–</p>
        </div>
    </div>

    <div class="macro-card">
        <span class="macro-icon">🥑</span>
        <div class="macro-info">
            <h4>Fats</h4>
            <p id="macroFats">–</p>
        </div>
    </div>

</div>


            <p id="caloriePlanOutput" class="plan-card">
                <strong>Recommended PrepPal plan:</strong> –
            </p>

            <a
                href="#"
                id="recommendedPlanAdd"
                class="cta add-to-cart plan-add-btn"
                data-name=""
                data-price=""
                data-image=""
                style="display:none; margin-top:.5rem;"
            >
                Add recommended plan to cart
            </a>
        </div>
    </section>

    <section class="card" style="margin-top:2rem;">
        <h2 style="margin-top:0;">Next step: choose your meals</h2>
        <p>Your recommended plan can be added to the cart and viewed instantly in the store.</p>
        <a href="{{ route('store') }}" class="cta">Go to Meals & Supplements</a>
    </section>

</main>

@endsection

@push('scripts')
<script src="{{ asset('js/calculator.js') }}"></script>
@endpush
