<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'category',
        'image',
        'is_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Get the final price (discounted price if available, otherwise regular price)
     */
    public function getFinalPriceAttribute()
    {
        return $this->discount_price && $this->discount_price > 0 ? $this->discount_price : $this->price;
    }


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
