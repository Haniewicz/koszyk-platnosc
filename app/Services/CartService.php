<?php
//This is Service file. You should write your logic in here
namespace App\Services;

use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class CartService
{
    private Object $cart;

    public function __construct(private CartItem $cartItem = new CartItem())
    {
    }

    public function checkIfCartExists(string $cartToken, int|null $userID): self
    {
        if(Cart::query()->where('token', $cartToken)->exists()){
            $this->cart = Cart::query()->where('token', $cartToken)->first();
            return $this;
        }

        $this->cart = new Cart();
        $this->cart->token = Str::random(32);
        $this->cart->user_id = $userID;
        $this->cart->save();

        return $this;
    }

    public function setModel(CartItem $cartItem): self
    {
        $this->cartItem = $cartItem;
        return $this;
    }

    public function assignAttributes(int $itemId, int $quantity): self
    {
        $this->cartItem->cart_id = $this->cart->id;
        $this->cartItem->item_id = $itemId;
        $this->cartItem->quantity = $quantity;
        $this->cartItem->save();

        return $this;
    }

    public function getCartToken(): String
    {
        return $this->cart->token;
    }

    public function checkout(Cart $cart, array $data, int|null $userID): array
    {
        $order = new Order();
        $order->user_id = $userID;
        $order->delivery_address = $data;
        $order->status = 'created';
        $order->save();

        foreach ($cart->cartItems as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->item_id = $cartItem->item_id;
            $orderItem->price = $cartItem->item->price;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->save();
        }

        $cart->delete();

        return [
            'order' => $order,
            'order_items' => $order->orderItems
        ];
    }


}


?>
