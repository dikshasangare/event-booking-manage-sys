<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'section',
        'row',
        'number',
        'price',
        'status',
        'locked_until'
    ];

    protected $dates = ['locked_until'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class)->withPivot('seat_price')->withTimestamps();
    }
}
