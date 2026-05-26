<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'address',
        'city',
        'country',
        'status',
        'capacity',
        'min_capacity',
        'available_slots'
    ];

   protected $casts = [
    'available_slots' => 'array',
];

    public function images()
    {
        return $this->hasMany(SpaceImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function reviews()
{
    return $this->hasMany(\App\Models\Review::class);
}
}