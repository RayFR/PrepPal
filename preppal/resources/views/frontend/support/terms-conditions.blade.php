@extends('layouts.app')

@section('title', 'Terms & Conditions')

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

  .pp-info-text {
    display: grid;
    gap: 1rem;
  }

  .pp-info-text p {
    margin: 0;
    line-height: 1.8;
    color: rgba(255,255,255,0.82);
  }

  .pp-info-text h2 {
    margin: 1rem 0 .25rem;
    font-size: 1.05rem;
    color: #ffb25b;
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
      <span class="pp-info-kicker">Legal</span>
      <h1>Terms & Conditions</h1>

      <div class="pp-info-text">
        <p>
          By using the PrepPal website, you agree to the terms and conditions set out on this page.
          These terms apply to browsing the site, purchasing products, and using PrepPal services.
        </p>

        <h2>Products and Availability</h2>
        <p>
          All products are subject to availability. We reserve the right to update, remove, or amend
          products and pricing at any time without prior notice.
        </p>

        <h2>Orders</h2>
        <p>
          When you place an order, you agree that the details provided are accurate and complete.
          PrepPal reserves the right to cancel or refuse an order where necessary.
        </p>

        <h2>Pricing</h2>
        <p>
          Prices shown on the website are displayed in the relevant currency settings available on the
          platform and may be updated from time to time.
        </p>

        <h2>Account Responsibility</h2>
        <p>
          If you create an account, you are responsible for maintaining the confidentiality of your login
          details and for activities carried out under your account.
        </p>

        <h2>Liability</h2>
        <p>
          PrepPal will take reasonable care in providing its services, but cannot guarantee uninterrupted
          access to the website at all times.
        </p>
      </div>

      <a class="pp-info-back" href="{{ route('home') }}">← Back to Home</a>
    </div>
  </div>
</section>
@endsection