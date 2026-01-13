<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\News;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of cities
     */
    public function index()
    {
        $cities = City::where('status', true)
                     ->orderBy('name')
                     ->get();
        
        return view('cities.index', compact('cities'));
    }

    /**
     * Display the specified city with its news
     */
    public function show($slug)
    {
        // Find city by slug or ID
        $city = City::where('slug', $slug)
                   ->orWhere('id', $slug)
                   ->firstOrFail();

        // Get published news for this city with pagination
        $news = News::where('city_id', $city->id)
                   ->where('status', true)
                   ->orderBy('published_date', 'desc')
                   ->orderBy('created_at', 'desc')
                   ->paginate(10);

        // Get all active cities for navbar
        $cities = City::where('status', true)
                     ->where('visible_on_homepage', true)
                     ->select('id', 'name', 'slug')
                     ->get();

        return view('cities.show', compact('city', 'news', 'cities'));
    }

    /**
     * Display a single news article
     */
    public function showNews($citySlug, $newsId)
    {
        // Find city
        $city = City::where('slug', $citySlug)
                   ->orWhere('id', $citySlug)
                   ->firstOrFail();

        // Find news belonging to this city
        $news = News::where('id', $newsId)
                   ->where('city_id', $city->id)
                   ->where('status', true)
                   ->firstOrFail();

        // Get related news from the same city (excluding current)
        $relatedNews = News::where('city_id', $city->id)
                          ->where('status', true)
                          ->where('id', '!=', $newsId)
                          ->orderBy('published_date', 'desc')
                          ->limit(5)
                          ->get();

        // Get all active cities for navbar
        $cities = City::where('status', true)
                     ->where('visible_on_homepage', true)
                     ->select('id', 'name', 'slug')
                     ->get();

        // Get top news for highlights sidebar
        $topNews = News::where('status', true)
                       ->orderBy('published_date', 'desc')
                       ->orderBy('created_at', 'desc')
                       ->limit(5)
                       ->get();

        return view('cities.news-detail', compact('city', 'news', 'relatedNews', 'cities', 'topNews'));
    }
}