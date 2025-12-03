@extends('layouts.app')

@section('title', 'Contact')

@section('content')

<div class="container main-content">

    <h2>Contact PrepPal</h2>
    <p>If you have questions about meal plans, subscriptions, or your account, send us a message below.</p>

    <section class="card contact-card">
        <form id="contactForm" class="contact-form" autocomplete="off">
            @csrf

            <label for="contactName">Name</label>
            <input id="contactName" name="name" type="text" required placeholder="Your name" />

            <label for="contactEmail" style="margin-top:.75rem;">Email</label>
            <input id="contactEmail" name="email" type="email" required placeholder="you@example.com" />

            <label for="contactMessage" style="margin-top:.75rem;">Message</label>
            <textarea id="contactMessage" name="message" rows="5" required placeholder="How can we help?"></textarea>

            <button class="cta" type="submit" style="margin-top:1.1rem;">Send message</button>
        </form>

        <p class="contact-note">
            Your message is stored securely as part of this demo project (localStorage only).
            In a real deployment this would send directly to the support inbox.
        </p>
    </section>

</div>

@endsection

@push('scripts')
<script>
    // Simple localStorage-based "inbox"
    (function () {
        var CONTACT_KEY = 'preppal_contactMessages';
        var form = document.getElementById('contactForm');
        if (!form) return;

        function loadMessages() {
            try {
                var raw = localStorage.getItem(CONTACT_KEY);
                if (!raw) return [];
                var list = JSON.parse(raw);
                return Array.isArray(list) ? list : [];
            } catch (e) {
                return [];
            }
        }

        function saveMessages(list) {
            localStorage.setItem(CONTACT_KEY, JSON.stringify(list || []));
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var name = document.getElementById('contactName').value.trim();
            var email = document.getElementById('contactEmail').value.trim();
            var message = document.getElementById('contactMessage').value.trim();
            if (!name || !email || !message) return;

            var list = loadMessages();
            list.push({
                id: 'msg_' + Date.now(),
                name: name,
                email: email,
                message: message,
                createdAt: new Date().toISOString()
            });
            saveMessages(list);

            alert('Thank you! Your message has been sent.');
            form.reset();
        });
    })();
</script>
@endpush
