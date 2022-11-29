<?php

namespace App\Models;

use Database\Factories\CartItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CartItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id',
        'item_id',
        'quantity'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Product::class, 'id','item_id');
    }

    public function item(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'item_id');
    }

}
