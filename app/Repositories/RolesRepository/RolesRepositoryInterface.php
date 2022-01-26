<?php

namespace App\Repositories\RolesRepository;

use Illuminate\Support\Collection;

interface RolesRepositoryInterface
{
    public function all(int $limit = 0, int $offset = 0): Collection;
    public function findById($userId);
    public function update($userId, $set);
    public function delete($userId);
}
