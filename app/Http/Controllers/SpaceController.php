<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SpaceController extends Controller
{
 public function index(\Illuminate\Http\Request $request)
{
    $query = \App\Models\Space::query()->with('images');

    // Search by keyword
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Filter by city
    if ($request->filled('city')) {
        $query->where('city', 'like', '%' . $request->city . '%');
    }

    // Filter by max price
    if ($request->filled('price')) {
        $query->where('price', '<=', $request->price);
    }

    $spaces = $query->latest()->get();

    return view('spaces.index', compact('spaces'));
}


    public function welcome()
    {
        $featuredSpaces = \App\Models\Space::with('images')
            ->latest()
            ->take(3)
            ->get();

        return view('welcome', compact('featuredSpaces'));
    }

   public function show(Space $space)
{
    $space->load(['category','user','images','reviews.user']);
    $booked = \App\Models\Booking::where('space_id', $space->id)
        ->sum('people_count');

    $remaining = $space->capacity - $booked;

    return view('spaces.show', compact('space','remaining'));
}
}
