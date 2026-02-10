@extends('layouts.app')

@section('title', 'Calculator')

@section('content')
<main class="container main-content mfp">

    {{-- ✅ SINGLE header only (removed the duplicate calc-hero block) --}}
    <div class="mfp-header">
        <div>
            <h1 class="mfp-title">Calorie & Macro Calculator</h1>
            <p class="mfp-subtitle">Get a daily target and macros based on your goal. Clean, simple, accurate enough for planning.</p>
        </div>
    </div>

    <div class="mfp-layout">

        {{-- LEFT: INPUTS --}}
        <section class="mfp-card mfp-card--form">
            <div class="mfp-card-header">
                <h2>Your details</h2>
                <p>Fill these in and press calculate.</p>
            </div>

            <form id="calorieForm" class="mfp-form" autocomplete="off">

                <div class="mfp-grid">
                    <div class="mfp-field">
                        <label for="age">Age</label>
                        <input id="age" name="age" type="number" min="16" max="90" required placeholder="Years" />
                    </div>

                    <div class="mfp-field">
                        <label for="sex">Sex</label>
                        <select id="sex" name="sex" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="mfp-field">
                        <label for="height">Height</label>
                        <div class="mfp-inline">
                            <input id="height" name="height" type="number" min="130" max="220" required placeholder="cm" />
                            <span class="mfp-unit">cm</span>
                        </div>
                    </div>

                    <div class="mfp-field">
                        <label for="weight">Weight</label>
                        <div class="mfp-inline">
                            <input id="weight" name="weight" type="number" min="40" max="200" required placeholder="kg" />
                            <span class="mfp-unit">kg</span>
                        </div>
                    </div>

                    <div class="mfp-field">
                        <label for="activity">Activity</label>
                        <select id="activity" name="activity" required>
                            <option value="sedentary">Sedentary</option>
                            <option value="light">Lightly active</option>
                            <option value="moderate">Moderately active</option>
                            <option value="very">Very active</option>
                        </select>
                    </div>

                    <div class="mfp-field">
                        <label for="goal">Goal</label>
                        <select id="goal" name="goal" required>
                            <option value="loss">Lose fat</option>
                            <option value="muscle">Gain muscle</option>
                            <option value="maintain">Maintain</option>
                            <option value="fibre">Higher fibre</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="mfp-btn mfp-btn--primary">
                    Calculate
                </button>

                <div class="mfp-help">
                    <strong>Tip:</strong> This is an estimate. Adjust based on weekly scale trend (+/- 100–200 kcal).
                </div>
            </form>
        </section>

        {{-- RIGHT: RESULTS --}}
        <section class="mfp-card mfp-card--results">
            <div class="mfp-card-header mfp-results-header">
                <div>
                    <h2>Your targets</h2>
                    <p id="calorieResultText">Enter your details and press Calculate.</p>
                </div>
                <span class="mfp-status" id="mfpStatus">Ready</span>
            </div>

            <div id="calorieResults" class="mfp-results">

                <div class="mfp-kpi">
                    <div class="mfp-ring-wrap">
                        <div class="ring-graphic mfp-ring">
                            <div class="ring-inner">
                                <span id="ringCalories">0</span>
                                <small>kcal/day</small>
                            </div>
                        </div>
                        <div class="mfp-ring-note">
                            <div class="mfp-ring-title">Daily calories</div>
                            <div class="mfp-ring-sub">Shown as a % of a 3,500 kcal scale (tweakable)</div>
                        </div>
                    </div>
                </div>

                <div class="mfp-macros">
                    <div class="mfp-macro">
                        <div class="mfp-macro-top">
                            <span>Protein</span>
                            <strong id="macroProtein">–</strong>
                        </div>
                        <div class="mfp-bar"><span class="mfp-fill" id="barProtein"></span></div>
                    </div>

                    <div class="mfp-macro">
                        <div class="mfp-macro-top">
                            <span>Carbs</span>
                            <strong id="macroCarbs">–</strong>
                        </div>
                        <div class="mfp-bar"><span class="mfp-fill" id="barCarbs"></span></div>
                    </div>

                    <div class="mfp-macro">
                        <div class="mfp-macro-top">
                            <span>Fats</span>
                            <strong id="macroFats">–</strong>
                        </div>
                        <div class="mfp-bar"><span class="mfp-fill" id="barFats"></span></div>
                    </div>

                    <div class="mfp-macro mfp-macro--total">
                        <div class="mfp-macro-top">
                            <span>Total calories</span>
                            <strong id="macroCalories">–</strong>
                        </div>
                        <div class="mfp-mini-note">Macros are a practical split — adjust if you follow a specific plan.</div>
                    </div>
                </div>

                <div class="mfp-divider"></div>

                <div class="mfp-plan">
                    <div class="mfp-plan-head">
                        <div>
                            <h3 class="mfp-plan-title">Recommended PrepPal plan</h3>
                            <p id="caloriePlanOutput" class="mfp-plan-text">–</p>
                        </div>
                        <span class="mfp-pill" id="planRecoTag">–</span>
                    </div>

                    <div class="mfp-plan-card">
                        <img id="planRecoImage" class="mfp-plan-img" src="{{ asset('images/preppal-logo.png') }}" alt="Plan preview" />
                        <div class="mfp-plan-info">
                            <div class="mfp-plan-price" id="planRecoPrice">–</div>
                            <div class="mfp-plan-meta">Add this plan, then browse meals & supplements.</div>
                        </div>
                    </div>

                    {{-- ✅ Hidden until calculator.js reveals it after calculate --}}
                    <button
                        type="button"
                        id="recommendedPlanAdd"
                        class="mfp-btn mfp-btn--primary reco-btn add-to-cart"
                        data-name=""
                        data-price=""
                        data-image=""
                        hidden
                        disabled
                    >
                        <span class="reco-btn__icon" aria-hidden="true">🛒</span>

                        <span class="reco-btn__copy">
                            <span class="reco-btn__title">Add recommended plan</span>
                            <span class="reco-btn__subtitle">Add it to your cart in one click</span>
                        </span>
                    </button>

                    <div class="mfp-footnote">
                        <strong>Note:</strong> If you have medical conditions, check with a healthcare professional before changing diet.
                    </div>
                </div>

            </div>
        </section>

    </div>

</main>
@endsection

@push('scripts')
<script src="{{ asset('js/calculator.js') }}"></script>
<script>
  // Tiny UI-only enhancement: macro bar fills (no backend changes)
  (function(){
    const form = document.getElementById('calorieForm');
    if(!form) return;

    function clamp(n,min,max){ return Math.max(min, Math.min(max, n)); }

    form.addEventListener('submit', function(){
      // Values are written by calculator.js after submit.
      setTimeout(() => {
        const p = parseFloat((document.getElementById('macroProtein')?.textContent || '0').replace(/[^\d.]/g,'')) || 0;
        const c = parseFloat((document.getElementById('macroCarbs')?.textContent || '0').replace(/[^\d.]/g,'')) || 0;
        const f = parseFloat((document.getElementById('macroFats')?.textContent || '0').replace(/[^\d.]/g,'')) || 0;

        // Scale bars to sensible maxes for visuals (not “nutrition rules”)
        const pPct = clamp(p / 220, 0, 1) * 100;
        const cPct = clamp(c / 420, 0, 1) * 100;
        const fPct = clamp(f / 140, 0, 1) * 100;

        const bp = document.getElementById('barProtein');
        const bc = document.getElementById('barCarbs');
        const bf = document.getElementById('barFats');

        if(bp) bp.style.width = pPct + '%';
        if(bc) bc.style.width = cPct + '%';
        if(bf) bf.style.width = fPct + '%';

        const status = document.getElementById('mfpStatus');
        if(status) status.textContent = 'Updated';
      }, 0);
    });
  })();
</script>
@endpush
