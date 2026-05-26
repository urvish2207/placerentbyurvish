<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostSpaceController extends Controller
{
   public function index()
{
    $spaces = \App\Models\Space::where('user_id', auth()->id())->latest()->get();

    return view('host.spaces.index', compact('spaces'));
}

    public function create()
    {
        $categories = Category::pluck('name', 'id');

        return view('host.spaces.create', compact('categories'));
    }

public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'address' => 'required',
        'city' => 'required',
        'country' => 'required',
        'capacity' => 'required|integer',
        'min_capacity' => 'required|integer',
        'available_slots' => 'nullable|array',
        'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $space = Space::create([
        'user_id' => auth()->id(),
        'category_id' => 1,
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'address' => $request->address,
        'city' => $request->city,
        'country' => $request->country,
        'status' => 'active',
        'capacity' => $request->capacity,
        'min_capacity' => $request->min_capacity,
        'available_slots' => $request->available_slots,
    ]);

    // ⭐ IMAGE UPLOAD FIX
    if ($request->hasFile('images')) {

        foreach ($request->file('images') as $file) {

            $path = $file->store('spaces', 'public');

            $space->images()->create([
                'image_path' => $path
            ]);
        }
    }

    return redirect()->route('host.spaces.index')->with('success','Space created');
} 

   public function edit(Space $space)
{
    $categories = \App\Models\Category::pluck('name','id');

    $space->load('images');

    return view('host.spaces.edit', compact('space','categories'));
}


public function update(Request $request, Space $space)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'capacity' => 'required|integer',
        'min_capacity' => 'required|integer',
        'available_slots' => 'nullable|array',
        'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $space->update([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'address' => $request->address,
        'city' => $request->city,
        'country' => $request->country,
        'capacity' => $request->capacity,
        'min_capacity' => $request->min_capacity,
        'available_slots' => $request->available_slots,
    ]);

    if ($request->hasFile('images')) {

        foreach ($request->file('images') as $file) {

            $path = $file->store('spaces', 'public');

            $space->images()->create([
                'image_path' => $path
            ]);
        }
    }

    return back()->with('success','Space updated');
}
   public function destroy(Space $space)
{
    if ($space->user_id !== auth()->id()) {
        abort(403);
    }

    $space->delete();

    return back()->with('success', 'Space deleted');
}

public function deleteImage(\App\Models\SpaceImage $image)
{
    if ($image->space->user_id !== auth()->id()) {
        abort(403);
    }

    \Storage::disk('public')->delete($image->image_path);

    $image->delete();

    return back()->with('success', 'Image deleted');
}

    private function authorizeSpace($space)
    {
        if ($space->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
