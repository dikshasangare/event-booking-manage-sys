<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'booking_number',
        'total_seats',
        'total_amount',
        'payment_status',
        'payment_id',
        'paid_at'
    ];

    protected $dates = ['paid_at'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function seats()
    {
        return $this->belongsToMany(Seat::class)
                    ->withPivot('seat_price')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
