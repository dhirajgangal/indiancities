<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>इंडियन सिटीज - भारत के शहरों का इतिहास</title>
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
        
        /* Container */
        .container { max-width: 1375px; padding: 0 12px; margin: 0 auto; }
        
        /* Header */
        .header { background-color: #fffdfd; width: 100%; }
        .header-top {
            display: flex; justify-content: space-between; align-items: center;
            padding-block: 8px; font-size: 12px; border-top: 2px solid #202124;
            border-bottom: 2px solid #202124;
        }
        
        .header-middle {
            display: grid; place-items: center; padding-block: 24px;
            min-height: 120px; position: relative;
        }
        
        .header-logo {
            position: absolute; left: 24px; top: 50%;
            transform: translateY(-50%);
        }
        
        .header-logo img { width: 107px; height: 107px; }
        
        .header-title h1 {
            font-weight: 900; font-size: 80px; line-height: 1;
            margin: 0; text-align: center;
        }
        
        .title-orange { color: #FF7700; }
        .title-teal { color: #128488; }
        
        /* Navigation */
        .header-nav {
            display: flex; justify-content: center; gap: 24px;
            padding: 12px 0; border-top: 2px solid #202124;
            border-bottom: 2px solid #202124; flex-wrap: wrap;
        }
        
        .nav-link {
            font-weight: 700; font-size: 25px; color: #202124;
            transition: color 0.2s ease, border-color 0.2s ease;
            border-bottom: 3px solid transparent;
            padding-bottom: 5px;
        }
        
        .nav-link:hover { color: #E63946; }
        
        .nav-link.active {
            color: #FF7700;
            border-bottom-color: #FF7700;
        }
        
        /* Hero Carousel - Full Width */
        .hero-carousel { margin-top: 10px; width: 100%; }
        .carousel-item { height: 420px; }
        .carousel-item img { width: 100%; height: 100%; object-fit: cover; }
        .carousel-indicators { bottom: 18px; }
        .carousel-indicators [data-bs-target] { width: 12px; height: 12px; border-radius: 50%; background-color: rgba(255,255,255,0.6); border: 1px solid rgba(0,0,0,0.12); transition: background-color .15s, transform .15s; }
        .carousel-indicators .active { background-color: #ffffff; transform: scale(1.1); }
        @media (max-width: 767px) {
            .carousel-indicators [data-bs-target] { width: 10px; height: 10px; }
        }
        .carousel-caption h5 { color: #fff; font-size: 28px; font-weight:800; margin:0 0 6px; }
        .carousel-caption p { color: #fff; font-size:16px; margin:0; opacity:0.95; }
        @media (max-width: 767px) {
            .carousel-caption { left: 16px; right: 16px; bottom: 16px; max-width: calc(100% - 32px); padding:12px; }
            .carousel-caption h5 { font-size:18px; }
            .carousel-caption p { font-size:14px; }
            .carousel-item { height: 300px; }
        }
        
        /* Section Title */
        .section-title {
            font-weight: 900; font-size: 40px; color: #E63946;
            padding: 50px 0; margin: 0;
        }
        
        .city-history {
            display: flex; justify-content: space-between; align-items: center;
            padding: 10px; border-bottom: 2px solid #202124;
        }
        
        /* City Cards Grid */
        .city-cards-grid {
            display: grid; grid-template-columns: repeat(2, 1fr);
            gap: 25px; padding: 20px 0;
        }
        
        .city-card {
            background: white; border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;
            display: flex; flex-direction: row; height: 220px;
            transition: transform 0.3s;
        }
        
        .city-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
        
        .city-card-image { width: 40%; height: 100%; object-fit: cover; }
        
        .city-card-body { display: flex; flex-direction: column; padding: 20px; flex: 1; }
        
        .city-card-title {
            font-weight: 700; font-size: 20px; color: #000000; margin-bottom: 20px;
        }
        
        .city-card-description {
            font-weight: 400; font-size: 14px; line-height: 22px; color: #000000;
        }
        
        /* Info Banner */
        .info-banner {
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            margin: 40px 0; border-radius: 8px; padding: 28px 24px;
            display: flex; justify-content: center; align-items: center;
            gap: 24px; flex-wrap: nowrap;
        }

        .info-banner-img {
            width: 220px; height: 220px; object-fit: cover; flex: 0 0 220px;
            border-radius: 8px; box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        }

        .info-banner-text-container { flex: 1; min-width: 0; padding: 0 12px; }

        .info-banner-text { font-weight: 900; font-size: 34px; line-height: 1.15; color: #000000; text-align: center; margin: 0; }
        
        /* Divider */
        .divider {
            width: 100%; height: 2px;
            background: #202124; margin: 40px 0;
        }

        /* City section: header and list styles */
        .city-header {
            display: flex; justify-content: space-between; align-items: center;
            gap: 16px; margin-bottom: 18px; flex-wrap: wrap;
        }
        .city-header-title {
            display: inline-block; background: #2563eb; color: #fff; padding: 10px 18px;
            border-radius: 8px; font-weight: 700; font-size: 18px; text-decoration: none;
        }
        .city-header-menu { list-style: none; margin: 0; padding: 0; display: flex; gap: 22px; align-items: center; }
        .city-header-menu li { margin: 0; }
        .city-header-menu li a { color: #202124; text-decoration: none; font-weight: 600; }
        .city-header-menu li a:hover { color: #2563eb; }

        /* City list: responsive grid */
        .city-list-grid { display: grid; grid-template-columns: 1fr; gap: 18px; padding: 12px 0; align-items: start; }
        .city-list-item {
            display: flex; gap: 16px; align-items: center; background: #fff;
            border: 1px solid #eee; padding: 14px; border-radius: 10px;
            box-shadow: 0 4px 10px rgba(16,24,40,0.03);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }
        .city-list-image { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; flex: 0 0 80px; }
        .city-list-content h4 { font-size: 16px; margin: 0; line-height: 1.3; }

        .city-list-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(16,24,40,0.09);
            border-color: rgba(37,99,235,0.12);
        }

        .city-list-image { transition: transform 0.22s ease; }
        .city-list-item:hover .city-list-image { transform: scale(1.06); }

        @media (min-width: 769px) {
            .city-list-grid { grid-template-columns: repeat(2, 1fr); }
            .city-list-image { width: 96px; height: 96px; flex: 0 0 96px; }
            .city-list-content h4 { font-size: 18px; }
        }

        @media (min-width: 1200px) {
            .city-list-grid { grid-template-columns: repeat(3, 1fr); }
            .city-list-image { width: 110px; height: 110px; flex: 0 0 110px; }
            .city-list-content h4 { font-size: 18px; }
        }

        .view-more-btn { margin-top: 12px; display: flex; justify-content: center; }
        .view-more-btn a { background: var(--color-primary); color: #fff; padding: 10px 18px; border-radius: 8px; font-weight: 700; }

        /* Video grid + cards */
        .video-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; padding: 20px 0; }
        .video-card { background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #eee; box-shadow: 0 6px 20px rgba(16,24,40,0.04); transition: transform 0.22s ease, box-shadow 0.22s ease; }
        .video-card:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(16,24,40,0.08); }

        .video-thumbnail { position: relative; width: 100%; height: 0; padding-top: 56.25%; background: #000; }
        .video-el { position: absolute; inset: 0; }
        .video-el iframe { width: 100%; height: 100%; border: 0; display: block; }

        .play-button { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); width: 64px; height: 64px; background: rgba(255,0,0,0.95); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 28px; box-shadow: 0 6px 18px rgba(0,0,0,0.25); }
        .video-info { padding: 14px 16px; }
        .video-info p { margin: 0; font-size: 16px; color: #111827; }

        @media (max-width: 1199px) {
            .video-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 767px) {
            .video-grid { grid-template-columns: 1fr; }
            .play-button { width: 56px; height: 56px; font-size: 24px; }
        }

        
        /* Footer */
        .footer {
            background-color: #fffdfd; margin-top: auto;
            border-top: 1px solid rgba(94, 82, 64, 0.2);
        }
        
        .footer-top {
            display: flex; align-items: center; justify-content: flex-start;
            padding: 20px; border-bottom: 1px solid rgba(94, 82, 64, 0.2);
            min-height: 140px; position: relative;
        }
        
        .footer-logo { gap: 20px; }
        .footer-logo img { height: 113px; width: auto; }
        
        .footer-title {
            position: absolute; left: 50%; top: 50%;
            transform: translate(-50%, -50%); font-weight: 900;
            font-size: 52px; text-align: center;
        }
        
        .footer-title .indian { color: #FF7700; }
        .footer-title .cities { color: #21808d; }
        
        .footer-bottom {
            display: flex; justify-content: space-between;
            padding: 12px 16px; border-top: 2px solid #202124;
            border-bottom: 2px solid #202124;
        }
        
        .social-icon {
            color: #13343b; font-size: 20px; transition: color 0.2s;
            margin: 0 8px;
        }
        
        .social-icon:hover { color: #21808d; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-title h1 { font-size: 40px; }
            .carousel-item { height: 300px; }
            .city-cards-grid { grid-template-columns: 1fr; }
            .city-card { flex-direction: column; height: auto; }
            .city-card-image { width: 100%; height: 200px; }
            .section-title { font-size: 24px; }
            .header-nav { gap: 15px; }
            .nav-link { font-size: 14px; }
            .info-banner { flex-direction: column; gap: 12px; padding: 16px; }
            .info-banner-img { width: 140px; }
            .info-banner-text { font-size: 18px; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Header with Container -->
    <header class="header">
        <div class="container">
            <div class="header-top">
                <div class="header-info">
                    <span>02 अक्टूबर 2025, शुक्रवार</span>
                </div>
                <div class="header-search">
                    <span>द मेनू</span>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="header-middle">
                <div class="header-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/logo.png') }}" alt="Indian Cities Logo">
                    </a>
                </div>
                <div class="header-title">
                    <h1><span class="title-orange">इंडियन</span> <span class="title-teal">सिटीज</span></h1>
                </div>
            </div>
        </div>

        <div class="container">
            <nav class="header-nav">
                @if(isset($cities) && $cities->count())
                    @foreach($cities as $c)
                        @php
                            $isActive = request()->routeIs('cities.show') && request()->route('slug') === ($c->slug ?? $c->id);
                        @endphp
                        <a href="{{ url('/cities/' . ($c->slug ?? $c->id)) }}" class="nav-link{{ $isActive ? ' active' : '' }}">{{ $c->name }}</a>
                    @endforeach
                @endif
            </nav>
        </div>
    </header>

    @yield('content')

</body>
</html>