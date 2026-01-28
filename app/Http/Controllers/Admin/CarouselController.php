<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarouselItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarouselController extends Controller
{
    public function index()
    {
        $items = CarouselItem::orderBy('order')->get();
        return view('admin.home_content.index', compact('items'));
    }

    public function create()
    {
        return view('admin.home_content.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'icon' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('carousel', 'public');
            $validated['image'] = $path;
        }

        $validated['status'] = $request->has('status');

        // Ensure unique ordering: if order provided, push existing items with same or greater order down by 1
        \DB::transaction(function() use ($validated) {
            if (isset($validated['order']) && $validated['order'] !== null) {
                $order = (int) $validated['order'];
                CarouselItem::where('order', '>=', $order)->increment('order');
            } else {
                // assign to end
                $max = CarouselItem::max('order');
                $validated['order'] = ($max === null) ? 0 : ($max + 1);
            }
            CarouselItem::create($validated);
        });

        return redirect()->route('admin.home_content.index')->with('success', 'Carousel item created.');
    }

    public function edit(CarouselItem $carousel)
    {
        return view('admin.home_content.edit', compact('carousel'));
    }

    public function update(Request $request, CarouselItem $carousel)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'icon' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'status' => 'boolean',
        ]);

        if ($request->has('remove_image') && $request->input('remove_image')) {
            if ($carousel->image) {
                \Storage::disk('public')->delete($carousel->image);
            }
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($carousel->image) {
                \Storage::disk('public')->delete($carousel->image);
            }
            $path = $request->file('image')->store('carousel', 'public');
            $validated['image'] = $path;
        }

        $validated['status'] = $request->has('status');

        // Handle order changes: if order provided and different, swap with existing item if present,
        // otherwise just set the new order. Use transaction to keep uniqueness.
        \DB::transaction(function() use ($validated, $carousel) {
            if (array_key_exists('order', $validated) && $validated['order'] !== null) {
                $newOrder = (int) $validated['order'];
                $oldOrder = $carousel->order;
                if ($newOrder !== $oldOrder) {
                    $other = CarouselItem::where('order', $newOrder)->where('id', '!=', $carousel->id)->first();
                    if ($other) {
                        // swap orders
                        $other->order = $oldOrder;
                        $other->save();
                    }
                    $carousel->order = $newOrder;
                }
            }

            // update other fields (image handled earlier)
            $carousel->title = $validated['title'] ?? $carousel->title;
            $carousel->subtitle = $validated['subtitle'] ?? $carousel->subtitle;
            $carousel->icon = $validated['icon'] ?? $carousel->icon;
            $carousel->link = $validated['link'] ?? $carousel->link;
            if (array_key_exists('image', $validated)) $carousel->image = $validated['image'];
            $carousel->status = $validated['status'];
            $carousel->save();
        });

        return redirect()->route('admin.home_content.index')->with('success', 'Carousel item updated.');
    }

    public function destroy(Request $request, CarouselItem $carousel)
    {
        if ($carousel->image) {
            \Storage::disk('public')->delete($carousel->image);
        }
        $carousel->delete();

        if ($request->wantsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
            return response()->json(['success' => true, 'message' => 'Carousel item deleted']);
        }

        return redirect()->route('admin.home_content.index')->with('success', 'Carousel item deleted.');
    }

    /**
     * Reorder carousel items. Expects `order` => [id1, id2, ...]
     */
    public function reorder(Request $request)
    {
        $order = $request->input('order', []);
        foreach ($order as $index => $id) {
            CarouselItem::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
