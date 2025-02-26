<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Traits\ApiResponse;

class CategoryController extends Controller
{
    use ApiResponse;

    protected CategoryService $categoryService;

    /**
     *
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of categories
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $categories = $this->categoryService->getAllCategories($request->get('per_page'));
        return $this->successResponse(CategoryResource::collection($categories), 'Categories retrieved successfully');
    }

    /**
     * Store a category.
     *
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $category = $this->categoryService->createCategory($data);
        return $this->successResponse(new CategoryResource($category), 'Category created successfully');
    }

    /**
     * Display the category.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return $category
            ? $this->successResponse(new CategoryResource($category), 'Category retrieved successfully')
            : $this->errorResponse('Category not found', 404);
    }

    /**
     * Update the category.
     *
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $data = $request->validated();
        $category = $this->categoryService->updateCategory($id, $data);
        return $category
            ? $this->successResponse(new CategoryResource($category), 'Category updated successfully')
            : $this->errorResponse('Category not found', 404);
    }

    /**
     * Remove the category.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->categoryService->deleteCategory($id)
            ? $this->successResponse([], 'Category deleted successfully')
            : $this->errorResponse('Category not found', 404);
    }
}
