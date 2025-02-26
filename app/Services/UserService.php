<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // Get all users
    public function getAllUsers($perPage)
    {
        return $this->userRepository->getAll($perPage);
    }

    // Create new user
    public function createUser(array $data)
    {
        return $this->userRepository->create($data);
    }

    // Get user by ID
    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    // Update user data
    public function updateUser($id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    // Delete a user
    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }
}
