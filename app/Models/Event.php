<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'venue_id',
        'category_id',
        'organizer_id',
        'title',
        'slug',
        'short_description',
        'about_event',
        'event_type',
        'age_limit',
        'language',
        'start_datetime',
        'end_datetime',
        'total_duration_minutes',
        'max_capacity',
        'banner_image',
        'status',
        'is_featured',
        'is_private',
        'published_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            $event->slug = Str::slug($event->title) . '-' . Str::random(6);
        });
    }

    public function artists()
    {
        return $this->belongsToMany(Artist::class)->withPivot(['event_role', 'sort_order'])->withTimestamps()->orderBy('pivot_sort_order');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

    // public function bookings()
    // {
    //     return $this->hasMany(Booking::class);
    // }
}
