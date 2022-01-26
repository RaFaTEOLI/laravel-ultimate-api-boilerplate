<?php

namespace App\Repositories\User;

use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function all(int $limit = 0, int $offset = 0): Collection;
    public function findById($userId);
    public function findByEmail($email);
    public function update($userId, $set);
    public function delete($userId);
    public function createType($type, $userId);
}
