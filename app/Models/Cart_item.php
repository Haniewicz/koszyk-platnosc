<?php

namespace App\Models;

use Database\Factories\Cart_itemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_item extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id',
        'item_id',
        'quantity'
    ];

    protected static function newFactory(): Cart_itemFactory
    {
        return Cart_itemFactory::new();
    }
}
