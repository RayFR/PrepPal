<!--
  Students & IDs: Agraj Khanna (240195519)/ Gurpreet Singh Sidhu (230237915)
  File: contact.blade.php
  Description: Contact Page
  Date: Dec 2025
-->

@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

<div class="contact-hero">
    <div class="contact-hero-inner">
        <h1>Contact PrepPal</h1>
        <p>Have a question about meals, delivery, or your account? We're here to help.</p>
    </div>
</div>

<div class="contact-wrapper">

    <div class="contact-card">
        <h2 class="contact-title">Send Us a Message</h2>
        <p class="contact-subtext">Our support team responds within 24 hours.</p>

        {{-- Success message placeholder --}}
        @if(session('success'))
            <div class="contact-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
            @csrf

            <label>Your Name</label>
            <input type="text" name="name" required placeholder="John Doe">

            <label>Email Address</label>
            <input type="email" name="email" required placeholder="john@example.com">

            <label>Message</label>
            <textarea name="message" rows="5" required placeholder="How can we help?"></textarea>

            <button class="contact-btn" type="submit">Send Message</button>
        </form>

        <p class="contact-note">
            Prefer email? Reach us at 
            <span class="highlight">support@preppal.com</span>
        </p>
    </div>

    <div class="contact-info-card">
        <h3>Why Contact Us?</h3>

        <ul class="contact-info-list">
            <li>📦 Order questions & changes</li>
            <li>🥗 Meal or dietary inquiries</li>
            <li>💳 Billing & payment support</li>
            <li>🚚 Delivery & tracking issues</li>
            <li>👤 Account support</li>
        </ul>

        <p class="contact-info-footer">We're here to help you every step of the way.</p>
    </div>

</div>

@endsection
