<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    // Get all categories
    public function getAllCategories($perPage = null)
    {
        return $this->categoryRepository->getAll($perPage);
    }

    // Create new category
    public function createCategory(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    // Get category by ID
    public function getCategoryById($id)
    {
        return $this->categoryRepository->findById($id);
    }

    // Update category data
    public function updateCategory($id, array $data)
    {
        return $this->categoryRepository->update($id, $data);
    }

    // Delete a category
    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
