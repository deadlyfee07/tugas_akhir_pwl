<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCategoryRequest;
use App\Http\Requests\Api\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }
}
