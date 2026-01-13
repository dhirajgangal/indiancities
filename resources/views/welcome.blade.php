<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>इण्डियन सिटीज - भारत के शहरों का इतिहास</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon_32x32.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --color-primary: #FF7700;
            --color-secondary: #FF7700;
            --color-text: #333;
            --color-light-bg: #fff5f0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: var(--color-text); overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        .header { background-color: #fffdfd; width: 100%; }
        .header-top { display: flex; justify-content: space-between; align-items: center; padding-block: 8px; font-size: 12px; border-top: 2px solid #202124; border-bottom: 2px solid #202124; }
        .header-middle { display: grid; place-items: center; padding-block: 24px; min-height: 120px; position: relative; }
        .header-logo { position: absolute; left: 24px; top: 50%; transform: translateY(-50%); }
        .header-logo img { width: 107px; height: 107px; }
        .header-title h1 { font-weight: 900; font-size: 80px; line-height: 1; margin: 0; text-align: center; }
        .title-orange { color: #FF7700; }
        .title-teal { color: #128488; }
        .header-nav { display: flex; justify-content: center; gap: 24px; padding: 12px 0; border-top: 2px solid #202124; border-bottom: 2px solid #202124; flex-wrap: wrap; }
        .nav-link { font-weight: 700; font-size: 25px; color: #202124; transition: color 0.2s ease; }
        .nav-link:hover { color: #E63946; }
        .hero-carousel { margin-top: 10px; }
        .carousel-item { height: 707px; }
        .carousel-item img { width: 100%; height: 100%; object-fit: cover; }
        .container { max-width: 1375px; padding: 0 12px; }
        .section-title { font-weight: 900; font-size: 40px; color: #E63946; padding: 50px 0; margin: 0; }
        .city-history { display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 2px solid #202124; }
        .city-cards-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px; padding: 20px 0; }
        .city-card { background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden; display: flex; flex-direction: row; height: 220px; transition: transform 0.3s; }
        .city-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
        .city-card-image { width: 40%; height: 100%; object-fit: cover; }
        .city-card-body { display: flex; flex-direction: column; padding: 20px; flex: 1; }
        .city-card-title { font-weight: 700; font-size: 20px; color: #000000; margin-bottom: 20px; }
        .city-card-description { font-weight: 400; font-size: 14px; line-height: 22px; color: #000000; }
        .info-banner { background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%); margin: 40px 0; border-radius: 8px; padding: 20px; display: flex; justify-content: center; align-items: center; gap: 20px; }
        .info-banner-text { font-weight: 700; font-size: 30px; color: #000000; text-align: center; }
        .divider { width: 100%; height: 2px; background: #202124; margin: 40px 0; }
        .footer { background-color: #fffdfd; margin-top: auto; max-width: 1375px; margin-left: auto; margin-right: auto; border-top: 1px solid rgba(94, 82, 64, 0.2); }
        .footer-top { display: flex; align-items: center; justify-content: flex-start; padding: 20px; border-bottom: 1px solid rgba(94, 82, 64, 0.2); min-height: 140px; position: relative; }
        .footer-logo { gap: 20px; }
        .footer-logo img { height: 113px; width: auto; }
        .footer-title { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); font-weight: 900; font-size: 52px; text-align: center; }
        .footer-title .indian { color: #FF7700; }
        .footer-title .cities { color: #21808d; }
        .footer-bottom { display: flex; justify-content: space-between; padding: 12px 16px; border-top: 2px solid #202124; border-bottom: 2px solid #202124; }
        .social-icon { color: #13343b; font-size: 20px; transition: color 0.2s; margin: 0 8px; }
        .social-icon:hover { color: #21808d; }
        @media (max-width: 768px) {
            .header-title h1 { font-size: 40px; }
            .carousel-item { height: 300px; }
            .city-cards-grid { grid-template-columns: 1fr; }
            .city-card { flex-direction: column; height: auto; }
            .city-card-image { width: 100%; height: 200px; }
            .section-title { font-size: 24px; }
            .header-nav { gap: 15px; }
            .nav-link { font-size: 14px; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-top">
            <div class="header-info">
                <span>02 अक्टूबर 2025, शुक्रवार</span>
            </div>
            <div class="header-search">
                <span>द मेनू</span>
            </div>
        </div>

        <div class="header-middle">
            <div class="header-logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Indian Cities Logo">
            </div>
            <div class="header-title">
                <h1><span class="title-orange">इण्डियन</span> <span class="title-teal">सिटीज</span></h1>
            </div>
        </div>

        <nav class="header-nav">
            <a href="#" class="nav-link">दिल्ली</a>
            <a href="#" class="nav-link">बेंगलोर</a>
            
        </nav>
    </header>

    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('assets/header1.png') }}" class="d-block w-100" alt="Header 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/header2.png') }}" class="d-block w-100" alt="Header 2">
            </div>
        </div>
    </div>

    <!-- City Cards Section -->
    <div class="container">
        @php $cities = $cities ?? collect(); @endphp
        <div class="city-history">
            <h2 class="section-title">सिटीज हिस्ट्री</h2>
            <p>View All <span><i class="bi bi-arrow-right-circle"></i></span></p>
        </div>

        <div class="city-cards-grid">
            @forelse($cities as $city)
                <div class="city-card">
                    @if($city->image)
                        <img src="{{ asset('storage/' . $city->image) }}" alt="{{ $city->name }}" class="city-card-image">
                    @endif
                    <div class="city-card-body">
                        <h3 class="city-card-title">{{ $city->name }}</h3>
                        <p class="city-card-description">
                            {{ Str::limit($city->description, 150) }}
                        </p>
                    </div>
                </div>
            @empty
                <p>No cities available.</p>
            @endforelse
        </div>
    </div>

    <div class="divider"></div>

    <!-- Info Banner -->
    <div class="container">
        <div class="info-banner">
            <div class="info-banner-text">
                भारत के इन शहरों का हजारों साल पुराना इतिहास है। खासियत ऐसी कि आज भी है अनुपाठ
            </div>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Footer -->
    <footer class="footer">
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
                <span>Copyright © 2024 - Indian Cities - All rights reserved</span>
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
            </div>
        </div>
    </footer>
</body>
</html>
