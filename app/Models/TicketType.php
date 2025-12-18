<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'currency',
        'quantity',
        'sold',
        'min_per_order',
        'max_per_order',
        'is_free',
        'is_visible',
        'sale_start',
        'sale_end',
        'sales_channel',
        'status',
        'sort_order',
        'metadata',
    ];

    protected $casts = [
        'price'         => 'decimal:2',
        'quantity'      => 'integer',
        'sold'          => 'integer',
        'is_free'       => 'boolean',
        'is_visible'    => 'boolean',
        'sale_start'    => 'datetime',
        'sale_end'      => 'datetime',
        'metadata'      => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getRemainingQuantityAttribute(): int
    {
        return max(0, $this->quantity - $this->sold);
    }

    public function getIsSoldOutAttribute(): bool
    {
        return $this->remaining_quantity <= 0;
    }

    public function getIsOnSaleAttribute(): bool
    {
        $now = now();

        return ($this->sale_start === null || $now->gte($this->sale_start)) &&
            ($this->sale_end === null || $now->lte($this->sale_end));
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->is_free || $this->price == 0) {
            return 'FREE';
        }

        return $this->currency . ' ' . number_format($this->price, 2);
    }


    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }

    public function scopeOnSale(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereNull('sale_start')->orWhere('sale_start', '<=', now());
        })->where(function ($q) {
            $q->whereNull('sale_end')->orWhere('sale_end', '>=', now());
        });
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->whereColumn('sold', '<', 'quantity');
    }

    public function canPurchase(int $qty): bool
    {
        if (! $this->is_on_sale) {
            return false;
        }

        if ($this->is_sold_out) {
            return false;
        }

        if ($qty < $this->min_per_order || $qty > $this->max_per_order) {
            return false;
        }

        if ($qty > $this->remaining_quantity) {
            return false;
        }

        return true;
    }
}
