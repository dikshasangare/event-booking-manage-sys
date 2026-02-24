<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    protected $fillable = [
        'booking_id',
        'seat_id',
        'seat_price',
        'ticket_code',
        'check_in_status',
        'checked_in_at'
    ];

    protected $dates = [
        'checked_in_at'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
