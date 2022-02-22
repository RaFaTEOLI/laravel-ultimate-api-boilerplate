<?php

namespace App\Repositories\UserRepository;

use App\Repositories\UserRepository\UserRepositoryInterface;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Nette\Schema\Expect;

class UserRepository implements UserRepositoryInterface
{
    /*
        Get All Active Users
    */
    public function all(int $limit = 0, int $offset = 0): Collection
    {
        try {
            $users = User::where("deleted_at", null)
                ->when($limit, function ($query, $limit) {
                    return $query->limit($limit);
                })
                ->when($offset && $limit, function ($query, $offset) {
                    return $query->offset($offset);
                })
                ->get()
                ->map->format();

            return $users;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    /*
        Get An User By Id
    */
    public function findById($id)
    {
        return User::where("id", $id)
            ->where("deleted_at", null)
            ->firstOrFail()
            ->format();
    }

    /*
        Get An User By email
    */
    public function findByEmail($email)
    {
        return User::where("email", $email)
            ->where("deleted_at", null)
            ->firstOrFail()
            ->format();
    }

    public function update($userId, $set)
    {
        $user = User::where("id", $userId)->firstOrFail();

        $user->update($set);
    }

    public function delete($userId)
    {
        try {
            $this->update($userId, ["deleted_at" => Carbon::now()]);

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    public function createType($type, $userId)
    {
        $user = User::find($userId);
        $role = Role::where("name", strtolower($type))->first();

        if (!empty($role)) {
            $user->attachRole($role);
        } else {
            throw new Exception("No type specified");
        }
    }
}
