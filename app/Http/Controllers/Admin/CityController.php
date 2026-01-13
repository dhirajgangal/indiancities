<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $query = City::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $cities = $query->paginate($perPage);

        return view('admin.cities.index', compact('cities', 'search', 'perPage'));
    }

    public function create()
    {
        return view('admin.cities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:cities,name',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:160',
            'status' => 'boolean',
            'visible_on_homepage' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cities', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->has('status');
        $validated['visible_on_homepage'] = $request->has('visible_on_homepage');

        City::create($validated);

        return redirect()->route('admin.cities.index')
                        ->with('success', 'City created successfully!');
    }

    public function edit(City $city)
    {
        return view('admin.cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:cities,name,' . $city->id,
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:160',
            'status' => 'boolean',
            'visible_on_homepage' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($city->image) {
                \Storage::disk('public')->delete($city->image);
            }
            $imagePath = $request->file('image')->store('cities', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->has('status');
        $validated['visible_on_homepage'] = $request->has('visible_on_homepage');

        $city->update($validated);

        return redirect()->route('admin.cities.index')
                        ->with('success', 'City updated successfully!');
    }

    public function destroy(Request $request, City $city)
    {
        if ($city->image) {
            \Storage::disk('public')->delete($city->image);
        }
        $city->delete();

        // If the client expects JSON (AJAX), return a JSON response so the frontend can handle it.
        if ($request->wantsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
            return response()->json([ 'success' => true, 'message' => 'City deleted successfully' ]);
        }

        return redirect()->route('admin.cities.index')
                        ->with('success', 'City deleted successfully!');
    }

    /**
     * Toggle the active status (AJAX)
     */
    public function toggleStatus(Request $request, City $city)
    {
        $value = $request->input('value') ? true : false;
        $city->status = $value;
        $city->save();

        return response()->json([
            'success' => true,
            'status' => $city->status,
        ]);
    }

    /**
     * Toggle homepage visibility (AJAX)
     */
    public function toggleHomepage(Request $request, City $city)
    {
        $value = $request->input('value') ? true : false;
        $city->visible_on_homepage = $value;
        $city->save();

        return response()->json([
            'success' => true,
            'visible_on_homepage' => $city->visible_on_homepage,
        ]);
    }

    public function showCityNews($slug)
    {
        // Fetch city by slug
        $city = City::where('slug', $slug)->firstOrFail();

        // Fetch related news for the city
        $news = $city->news()->latest()->get();

        // Pass data to the view
        return view('citynewspage', compact('city', 'news'));
    }
}