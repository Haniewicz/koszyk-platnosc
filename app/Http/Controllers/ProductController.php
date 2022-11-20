<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreUpdateRequest;
use App\Http\Requests\Product\DeleteFromCategoryRequest;
use App\Models\Product;
use App\Services\ProductService;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            new ProductCollection(Product::all())
        );
    }

    public function store(StoreUpdateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $product = $this->productService->assignAttributes(
            data_get($data, 'name'),
            data_get($data, 'description'),
            data_get($data, 'price'),
            data_get($data, 'category_id')
        )->getProduct();

        return response()->json(new ProductResource($product));
    }


    public function show(Product $product): JsonResponse
    {
        return response()->json(new ProductResource($product));
    }


    public function update(StoreUpdateRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        $product = $this->productService->setProduct($product)->assignAttributes(
            data_get($data, 'name'),
            data_get($data, 'description'),
            data_get($data, 'price'),
            data_get($data, 'category_id')
        )->getProduct();

        return response()->json(new ProductResource($product));
    }

    public function deleteFromCategory(DeleteFromCategoryRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        $product = $this->productService->setProduct($product)->deleteFromCategory(
            data_get($data, 'category_id')
        )->getProduct();

        return response()->json(new ProductResource($product));
    }

    public function destroy(Product $product): JsonResponse
    {
        return response()->json($product->delete());
    }
}
