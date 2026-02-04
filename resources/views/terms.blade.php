@extends('layouts.mainheader')

@section('content')
<div class="container">
    <h2 class="section-title">Terms of Service</h2>
    <div style="background:#fff; border:1px solid #eee; border-radius:10px; padding:20px; box-shadow:0 4px 10px rgba(16,24,40,0.03);">
        <p><strong>Last updated:</strong> February 04, 2026</p>
        <p>Please read these Terms carefully before using the Service.</p>

        <h3>Definitions</h3>
        <ul>
            <li><strong>Affiliate</strong>: An entity under common control with a party.</li>
            <li><strong>Country</strong>: Uttar Pradesh, India.</li>
            <li><strong>Company</strong>: IndianCities, Lucknow, India.</li>
            <li><strong>Device</strong>: Any device that accesses the Service.</li>
            <li><strong>Service</strong>: The website and related features.</li>
            <li><strong>Terms</strong>: These Terms and any referenced documents.</li>
            <li><strong>Third-Party Social Media Service</strong>: External services linked or embedded.</li>
            <li><strong>Website</strong>: https://indiancities.in/</li>
            <li><strong>You</strong>: The individual or entity using the Service.</li>
        </ul>

        <h3>Acknowledgment</h3>
        <p>
            These Terms govern your use of the Service and form the agreement between you and the Company.
            By accessing or using the Service, you agree to be bound by these Terms. If you do not agree, do not use the Service.
            You represent that you are at least 18 years old.
            Your use is also subject to our Privacy Policy.
        </p>

        <h3>Links to Other Websites</h3>
        <p>
            The Service may contain links to third-party websites or services. We do not control and are not responsible for their content or practices.
            Review any third-party terms and privacy policies before using their services.
        </p>

        <h3>Third-Party Social Media Services</h3>
        <p>
            Content or services from third-party social platforms may be displayed or linked. We do not endorse or assume responsibility for them.
            Your use of such services is governed by their terms and policies.
        </p>

        <h3>Termination</h3>
        <p>
            We may suspend or terminate access immediately, without prior notice, for any breach of these Terms or for any reason.
            Upon termination, your right to use the Service ceases immediately.
        </p>

        <h3>Limitation of Liability</h3>
        <p>
            To the maximum extent permitted by law, the Company and its suppliers are not liable for indirect, incidental, or consequential damages.
            In all cases, liability is limited to the amount you paid through the Service or USD 100 if you have not purchased anything.
        </p>

        <h3>"AS IS" and "AS AVAILABLE" Disclaimer</h3>
        <p>
            The Service is provided without warranties of any kind, express or implied, including merchantability, fitness for a particular purpose, and non-infringement.
            We do not warrant error-free or uninterrupted operation.
        </p>

        <h3>Governing Law</h3>
        <p>
            These Terms are governed by the laws of the Country, excluding conflict-of-law rules, and may also be subject to other local regulations.
        </p>

        <h3>Dispute Resolution</h3>
        <p>
            If you have a dispute or concern, contact us to try to resolve it informally first.
        </p>

        <h3>EU Users</h3>
        <p>
            If you are an EU consumer, mandatory consumer protections of your country of residence apply.
        </p>

        <h3>US Compliance</h3>
        <p>
            You confirm you are not in a US-embargoed country nor on US prohibited lists.
        </p>

        <h3>Severability and Waiver</h3>
        <p>
            If any provision is invalid, it will be adjusted to achieve its intent while the rest remain in effect. Failure to enforce a right is not a waiver.
        </p>

        <h3>Translation</h3>
        <p>
            If translated, the English version prevails in case of a dispute.
        </p>

        <h3>Changes to These Terms</h3>
        <p>
            We may modify these Terms at any time. Material changes will be noticed where reasonable. Continued use after changes means acceptance.
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
