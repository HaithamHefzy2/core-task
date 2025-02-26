<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    // Retrieve all categories
    public function getAll($perPage)
    {
        return $perPage ? Category::paginate($perPage) : Category::all();
    }

    // Create a new category
    public function create(array $data)
    {
        return Category::create($data);
    }

    // Find category by ID
    public function findById($id)
    {
        return Category::find($id);
    }

    // Update category data
    public function update($id, array $data)
    {
        $category = Category::find($id);
        if ($category) {
            $category->update($data);
            return $category;
        }
        return null;
    }

    // Delete a category
    public function delete($id)
    {
        $category = Category::find($id);
        return $category ? $category->delete() : false;
    }
}
