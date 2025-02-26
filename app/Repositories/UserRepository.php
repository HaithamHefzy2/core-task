<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    // Retrieve all users
    public function getAll($perPage = null)
    {
        return $perPage ? User::paginate($perPage) : User::all();
    }

    // Create a new user
    public function create(array $data)
    {
        return User::create($data);
    }

    // Find user by ID
    public function findById($id)
    {
        return User::find($id);
    }

    // Update user data
    public function update($id, array $data)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    // Delete a user
    public function delete($id)
    {
        $user = User::find($id);
        return $user ? $user->delete() : false;
    }
}
