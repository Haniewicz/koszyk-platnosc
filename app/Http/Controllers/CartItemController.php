<?php

namespace App\Http\Controllers;

use App\Services\CartItemService;
use App\Http\Resources\CartItem\CartItemCollection;
use App\Http\Resources\CartItem\CartItemResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Cart_item;
use App\Http\Requests\Cart\StoreUpdateRequest;

class CartItemController extends Controller
{

    public function __construct(private Request $request, private CartItemService $cartItemService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            new CartItemCollection($this->request->user()->cart->cart_items)
        );
    }


    public function store(StoreUpdateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $cart_item = $this->cartItemService->assignAttributes(
            $request->user()->cart->id,
            data_get($data, 'item_id'),
            data_get($data, 'quantity')
        )->getCartItems();

        return response()->json(
            new CartItemResource($cart_item)
        );
    }

    public function show(Cart_item $cart_item): JsonResponse
    {
        return response()->json(
            new CartItemResource($cart_item)
        );
    }

    public function update(StoreUpdateRequest $request, Cart_item $cart_item): JsonResponse
    {
        $data = $request->validated();

        $cart_item = $this->cartItemService->setModel($cart_item)->assignAttributes(
            $request->user()->cart->id,
            data_get($data, 'item_id'),
            data_get($data, 'quantity')
        )->getCartItems();

        return response()->json(
            new CartItemResource($cart_item)
        );
    }

    public function destroy(Cart_item $cart_item): JsonResponse
    {
        return response()->json($cart_item->delete());
    }

}
