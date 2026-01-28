<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\City;
use Illuminate\Http\Request;

class PlaceController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $city = $request->input('city');
        $perPage = (int) $request->input('per_page', 10);

        $query = Place::with(['city']);
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($city) {
            $query->where('city_id', $city);
        }

        $places = $query->orderByDesc('id')->paginate($perPage)->withQueryString();
        
        $places->onEachSide(2);
        $cities = City::all();

        return view('admin.places.index', [
            'places' => $places,
            'cities' => $cities,
            'search' => $search,
            'city' => $city,
            'perPage' => $perPage,
        ]);
    }

    public function create(Request $request)
    {
        $cities = City::all();
        return view('admin.places.create', [
            'cities' => $cities,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'published_date' => 'nullable|date',
            'status' => 'boolean',
        ]);

        $validated['slug'] = \Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('places', 'public');
            $validated['image'] = $imagePath;
        }

        $place = Place::create($validated);

        return redirect()->route('admin.places.index')
            ->with('success', 'Saved successfully!');
    }

    public function show(Request $request, Place $place)
    {
        return view('admin.places.show', [
            'place' => $place->load('city'),
        ]);
    }

    public function edit(Request $request, Place $place)
    {
        $cities = City::all();
        return view('admin.places.edit', [
            'place' => $place,
            'cities' => $cities,
        ]);
    }

    public function update(Request $request, Place $place)
    {
        $validated = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'published_date' => 'nullable|date',
            'status' => 'boolean',
        ]);

        $validated['slug'] = \Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            if ($place->image) {
                \Storage::disk('public')->delete($place->image);
            }
            $validated['image'] = $request->file('image')->store('places', 'public');
        }

        $place->update($validated);
        return redirect()->route('admin.places.index')
            ->with('success', 'Updated successfully!');
    }

    public function destroy(Request $request, Place $place)
    {
        if ($place->image) {
            \Storage::disk('public')->delete($place->image);
        }
        $place->delete();
        return redirect()->route('admin.places.index')
            ->with('success', 'Deleted successfully!');
    }
}
