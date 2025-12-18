<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'primary_role',
        'photo',
        'bio',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class)->withPivot(['event_role', 'sort_order'])->withTimestamps();
    }
}
