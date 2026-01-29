@extends('layouts.mainheader')

@section('title', $city->name)

@section('styles')
<link href="{{ asset('css/news-detail.css') }}" rel="stylesheet">
<link href="{{ asset('css/city-news.css') }}" rel="stylesheet">
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
                    {{ $city->name }}
                </h1>


            </div>

            <!-- MAIN IMAGE -->
            <div>
                @if ($city->image)
                <img src="{{ asset('storage/' . $city->image) }}" alt="{{ $city->title }}" class="main-img">
                @else
                <img src="{{ asset('assets/no-image.png') }}" alt="story thumbnail" class="main-img">
                @endif
            </div>

            <!-- DESCRIPTION -->
            <div>
                <p class="desc">
                    {!! $city->description !!}
                </p>
            </div>
        </div>
        <!-- RIGHT SIDE (STATIC) -->

        <div class="ns-right">
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

    </div>
</section>

@endsection