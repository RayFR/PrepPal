@extends('layouts.app')

@section('title', 'Privacy Policy')

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
      <h1>Privacy Policy</h1>

      <div class="pp-info-text">
        <p>
          PrepPal respects your privacy and is committed to protecting your personal information.
          This page explains how we may collect, use, and store your data when you browse the site,
          place an order, or contact our team.
        </p>

        <h2>Information We Collect</h2>
        <p>
          We may collect information such as your name, email address, delivery details, and order
          information when you use our services.
        </p>

        <h2>How We Use Your Data</h2>
        <p>
          Your information may be used to process orders, provide customer support, improve our services,
          and send updates where you have agreed to receive them.
        </p>

        <h2>Data Protection</h2>
        <p>
          We take reasonable steps to protect your personal information and limit access to authorised
          persons only.
        </p>

        <h2>Marketing</h2>
        <p>
          If you subscribe to our newsletter, you may receive promotional emails from PrepPal. You can
          unsubscribe at any time.
        </p>

        <h2>Your Rights</h2>
        <p>
          Depending on applicable law, you may have rights to access, correct, or request deletion of
          your personal data.
        </p>
      </div>

      <a class="pp-info-back" href="{{ route('home') }}">← Back to Home</a>
    </div>
  </div>
</section>
@endsection