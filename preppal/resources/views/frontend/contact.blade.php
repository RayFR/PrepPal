<!--
  Students & IDs: Agraj Khanna (240195519)/ Gurpreet Singh Sidhu (230237915)
  File: contact.blade.php
  Description: Contact Page
  Date: Dec 2025
-->

@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

<div class="pp-contact-page">

    {{-- HERO --}}
    <section class="pp-contact-hero">
        <div class="pp-contact-hero__inner">
            <span class="pp-contact-eyebrow">Support • Orders • Meal Help</span>
            <div class="pp-contact-hero__brand">
    <img
        src="{{ asset('images/preppal-logo.png') }}"
        alt="PrepPal"
        class="pp-contact-hero__brand-logo"
    >
    <h1 class="pp-contact-hero__title">Contact PrepPal</h1>
</div>
            <p class="pp-contact-hero__text">
                Questions about orders, meals, delivery, billing, or your account?
                Our team usually replies within 24 hours.
            </p>

            <div class="pp-contact-hero__badges">
                <span class="pp-contact-badge">Replies within 24h</span>
                <span class="pp-contact-badge">Order & delivery help</span>
                <span class="pp-contact-badge">Meal & account support</span>
            </div>
        </div>
    </section>

    {{-- MAIN CONTENT --}}
    <div class="pp-contact-shell">
        <div class="pp-contact-grid">

            {{-- LEFT: FORM CARD --}}
            <section class="pp-contact-card pp-contact-card--form">
                <div class="pp-contact-card__head">
                    <h2 class="pp-contact-title">Send Us a Message</h2>
                    <p class="pp-contact-subtext">
                        Tell us what you need help with and we’ll get back to you by email.
                    </p>
                </div>

                @if(session('success'))
                    <div class="pp-contact-alert pp-contact-alert--success" role="status" aria-live="polite">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="pp-contact-alert pp-contact-alert--error" role="alert">
                        Please check the form and correct the highlighted fields.
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="pp-contact-form" novalidate>
                    @csrf

                    <div class="pp-contact-form__grid">
                        <div class="pp-contact-field">
                            <label for="contact_name">Your Name</label>
                            <input
                                id="contact_name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                placeholder="John Doe"
                                class="@error('name') is-invalid @enderror"
                            >
                            @error('name')
                                <small class="pp-contact-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="pp-contact-field">
                            <label for="contact_email">Email Address</label>
                            <input
                                id="contact_email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="john@example.com"
                                class="@error('email') is-invalid @enderror"
                            >
                            @error('email')
                                <small class="pp-contact-error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="pp-contact-field">
                        <label for="contact_subject">What do you need help with?</label>
                        <select id="contact_subject" name="subject" class="@error('subject') is-invalid @enderror">
                            <option value="">Choose a topic</option>
                            <option value="Order question" {{ old('subject') === 'Order question' ? 'selected' : '' }}>Order question</option>
                            <option value="Delivery or tracking" {{ old('subject') === 'Delivery or tracking' ? 'selected' : '' }}>Delivery or tracking</option>
                            <option value="Meal or dietary support" {{ old('subject') === 'Meal or dietary support' ? 'selected' : '' }}>Meal or dietary support</option>
                            <option value="Billing or payment" {{ old('subject') === 'Billing or payment' ? 'selected' : '' }}>Billing or payment</option>
                            <option value="Account support" {{ old('subject') === 'Account support' ? 'selected' : '' }}>Account support</option>
                            <option value="Other" {{ old('subject') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('subject')
                            <small class="pp-contact-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="pp-contact-field">
                        <label for="contact_message">Message</label>
                        <textarea
                            id="contact_message"
                            name="message"
                            rows="7"
                            required
                            placeholder="Tell us what happened, include your order number if relevant, and we’ll help as quickly as possible."
                            class="@error('message') is-invalid @enderror"
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <small class="pp-contact-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="pp-contact-actions">
                        <button class="pp-contact-btn" type="submit">Send Message</button>
                        <p class="pp-contact-helper">
                            We’ll reply to the email address you provide above.
                        </p>
                    </div>
                </form>

                <div class="pp-contact-inline-note">
                    <strong>Prefer direct email?</strong>
                    <a href="mailto:support@preppal.com">support@preppal.com</a>
                </div>
            </section>

            {{-- RIGHT: INFO COLUMN --}}
            <aside class="pp-contact-side">

                <div class="pp-contact-card pp-contact-card--info">
                    <h3 class="pp-contact-side__title">Why Contact Us?</h3>

                    <div class="pp-contact-mini-list">
                        <div class="pp-contact-mini-item">
                            <span class="pp-contact-mini-item__icon">📦</span>
                            <div>
                                <strong>Order questions & changes</strong>
                                <p>Help with active orders, updates, and product issues.</p>
                            </div>
                        </div>

                        <div class="pp-contact-mini-item">
                            <span class="pp-contact-mini-item__icon">🥗</span>
                            <div>
                                <strong>Meal & dietary support</strong>
                                <p>Questions about meal choices, ingredients, and nutrition.</p>
                            </div>
                        </div>

                        <div class="pp-contact-mini-item">
                            <span class="pp-contact-mini-item__icon">💳</span>
                            <div>
                                <strong>Billing & payments</strong>
                                <p>Support for payment problems, charges, and account issues.</p>
                            </div>
                        </div>

                        <div class="pp-contact-mini-item">
                            <span class="pp-contact-mini-item__icon">🚚</span>
                            <div>
                                <strong>Delivery & tracking</strong>
                                <p>Late order, tracking updates, or delivery concerns.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pp-contact-card pp-contact-card--stack">
                    <div class="pp-contact-stack-item">
                        <span class="pp-contact-stack-item__kicker">Support hours</span>
                        <h4>Mon – Sat</h4>
                        <p>9:00 AM – 8:00 PM</p>
                    </div>

                    <div class="pp-contact-stack-item">
                        <span class="pp-contact-stack-item__kicker">Fastest help</span>
                        <h4>Include your order number</h4>
                        <p>This helps us resolve delivery and order issues much faster.</p>
                    </div>

                    <div class="pp-contact-stack-item">
                        <span class="pp-contact-stack-item__kicker">Direct email</span>
                        <h4>support@preppal.com</h4>
                        <p>Best for detailed requests or follow-up support.</p>
                    </div>
                </div>
            </aside>

        </div>

        {{-- FAQ SECTION --}}
        <section class="pp-contact-faq">
            <div class="pp-contact-faq__head">
                <span class="pp-contact-eyebrow">Quick help</span>
                <h2>Frequently Asked Questions</h2>
                <p>Before sending a message, these quick answers may help.</p>
            </div>

            <div class="pp-contact-faq__grid">
                <div class="pp-contact-faq__item">
                    <h3>How quickly will I get a reply?</h3>
                    <p>We usually respond within 24 hours during support hours.</p>
                </div>

                <div class="pp-contact-faq__item">
                    <h3>What should I include for delivery issues?</h3>
                    <p>Add your order number, delivery date, and a short description of the issue.</p>
                </div>

                <div class="pp-contact-faq__item">
                    <h3>Can I ask about meals or dietary preferences?</h3>
                    <p>Yes — use the contact form and choose meal or dietary support in the topic list.</p>
                </div>

                <div class="pp-contact-faq__item">
                    <h3>What if my payment failed?</h3>
                    <p>Send us your account email and the approximate payment time so we can check it faster.</p>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection