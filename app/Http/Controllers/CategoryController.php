<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Category\StoreUpdateRequest;
use App\Services\CategoryService;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryCollection;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            new CategoryCollection(Category::all())
        );
    }

    public function store(StoreUpdateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $category = $this->categoryService->assignAttributes(
            data_get($data, 'name')
        )->getCategory();
        return response()->json(
            new CategoryResource($category)
        );
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json(
            new CategoryResource($category)
        );
    }


    public function update(StoreUpdateRequest $request, Category $category): JsonResponse
    {
        $data = $request->validated();
        $category = $this->categoryService->setCategory($category)->assignAttributes(
            data_get($data, 'name')
        )->getCategory();
        return response()->json(
            new CategoryResource($category)
        );
    }

    public function destroy(Category $category): JsonResponse
    {
        return response()->json($category->delete());
    }
}
