<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\CartItem\CartCollection;
use Illuminate\Http\JsonResponse;
use App\Models\CartItem;
use App\Models\Cart;
use App\Http\Requests\Cart\StoreUpdateRequest;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    public function index(Cart $cart): JsonResponse
    {
        return response()->json(new CartCollection($cart->cartItems));
    }

    public function add_item(StoreUpdateRequest $request, $cartToken): JsonResponse
    {
        $data = $request->validated();

        $token = $this->cartService->checkIfCartExists($cartToken, data_get($request->user(), 'id', null))
            ->assignAttributes(
                data_get($data, 'item_id'),
                data_get($data, 'quantity')
            )->getCartToken();

        return response()->json(['cart_token' => $token]);
    }

    public function update_item(StoreUpdateRequest $request, Cart $cart, CartItem $cartItem): JsonResponse
    {
        $data = $request->validated();

        $this->cartService->checkIfCartExists($cart->token, data_get($request->user(), 'id', null))->setModel($cartItem)->assignAttributes(
            data_get($data, 'item_id'),
            data_get($data, 'quantity')
        );

        return response()->json(True);
    }

    public function delete_item(Cart $cart, CartItem $cartItem): JsonResponse
    {
        return response()->json($cart->cartItems->find($cartItem->id)->delete());
    }

    /**
     * @throws \JsonException
     */
    public function checkout(CheckoutRequest $request, Cart $cart): JsonResponse
    {
        $data = $request->validated();

        $checkout = $this->cartService->checkout($cart, $data, data_get($request->user(), 'id', null));

        return response()->json($checkout);
    }

}
