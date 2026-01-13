<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\City;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $city = $request->input('city');
        $perPage = $request->input('per_page', 10);

        $query = News::with('city');

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        if ($city) {
            $query->where('city_id', $city);
        }

        $news = $query->paginate($perPage);
        $cities = City::all();

        return view('admin.news.index', compact('news', 'cities', 'search', 'city', 'perPage'));
    }

    public function create()
    {
        $cities = City::all();
        return view('admin.news.create', compact('cities'));
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'city_id' => 'required|exists:cities,id',
    //         'title' => 'required|string',
    //         'description' => 'required|string',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'published_date' => 'nullable|date',
    //         'status' => 'boolean',
    //     ]);

    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('news', 'public');
    //         $validated['image'] = $imagePath;
    //     }

    //     $validated['status'] = $request->has('status');

    //     News::create($validated);

    //     return redirect()->route('admin.news.index')
    //                     ->with('success', 'News created successfully!');
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_date' => 'nullable|date',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // This stores as: storage/app/public/news/filename.jpg
            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = $imagePath; // Saves as: news/filename.jpg
        }

        $validated['status'] = $request->has('status');

        News::create($validated);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News created successfully!');
    }


    public function edit(News $news)
    {
        $cities = City::all();
        return view('admin.news.edit', compact('news', 'cities'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_date' => 'nullable|date',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($news->image) {
                \Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['status'] = $request->has('status');

        $news->update($validated);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News updated successfully!');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            \Storage::disk('public')->delete($news->image);
        }
        $news->delete();

        return redirect()->route('admin.news.index')
                        ->with('success', 'News deleted successfully!');
    }
}