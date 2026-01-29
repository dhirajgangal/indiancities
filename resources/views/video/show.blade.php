@extends('layouts.mainheader')

@section('title', $video->title)

@section('styles')
<link href="{{ asset('css/news-detail.css') }}" rel="stylesheet">
<link href="{{ asset('css/city-news.css') }}" rel="stylesheet">
<link href="{{ asset('css/video-sizing.css') }}" rel="stylesheet">
@endsection

@section('content')

<section class="news-section">
    <div class="ns-container">


        <!-- LEFT SIDE -->
        <div class="ns-left">

            <!-- VIDEO HEADER (DYNAMIC) -->
            <div>
                <h1 class="ns-heading">
                    {{ $video->title }}
                </h1>


            </div>
            <!-- MAIN Video -->
            <div class="video-wrapper">
                @php
                // Extract YouTube video ID from various possible URL formats
                preg_match('/(youtu\.be\/|youtube\.com\/(watch\?(.*&)?v=|(embed|v)\/))([^\?&"\'<> #]+)/', $video->youtube_url, $matches);
                    $videoId = $matches[5] ?? null;
                    @endphp
                    <iframe width="100%" height="auto" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>

            </div>

            <!-- DESCRIPTION -->
            <div>
                <p class="desc">
                    {!! $video->description !!}
                </p>
            </div>
        </div>
        <!-- RIGHT SIDE (STATIC) -->

        <div class="ns-right">
            <h2 class="daily-news-title">{{ $video->city->name }} के वीडियो</h2>

            <!-- Static cards - you can make these dynamic later -->
            @if ($cityVideos->isEmpty())
            <p>Comming soon more about of {{ $video->city->name }}.</p>
            @else
            @foreach ($cityVideos as $video)

            <a class="mini-card-link" href="{{ url('/videos/' . ($video->id ?? $video->id)) }}">
                <article class="mini-card">

                    @php
                    // Extract YouTube video ID from various possible URL formats
                    preg_match('/(youtu\.be\/|youtube\.com\/(watch\?(.*&)?v=|(embed|v)\/))([^\?&"\'<> #]+)/', $video->youtube_url, $matches);
                        $videoId = $matches[5] ?? null;
                        @endphp
                        <iframe width="100%" height="auto" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>

                        <a class="mini-title" href="{{ url('/videos/' . ($video->id ?? $video->id)) }}">
                            {{ $video->title }}
                        </a>
                </article>
            </a>
            @endforeach
            @endif

        </div>

    </div>
</section>

@endsection