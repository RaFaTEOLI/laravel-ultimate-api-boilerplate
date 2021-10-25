<?php

namespace Tests\Unit;

use App\Services\InvitationLink\CreateInvitationLinkService;
use App\Services\User\CreateUserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Services\User\RemoveUserRoleService;
use App\Services\User\UpdateUserRoleService;
use Exception;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new user
     *
     * @return void
     */
    public function testShouldCreateANewUser()
    {
        $user = User::factory()->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $createdUser = (new CreateUserService())->execute([
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => "12345678",
            "password_confirmation" => "12345678",
        ]);

        $this->assertTrue(is_numeric($createdUser->id));
    }

    /**
     * It should add a role to a user
     *
     * @return void
     */
    public function testShouldAddRoleToUser()
    {
        $userAdmin = User::factory()->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        $user = User::factory()->create();

        $updatedRole = (new UpdateUserRoleService())->execute([
            "userId" => $user->id,
            "roleId" => $role->id,
        ]);

        $this->assertTrue(is_numeric($updatedRole->roles[0]->id));
    }

    /**
     * It should delete a role to a user
     *
     * @return void
     */
    public function testShouldDeleteRoleToUser()
    {
        $userAdmin = User::factory()->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        $user = User::factory()->create();

        $updatedRole = (new RemoveUserRoleService())->execute([
            "userId" => $user->id,
            "roleId" => $role->id,
        ]);

        $this->assertTrue(count($updatedRole->roles) < 1);
    }

    /**
     * It should not delete admin role from user because user is admin
     *
     * @return void
     */
    public function testShouldNotDeleteAdminRoleFromUserBecauseUserIsAdmin()
    {
        $this->expectException(Exception::class);

        $userAdmin = User::factory()->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        $adminMaster = User::find(1);

        (new RemoveUserRoleService())->execute([
            "userId" => $adminMaster->id,
            "roleId" => $role->id,
        ]);
    }
}
