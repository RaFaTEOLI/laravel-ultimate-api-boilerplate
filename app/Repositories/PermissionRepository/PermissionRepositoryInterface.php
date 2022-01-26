<?php

namespace App\Repositories\PermissionRepository;

use Illuminate\Support\Collection;

interface PermissionRepositoryInterface
{
    public function all(int $limit = 0, int $offset = 0): Collection;
    public function findById($id);
    public function update($id, $set);
    public function delete($id);
}
