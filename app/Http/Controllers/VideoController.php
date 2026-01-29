<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of Video
     */
    public function index()
    {
        $video = Video::with('city')->where('status', true)
            ->get();

        return view('video.index', compact('video'));
    }

    /**
     * Display the specified Video 
     */
    public function show($slug)
    {
        // Find city by slug or ID
        $video = Video::with('city')->where('id', $slug)
            ->firstOrFail();


        $cityVideos = Video::with('city')
            ->where('status', 1)
            ->where('city_id', $video->city_id)
            ->where('id', '!=', $video->id) // optional: exclude current video
            ->get();


        return view('video.show', compact('video', 'cityVideos'));
    }
}
