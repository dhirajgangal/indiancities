<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CarouselItem;
use App\Models\Video;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        $cities = City::where('status', true)
                  ->where('visible_on_homepage', true)
                  ->with('histories')
                  ->get();

        $carousel = CarouselItem::where('status', true)->orderBy('order')->get();

        $videos = Video::where('status', true)->orderBy('created_at')->limit(6)->get();

        return view('index', compact('cities', 'carousel', 'videos'));
    }

    public function show($slug)
    {
        $city = City::where('slug', $slug)->first();
        
        if (!$city) {
            abort(404, 'City not found');
        }

        $cities = City::where('status', true)
                  ->where('visible_on_homepage', true)
                  ->select('id', 'name', 'slug')
                  ->get();

        $carousel = CarouselItem::where('active', true)->orderBy('order')->get();

        $relatedCities = City::where('status', true)
            ->where('id', '!=', $city->id)
            ->limit(4)
            ->get();

        return view('cities.show', compact('city', 'cities', 'carousel', 'relatedCities'));
    }
}