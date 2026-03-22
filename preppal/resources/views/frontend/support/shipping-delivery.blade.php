@extends('layouts.app')

@section('title', 'Shipping & Delivery')

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
      <h1>Shipping & Delivery</h1>
      <p class="pp-info-lead">
        PrepPal aims to process and dispatch orders quickly and securely. Delivery times may vary
        depending on stock availability, courier demand, and your location within the United Kingdom.
      </p>

      <div class="pp-info-grid">
        <div class="pp-info-block">
          <h2>Processing Times</h2>
          <p>
            Orders are typically processed within 1–2 working days. Orders placed on weekends or public
            holidays are processed on the next available working day.
          </p>
        </div>

        <div class="pp-info-block">
          <h2>Delivery Estimates</h2>
          <p>
            Standard UK delivery usually arrives within 2–5 working days after dispatch. During busy
            periods, delivery may take slightly longer.
          </p>
        </div>

        <div class="pp-info-block">
          <h2>Order Tracking</h2>
          <p>
            Where tracking is available, customers will receive updates once the order has been dispatched.
            Please ensure your email details are correct when ordering.
          </p>
        </div>

        <div class="pp-info-block">
          <h2>Delivery Issues</h2>
          <p>
            If your parcel is delayed, damaged, or missing, please contact the PrepPal support team through
            the contact page so we can help resolve the issue.
          </p>
        </div>
      </div>

      <a class="pp-info-back" href="{{ route('home') }}">← Back to Home</a>
    </div>
  </div>
</section>
@endsection