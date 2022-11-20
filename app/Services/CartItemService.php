<?php
//This is Service file. You should write your logic in here
namespace App\Services;

use App\Models\Cart_item;
use App\Models\Cart;
use Illuminate\Support\Str;

class CartItemService
{
    public function __construct(private Cart_item $cart_item = new Cart_item())
    {
    }

    public function checkIfUserCartExists(int $user_id): self
    {
        if(Cart::query()->where('user_id', $user_id)->exists()){
            return $this;
        }

        $cart = new Cart();
        $cart->token = Str::random(32);
        $cart->user_id = $user_id;
        $cart->save();

        return $this;
    }

    public function setModel(Cart_item $cart_item): self
    {
        $this->cart_item = $cart_item;
        return $this;
    }

    public function assignAttributes(int $cart_id, int $item_id, int $quantity): self
    {
        $this->cart_item->cart_id = $cart_id;
        $this->cart_item->item_id = $item_id;
        $this->cart_item->quantity = $quantity;
        $this->cart_item->save();
        return $this;
    }

    public function getCartItems(): Cart_item
    {
        return $this->cart_item;
    }

}

?>
