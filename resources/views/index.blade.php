@extends('layouts.mainheader')

@section('content')
<!-- Hero Carousel - Full Width (No Container) -->
<div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
    @php
    $indicatorCount = (isset($carousel) && $carousel->count()) ? $carousel->count() : 2;
    @endphp
    <div class="carousel-indicators">
        @for($k = 0; $k < $indicatorCount; $k++)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $k }}" class="{{ $k==0 ? 'active' : '' }}" aria-current="{{ $k==0 ? 'true' : 'false' }}" aria-label="Slide {{ $k+1 }}"></button>
            @endfor
    </div>
    <div class="carousel-inner">
        @if(isset($carousel) && $carousel->count())
        @foreach($carousel as $i => $item)
        <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
            @if($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" class="d-block w-100" alt="{{ $item->title ?? 'Slide' }}">
            @else
            <img src="{{ asset('assets/header1.png') }}" class="d-block w-100" alt="Slide">
            @endif
            <div class="carousel-caption d-none d-md-block">
                @if($item->icon)
                <i class="{{ $item->icon }}" style="font-size:28px; margin-right:8px;"></i>
                @endif
                @if($item->title)
                <h5>{{ $item->title }}</h5>
                @endif
                @if($item->subtitle)
                <p>{{ $item->subtitle }}</p>
                @endif
            </div>
        </div>
        @endforeach
        @else
        <div class="carousel-item active">
            <img src="{{ asset('assets/header1.png') }}" class="d-block w-100" alt="Header 1">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('assets/header2.png') }}" class="d-block w-100" alt="Header 2">
        </div>
        @endif
    </div>

    @if(isset($carousel) && $carousel->count())
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    @endif
</div>

<!-- City Cards Section with Container -->
<div class="container">
    <div class="city-history">
        <h2 class="section-title">सिटीज हिस्ट्री </h2>
        <p class="section-button">View All <span><i class="bi bi-arrow-right-circle"></i></span></p>
    </div>
    <div class="city-cards-grid">
        @if(isset($cities) && $cities->count())
        @foreach($cities as $city)
        <div class="city-card">
            <img src="{{ $city->image ? asset('storage/' . $city->image) : asset('assets/Rectangle 1.png') }}" alt="{{ $city->name }}" class="city-card-image">
            <div class="city-card-body">
                <a href="{{ url('/cities_view/' . ($city->slug ?? $city->id)) }}" class="city-card-title">{{ $city->name }}</a>

                <p class="city-card-description" title="{{ e($city->description ?? 'No description available.') }}">{{ \Illuminate\Support\Str::limit($city->description ?? 'No description available.', 240) }}</p>
            </div>
        </div>
        @endforeach
        @else
        <div class="city-card" style="width:100%; padding:40px; text-align:center;">
            <p style="font-weight:700;">कोई शहर अभी तक जोड़ा नहीं गया है। कृपया बाद में देखें।</p>
        </div>
        @endif
    </div>
</div>

<div class="container">
    <div class="divider"></div>
</div>

<!-- Info Banner with Container -->
<div class="container">
    <div class="info-banner">
        <img src="./assets/image 10.png" alt="" class="info-banner-img">
        <div class="info-banner-text-container">
            <p class="info-banner-text">भारत के इन शहरों का हजारों साल पुराना है इतिहास, खासियत ऐसी कि आज भी है अनूठा</p>
        </div>
        <img src="./assets/image 10.png" alt="" class="info-banner-img">
    </div>
</div>

<div class="container">
    <div class="divider"></div>
</div>

<!-- City Section with Container -->
<div class="container">
    <div class="city-header">
        <a href="#" class="city-header-title">आपके शहर से</a>
        <ul class="city-header-menu">
            <li><a href="#">घुमक्कड़ी</a></li>
            <li><a href="#">चटोरे</a></li>
            <li><a href="#">शहर की हस्ती</a></li>
            <li><a href="#">हमारी मेट्रो</a></li>
        </ul>
    </div>

    <div class="city-list-grid">
        <div class="city-list-item">
            <img src="https://images.unsplash.com/photo-1564507592333-c60657eea523?w=100&h=100&fit=crop" alt="दिल्ली में कहां है जहांपनाह" class="city-list-image">
            <div class="city-list-content">
                <h4>दिल्ली में कहां है जहांपनाह, जानें 700 साल पुरा...</h4>
            </div>
        </div>

        <div class="city-list-item">
            <img src="https://images.unsplash.com/photo-1524492412937-b28074a5d7da?w=100&h=100&fit=crop" alt="मालती की गजब" class="city-list-image">
            <div class="city-list-content">
                <h4>मालती की गजब खूबी इसनी, मालती की हदीसी में करें घुमक्कड़ी; दिन बन...</h4>
            </div>
        </div>

        <div class="city-list-item">
            <img src="https://images.unsplash.com/photo-1570168007204-dfb528c6958f?w=100&h=100&fit=crop" alt="Maju ka Tila" class="city-list-image">
            <div class="city-list-content">
                <h4>Maju ka Tila गए तो कई बार होगी, जान लीजिए इस जगह का गुरू नानक से क्या...</h4>
            </div>
        </div>

        <div class="city-list-item">
            <img src="https://images.unsplash.com/photo-1587474260584-136574528ed5?w=100&h=100&fit=crop" alt="चुआमल हवेली" class="city-list-image">
            <div class="city-list-content">
                <h4>चुआमल हवेली : यहां मसकली बन आसपास घुमता है 200 साल का इतिहास</h4>
            </div>
        </div>

        <div class="city-list-item">
            <img src="https://images.unsplash.com/photo-1599661046289-e31897846e41?w=100&h=100&fit=crop" alt="दिल्ली में बनी" class="city-list-image">
            <div class="city-list-content">
                <h4>दिल्ली में इतनी खूबसूरत झील, यहां पहुंचकर सपने सच होने जैसा एहसास होगा</h4>
            </div>
        </div>

        <div class="city-list-item">
            <img src="https://images.unsplash.com/photo-1592659762303-90081d34b277?w=100&h=100&fit=crop" alt="भारत के ये शहर" class="city-list-image">
            <div class="city-list-content">
                <h4>भारत के ये शहर माने जाते हैं सिल्क सिटी ऑफ इंडिया, जानिए इनके नाम</h4>
            </div>
        </div>
    </div>

    <div class="view-more-btn">
        <a href="#">और पढ़े <i class="bi bi-chevron-double-right"></i></a>
    </div>
</div>

<div class="container">
    <div class="divider"></div>
</div>

<!-- Video Section with Container -->
<div class="container video-section">
    <h2 class="section-title">वीडियो</h2>
    <div class="video-grid">
        @foreach($videos as $video)
        <div class="video-card">
            <div class="video-thumbnail">
                <div class="video-el">
                    @php
                    // Extract YouTube video ID from various possible URL formats
                    preg_match('/(youtu\.be\/|youtube\.com\/(watch\?(.*&)?v=|(embed|v)\/))([^\?&"\'<> #]+)/', $video->youtube_url, $matches);
                        $videoId = $matches[5] ?? null;
                        @endphp
                        <iframe width="400" height="200" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            <div class="video-info">
                <!-- <p class="mb-0">{{ $video->title }}</p> -->
                <a href="{{ url('/videos/' . ($video->id ?? $video->id)) }}" class="mb-0">{{ $video->title }}</a>
            </div>
        </div>
        @endforeach
    </div>
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
    </div>
</footer>
@endsection