@extends('layouts.mainheader')

@section('title', $city->name . ' - News')

@section('styles')
<link href="{{ asset('css/city-news.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- News Section -->
<section class="news-section">
    <div class="city-desc-wrapper">
        <p class="city-desc">
            {!! $city->description !!}
        </p>
        <a href="{{ url('/cities_view/' . ($city->slug ?? $city->id)) }}" class="read-more">
            <b>और पढ़ें</b>
        </a>
    </div>
    <div class="news-section-container">

        <!-- Left Column (Static for now) -->
        <div class="news-left">
            <h2 class="daily-news-title">{{ $city->name }} के स्थान</h2>

            <!-- Static cards - you can make these dynamic later -->
            @if ($places->isEmpty())
            <p>Comming soon more about of {{ $city->name }}.</p>
            @else
            @foreach ($places as $place)
            <a href="{{ route('place.show', ['citySlug' => $city->slug, 'placeSlug' => $place->slug]) }}" class="mini-card-link">
                <article class="mini-card">
                    @if ($place->image)
                    <img src="{{ asset('storage/' . $place->image) }}" alt="{{ $place->title }}" class="mini-card-img">
                    @else
                    <img src="{{ asset('assets/no-image.png') }}" alt="story thumbnail">
                    @endif
                    <a href="{{ route('place.show', ['citySlug' => $city->slug, 'placeSlug' => $place->slug]) }}" class="mini-title">
                        {{ $place->title }}
                    </a>
                </article>
            </a>
            @endforeach
            @endif

        </div>

        <!-- Center Column (Dynamic - Admin News) -->
        <div class="news-center">
            <h2 class="daily-news-title">दैनिक समाचार</h2>

            <div class="daily-news-list">
                @forelse($news as $newsItem)
                <a href="{{ $newsItem->source_link }}" target="_blank" class="daily-news-item">
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
                        <img src="{{ strpos($newsItem->image, 'http') !== false ?  $newsItem->image : asset('storage/' . $newsItem->image) }}" alt="{{ $newsItem->title }}">
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
            <div class="pagination-area">
                <div class="pagination-wrapper">
                    {{ $news->links('pagination::bootstrap-5') }}
                </div>
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