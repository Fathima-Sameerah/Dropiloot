<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(protected UserRepository $repository) {}

    public function view(User $user): User
    {
        return $user;
    }

    public function update(User $user, array $data): User
    {
        return $this->repository->update($user, $data);
    }

    public function upgradeToSeller(User $user, string $businessName): User
    {
        $user->update([
            'role' => 'seller',
            'name' => $businessName,
        ]);
        return $user;
    }
}
