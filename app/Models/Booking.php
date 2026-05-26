<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'space_id',
        'user_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
    ];

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
