<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CityController as AdminCityController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\NewsController;

// ===== PUBLIC ROUTES =====
Route::get('/', [HomeController::class, 'index'])->name('home');
// City Routes
Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
Route::get('/cities/{slug}', [CityController::class, 'show'])->name('cities.show');
Route::get('/videos/{slug}', [VideoController::class, 'show'])->name('videos.show');
Route::get('/cities_view/{slug}', [CityController::class, 'cityView'])->name('cities.view');
Route::get('/cities/{city}/news/{news}', [CityController::class, 'showNews'])->name('news.show');
Route::get('/cities/{citySlug}/place/{placeSlug}', [CityController::class, 'showPlace'])->name('place.show');
// Add a route to handle dynamic city news pages
// Route::get('/city-news/{slug}', [CityController::class, 'showCityNews'])->name('city.news');
// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cities Management
    Route::resource('cities', AdminCityController::class);
    Route::patch('/cities/{city}/toggle-status', [AdminCityController::class, 'toggleStatus'])
        ->where('city', '[a-z0-9\-]+')
        ->name('cities.toggleStatus');
    Route::patch('/cities/{city}/toggle-homepage', [AdminCityController::class, 'toggleHomepage'])
        ->where('city', '[a-z0-9\-]+')
        ->name('cities.toggleHomepage');

    // Home content (carousel) Management
    Route::resource('home_content', \App\Http\Controllers\Admin\CarouselController::class);
    Route::post('/home_content/reorder', [\App\Http\Controllers\Admin\CarouselController::class, 'reorder'])
        ->name('home_content.reorder');

    // News Management
    Route::resource('news', AdminNewsController::class);

    // Videos Management
    Route::resource('videos', AdminVideoController::class);

    // Places Management (dynamic categories)
    Route::resource('places', \App\Http\Controllers\Admin\PlaceController::class)->names('places');
    // Route::resource('place-categories', \App\Http\Controllers\Admin\PlaceCategoryController::class)->names('place_categories');

});

// ===== AUTHENTICATION ROUTES (from Laravel Breeze) =====
require __DIR__ . '/auth.php';
