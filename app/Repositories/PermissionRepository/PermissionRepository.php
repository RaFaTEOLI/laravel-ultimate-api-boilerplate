<?php

namespace App\Repositories\PermissionRepository;

use App\Models\Permission;
use App\Repositories\RolesRepository\RolesRepository;
use Illuminate\Support\Collection;

class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * Fetch All
     *
     * @return Permission
     */
    public function all(int $limit = 0, int $offset = 0): Collection
    {
        return Permission::when($limit, function ($query, $limit) {
            return $query->limit($limit);
        })
            ->when($offset && $limit, function ($query, $offset) {
                return $query->offset($offset);
            })->get()->map->format();
    }

    /**
     * Fetch All Permissions that the specific role doesn't have
     *
     * @return Permission
     */
    public function findPermissionsNotInRole($roleId)
    {
        $role = (new RolesRepository())->findById($roleId);
        $rolePermissions = [];
        foreach ($role->permissions as $permission) {
            array_push($rolePermissions, $permission->id);
        }

        return Permission::whereNotIn("id", $rolePermissions)->get();
    }

    /**
     * Get By Id
     *
     * @return Permission
     * @param integer $id
     */
    public function findById($id)
    {
        return Permission::find($id);
    }

    /**
     * Update
     *
     * @return Boolean
     * @param integer $id
     * @param array $set
     */
    public function update($id, $set)
    {
        $obj = Permission::where("id", $id)->first();

        $obj->update($set);

        return $obj;
    }

    /**
     * Delete
     *
     * @return Boolean
     * @param integer $id
     */
    public function delete($id)
    {
        $obj = Permission::where("id", $id)->delete();

        return true;
    }
}
