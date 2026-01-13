<?php

use App\Http\Controllers\ProfileController;
use App\Models\City;
use App\Models\News;
use App\Models\Video;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard', [
        'cities' => City::count(),
        'news' => News::count(),
        'videos' => Video::count(),
        'activeNews' => News::where('status', 'active')->count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('cities', App\Http\Controllers\Admin\CityController::class)->except(['show']);
});

require __DIR__.'/auth.php';
