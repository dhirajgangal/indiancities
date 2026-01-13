@extends('layouts.mainheader')

@section('title', $news->title . ' - ' . $city->name)

@section('styles')
<link href="{{ asset('css/news-detail.css') }}" rel="stylesheet">
<link href="{{ asset('css/image-sizing.css') }}" rel="stylesheet">
@endsection

@section('content')

<section class="news-section">
    <div class="ns-container">

        <!-- LEFT SIDE -->
        <div class="ns-left">

            <!-- NEWS HEADER (DYNAMIC) -->
            <div>
                <h1 class="ns-heading">
                    {{ $city->name }} News: <br> {{ $news->title }}
                </h1>

                <p>
                    Published -
                    {{ $news->published_date ? $news->published_date->format('F d, Y h:iA') : '' }} IST -
                    {{ $city->name }}
                </p>
            </div>

            <!-- MAIN IMAGE -->
            <div>
                @if($news->image)
                    <img src="{{ asset('storage/' . $news->image) }}"
                         alt="{{ $news->title }}"
                         class="main-img">
                @else
                    <img src="/assets/image-placeholder.png" class="main-img" alt="">
                @endif
            </div>

            <!-- DESCRIPTION -->
            <div>
                <p class="desc">
                    {!! $news->description !!}
                </p>
            </div>

            <!-- STATIC -->
            <h2 class="span">ये भी पढ़े</h2>

            <div class="banner">
                <h3>
                    <span style="font-weight:bold; color:#d32f2f;">Gurugram News:</span>
                    वरिष्ठ अधिवक्ता एन हरिहरन ने कहा कि यह एक
                </h3>
            </div>

            <p class="desc">
                नई अधिवक्ता किसी बात से आहत था तो कोर्ट ऑफिसर होने के नाते वह कानूनी तरीका अपना सकता था। ब्यूरो
            </p>

            <h2 class="span">ये भी पढ़े</h2>

            <p class="desc">
                नई दिल्ली। अगर, अधिवक्ता किसी बात से आहत था तो कोर्ट ऑफिसर होने के नाते वह कानूनी तरीका अपना सकता था। ब्यूरो
            </p>

            <img src="/assets/image 6.png" alt="advertise-img" class="advertise-img">

            <div class="desc">
                For power, but for service, and our offices are meant to nurture that spirit.
            </div>
        </div>



        <!-- RIGHT SIDE (STATIC) -->
        <div class="ns-right">

            <button class="ns-right__title">Highlights</button>

            <ul class="hl-list">
                <li class="hl-item">
                    <div class="hl-thumb">
                        <img src="/assets/Rectangle 10.png" alt="">
                    </div>
                    <div class="hl-content">
                        <a href="#" class="hl-title">Asia Cup trophy not awarded to champions</a>
                    </div>
                </li>

                <li class="hl-item">
                    <div class="hl-thumb">
                        <img src="/assets/image 12.png" alt="">
                    </div>
                    <div class="hl-content">
                        <a href="#" class="hl-title">Is the American Dream dead for Indians?</a>
                    </div>
                </li>
            </ul>

            <button class="ns-right__title">Events & Promotions</button>

            <ul class="hl-list">
                <li class="hl-item">
                    <div class="hl-thumb">
                        <img src="/assets/image 12.png" alt="">
                    </div>
                    <div class="hl-content">
                        <a href="#" class="hl-title">Asia Cup trophy not awarded to champions</a>
                        <p class="hl-excerpt">India after they refuse to accept it from ACC chief Mohsin Naqvi</p>
                    </div>
                </li>

                <li class="hl-item">
                    <div class="hl-thumb">
                        <img src="/assets/Rectangle 10.png" alt="">
                    </div>
                    <div class="hl-content">
                        <a href="#" class="hl-title">Is the American Dream dead for Indians?</a>
                        <p class="hl-excerpt">Visa backlogs, job market shifts, and changing policies</p>
                    </div>
                </li>
            </ul>


            <section class="city-news">
                <div class="city-header">
                    <h2>आपके शहर से <br> समाचार</h2>
                    <select class="city-dropdown">
                        <option>शहर बदलें</option>
                        <option>जयपुर</option>
                        <option>उदयपुर</option>
                        <option>जोधपुर</option>
                    </select>
                </div>

                <div class="news-list">
                    <div class="news-item">
                        <div class="news-content">
                            <h3>उदयपुर में मनी के हमले पर यूथ कांग्रेस कार्यकर्ताओं की रैली</h3>
                            <p>रात तीन बजे जाने पर बवाल, डोटासरा ने भाजपा विधायक के खिलाफ FIR की मांग की</p>
                            <div class="news-footer">
                                <span>उदयपुर</span>
                            </div>
                        </div>
                        <img src="/assets/Rectangle 10.png" alt="news" class="news-img">
                    </div>
                </div>
            </section>

        </div>

    </div>
</section>

@endsection