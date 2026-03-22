@extends('layouts.app')

@section('title', 'Returns')

@push('styles')
<style>
  .pp-info-page {
    min-height: 100vh;
    background:
      radial-gradient(circle at top left, rgba(255,140,0,0.16), transparent 35%),
      linear-gradient(180deg, #050816 0%, #08101f 45%, #0b1426 100%);
    color: #f5f7fb;
    padding: 3rem 1.25rem 5rem;
  }

  .pp-info-wrap {
    max-width: 1100px;
    margin: 0 auto;
  }

  .pp-info-card {
    background: rgba(10, 16, 31, 0.82);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 24px 60px rgba(0,0,0,0.28);
    backdrop-filter: blur(12px);
  }

  .pp-info-kicker {
    display: inline-block;
    font-size: .82rem;
    font-weight: 800;
    letter-spacing: .16em;
    text-transform: uppercase;
    color: #ff9d2f;
    margin-bottom: 1rem;
  }

  .pp-info-card h1 {
    font-size: clamp(2rem, 4vw, 3.4rem);
    line-height: 1.05;
    margin: 0 0 1rem;
    color: #ffffff;
  }

  .pp-info-lead {
    font-size: 1.05rem;
    line-height: 1.8;
    color: rgba(255,255,255,0.82);
    margin-bottom: 2rem;
    max-width: 760px;
  }

  .pp-info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1.25rem;
  }

  .pp-info-block {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 18px;
    padding: 1.25rem;
  }

  .pp-info-block h2 {
    font-size: 1.05rem;
    margin: 0 0 .8rem;
    color: #ffb25b;
  }

  .pp-info-block p {
    margin: 0;
    line-height: 1.7;
    color: rgba(255,255,255,0.82);
  }

  .pp-info-back {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    margin-top: 1.5rem;
    color: #ff9d2f;
    text-decoration: none;
    font-weight: 700;
  }

  .pp-info-back:hover {
    color: #ffc27a;
  }

  @media (max-width: 768px) {
    .pp-info-grid {
      grid-template-columns: 1fr;
    }

    .pp-info-card {
      padding: 1.4rem;
      border-radius: 20px;
    }
  }
</style>
@endpush

@section('content')
<section class="pp-info-page">
  <div class="pp-info-wrap">
    <div class="pp-info-card">
      <span class="pp-info-kicker">Support</span>
      <h1>Returns</h1>
      <p class="pp-info-lead">
        We want customers to be happy with their PrepPal order. If there is an issue with your purchase,
        please contact us as soon as possible so we can review the situation and advise on the next steps.
      </p>

      <div class="pp-info-grid">
        <div class="pp-info-block">
          <h2>Eligible Returns</h2>
          <p>
            Unopened and unused items may be eligible for return within 14 days of delivery, subject to
            hygiene, food safety, and product condition requirements.
          </p>
        </div>

        <div class="pp-info-block">
          <h2>Non-Returnable Items</h2>
          <p>
            For safety and quality reasons, opened consumables, customised items, and certain perishable
            products may not be eligible for return unless faulty.
          </p>
        </div>

        <div class="pp-info-block">
          <h2>Faulty or Damaged Orders</h2>
          <p>
            If an item arrives damaged or incorrect, please contact us promptly with your order details and,
            where possible, supporting photos.
          </p>
        </div>

        <div class="pp-info-block">
          <h2>Refunds</h2>
          <p>
            Approved refunds are usually processed back to the original payment method. Processing times can
            vary depending on your bank or payment provider.
          </p>
        </div>
      </div>

      <a class="pp-info-back" href="{{ route('home') }}">← Back to Home</a>
    </div>
  </div>
</section>
@endsection