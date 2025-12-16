<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Venue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'city',
        'state',
        'country',
        'venue_image',
        'address',
        'capacity',
        'is_active',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($venue) {
            $venue->slug = Str::slug($venue->name) . '-' . Str::random(5);
        });
    }

    // public function events()
    // {
    //     return $this->hasMany(Event::class);
    // }
}
