@extends('layouts.mainheader')

@section('content')
<div class="container">
    <h2 class="section-title">Privacy Policy</h2>
    <div style="background:#fff; border:1px solid #eee; border-radius:10px; padding:20px; box-shadow:0 4px 10px rgba(16,24,40,0.03);">
        <p><strong>Last updated:</strong> February 04, 2026</p>

        <h3>Overview</h3>
        <p>
            This Privacy Policy explains how we collect, use, and disclose information when you use our website and the rights available to you under applicable laws.
            By using the Service, you agree to this Policy.
        </p>

        <h3>Definitions</h3>
        <ul>
            <li><strong>Account</strong>: A unique profile to access parts of the Service.</li>
            <li><strong>Affiliate</strong>: An entity under common control with the Company.</li>
            <li><strong>Company</strong>: IndianCities, Lucknow, India.</li>
            <li><strong>Cookies</strong>: Small files stored on your device to remember preferences and measure usage.</li>
            <li><strong>Country</strong>: Uttar Pradesh, India.</li>
            <li><strong>Device</strong>: Any tool that accesses the Service (computer, phone, tablet).</li>
            <li><strong>Personal Data</strong>: Information that identifies or can identify an individual.</li>
            <li><strong>Service</strong>: The website and related features.</li>
            <li><strong>Service Provider</strong>: Third parties assisting in operating the Service.</li>
            <li><strong>Usage Data</strong>: Technical data like IP, browser, pages visited, timestamps.</li>
            <li><strong>Website</strong>: IndianCities, accessible at https://indiancities.in/.</li>
            <li><strong>You</strong>: The user of the Service.</li>
        </ul>

        <h3>Data We Collect</h3>
        <h4>Personal Data</h4>
        <p>
            We may collect information you voluntarily provide (e.g., contact details, messages) to respond to requests or improve the Service.
        </p>
        <h4>Usage Data</h4>
        <p>
            We automatically collect technical data (IP address, browser type/version, pages visited, time spent, device identifiers).
            On mobile devices, we may also collect device OS and mobile browser type.
        </p>

        <h3>Cookies and Tracking</h3>
        <p>
            We use cookies and similar technologies (beacons, tags, scripts) to operate, measure, and improve the Service.
            Non-essential cookies are used only with your consent where required by law.
        </p>
        <ul>
            <li><strong>Necessary</strong> (session): Enable core features and security.</li>
            <li><strong>Consent/Notice</strong> (persistent): Record your cookie choices.</li>
            <li><strong>Functionality</strong> (persistent): Remember preferences like language.</li>
        </ul>

        <h3>How We Use Personal Data</h3>
        <ul>
            <li>Provide, operate, and improve the Service.</li>
            <li>Manage accounts and respond to requests.</li>
            <li>Contact you about updates or relevant content.</li>
            <li>Analyze usage and the effectiveness of features and campaigns.</li>
            <li>Evaluate business changes (e.g., merger or sale).</li>
        </ul>

        <h3>Sharing of Personal Data</h3>
        <ul>
            <li>With service providers for analytics, support, and operations.</li>
            <li>For business transfers (merger, acquisition, restructuring).</li>
            <li>With affiliates bound by this Policy.</li>
            <li>With business partners for relevant offerings.</li>
            <li>With other users in public areas of the Service.</li>
            <li>With your consent.</li>
        </ul>

        <h3>Retention</h3>
        <p>
            We retain Personal Data only as long as necessary for purposes described here or as required by law.
            Analytics and server logs are typically kept up to 24 months.
        </p>
        <ul>
            <li><strong>Deletion</strong>: Remove data from active systems.</li>
            <li><strong>Backups</strong>: Residual encrypted copies follow backup retention schedules.</li>
            <li><strong>Anonymization</strong>: Convert data to non-identifiable statistics where appropriate.</li>
        </ul>

        <h3>International Transfers</h3>
        <p>
            Data may be processed outside your jurisdiction with appropriate safeguards to protect your information.
        </p>

        <h3>Your Rights</h3>
        <ul>
            <li>Access, correct, or delete Personal Data.</li>
            <li>Withdraw consent for non-essential processing.</li>
            <li>Contact us for details on retention and processing.</li>
        </ul>

        <h3>Disclosure</h3>
        <ul>
            <li>Legal obligations and valid public authority requests.</li>
            <li>Protect rights, safety, and prevent wrongdoing.</li>
            <li>Business transactions (with notice where feasible).</li>
        </ul>

        <h3>Security</h3>
        <p>
            We use commercially reasonable safeguards; however, no method of transmission or storage is fully secure.
        </p>

        <h3>Children’s Privacy</h3>
        <p>
            The Service is not directed to children under 16. If you believe a child provided Personal Data, contact us to remove it.
        </p>

        <h3>Links to Other Websites</h3>
        <p>
            Third-party links may appear on the Service. Review their privacy policies; we are not responsible for their practices.
        </p>

        <h3>Changes to this Policy</h3>
        <p>
            We may update this Policy; the “Last updated” date reflects the latest changes. Continued use signifies acceptance of updates.
        </p>

        <h3>Contact Us</h3>
        <ul>
            <li>Email: admin@indiancities.in</li>
            <li>Website: https://www.indiancities.in/contact-us</li>
        </ul>
    </div>
</div>

<div class="container">
    <div class="divider"></div>
</div>

<!-- Footer with Container -->
<footer class="footer">
    <div class="container">
        <div class="footer-top">
            <div class="footer-logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo">
            </div>
            <h2 class="footer-title">
                <span class="indian">INDIAN</span> <span class="cities">CITIES</span>
            </h2>
        </div>

        <div class="footer-bottom">
            <div class="footer-copyright">
                <span>Copyright © 2025 - Indian Cities - All rights reserved</span>
            </div>
            <div class="footer-social">

                <a href="https://instagram.com" target="_blank" class="social-icon">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://youtube.com" target="_blank" class="social-icon">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="https://twitter.com" target="_blank" class="social-icon">
                    <i class="fab fa-twitter"></i>
                </a>

                <a href="{{ url('/privacy') }}">
                    Privacy Policy
                </a>
                <a href="{{ url('/terms') }}">
                    Terms of Service
                </a>
            </div>
        </div>
    </div>
</footer>
@endsection
