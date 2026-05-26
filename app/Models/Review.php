<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
    'user_id',
    'space_id',
    'rating',
    'comment'
];

public function user()
{
    return $this->belongsTo(User::class);
}

public function space()
{
    return $this->belongsTo(Space::class);
}
}
