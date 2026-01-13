@extends('layouts.mainheader')

@section('title', $city->name . ' - News')

@section('styles')
<link href="{{ asset('css/city-news.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- News Section -->
<section class="news-section">
    <div class="news-section-container">
        <!-- Left Column (Static for now) -->
        <div class="news-left">
            <h2 class="daily-news-title">{{ $city->name }} के घाव</h2>
            
            <!-- Static cards - you can make these dynamic later -->
            <article class="mini-card">
                <img src="{{ asset('assets/image 12.png') }}" alt="story thumbnail">
                <a href="#" class="mini-title">
                    {{ $city->name }} में दिवाली से पहले नकली घी बनाने वाला बड़ा रैकेट पकड़ा, 6 गिरफ्तार
                </a>
            </article>

            <article class="mini-card">
                <img src="{{ asset('assets/image 13.png') }}" alt="story thumbnail">
                <a href="#" class="mini-title">
                    {{ $city->name }}: 500 सीसीटीवी खंगालने के बाद... आरोपी गिरफ्तार, ऑडि़ कार भी बरामद
                </a>
            </article>
        </div>

        <!-- Center Column (Dynamic - Admin News) -->
        <div class="news-center">
            <h2 class="daily-news-title">दैनिक समाचार</h2>

            <div class="daily-news-list">
                @forelse($news as $newsItem)
                    <a href="{{ route('news.show', ['city' => $city->slug ?? $city->id, 'news' => $newsItem->id]) }}" class="daily-news-item">
                        <div class="daily-news-text">
                            <h3>{{ $newsItem->title }}</h3>
                            <p>{{ Str::limit(strip_tags($newsItem->description), 150, '...') }}</p>
                            @if($newsItem->published_date)
                                <span class="news-date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $newsItem->published_date->format('d M Y') }}
                                </span>
                            @endif
                        </div>
                        @if($newsItem->image)
                            <div class="daily-news-img">
                                <img src="{{ asset('storage/' . $newsItem->image) }}" alt="{{ $newsItem->title }}">
                            </div>
                        @else
                            <div class="daily-news-img">
                                <img src="{{ asset('assets/pvsingdu.jpg') }}" alt="Default Image">
                            </div>
                        @endif
                    </a>
                @empty
                    <div class="no-news">
                        <i class="fas fa-newspaper" style="font-size: 48px; color: #ddd; margin-bottom: 15px;"></i>
                        <p>{{ $city->name }} के लिए अभी कोई समाचार उपलब्ध नहीं है।</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($news->hasPages())
                <div class="pagination-wrapper">
                    {{ $news->links() }}
                </div>
            @endif
        </div>

        <!-- Right Column (Static Advertisement) -->
        <div class="news-right">
            <img src="{{ asset('assets/image 11 (1).png') }}" alt="city-advertisement" class="city-advertisement">
        </div>
    </div>
</section>
@endsection

