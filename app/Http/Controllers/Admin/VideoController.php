<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\City;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $city = $request->input('city');
        $perPage = $request->input('per_page', 10);

        $query = Video::with('city');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($city) {
            $query->where('city_id', $city);
        }

        $videos = $query->paginate($perPage);
        $cities = City::all();

        return view('admin.videos.index', compact('videos', 'cities', 'search', 'city', 'perPage'));
    }

    public function create()
    {
        $cities = City::all();
        return view('admin.videos.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'title' => 'required|string',
            'youtube_url' => 'required|url',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->has('status');

        Video::create($validated);

        return redirect()->route('admin.videos.index')
                        ->with('success', 'Video created successfully!');
    }

    public function edit(Video $video)
    {
        $cities = City::all();
        return view('admin.videos.edit', compact('video', 'cities'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'title' => 'required|string',
            'youtube_url' => 'required|url',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->has('status');

        $video->update($validated);

        return redirect()->route('admin.videos.index')
                        ->with('success', 'Video updated successfully!');
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('admin.videos.index')
                        ->with('success', 'Video deleted successfully!');
    }
}