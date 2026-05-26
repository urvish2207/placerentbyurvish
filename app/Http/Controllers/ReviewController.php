<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
class ReviewController extends Controller
{
    public function store(Request $request, $spaceId)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string'
    ]);

    Review::create([
        'user_id' => auth()->id(),
        'space_id' => $spaceId,
        'rating' => $request->rating,
        'comment' => $request->comment
    ]);

    return back()->with('success', 'Review added!');
}
}
