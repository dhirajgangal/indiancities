<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\News;
use App\Models\Video;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'cities' => City::count(),
            'news' => News::count(),
            'videos' => Video::count(),
            'activeNews' => News::where('status', true)->count(),
        ];

        return view('admin.dashboard', $stats);
    }
}