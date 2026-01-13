<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CarouselItem;


class HomeController extends Controller
{
    public function index()
    {
        $cities = City::where('status', true)
                  ->where('visible_on_homepage', true)
                  ->with('histories')
                  ->get();

        $carousel = CarouselItem::where('active', true)->orderBy('order')->get();

        return view('index', compact('cities', 'carousel'));
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