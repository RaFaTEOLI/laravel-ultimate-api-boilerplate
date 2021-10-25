<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Role;
use App\Models\User;
use App\Services\Permission\CreatePermissionService;

class PermissionTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new permission
     *
     * @return void
     */
    public function testShouldCreateANewPermission()
    {
        $userAdmin = User::factory()->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        $createdPermission = (new CreatePermissionService())->execute([
            "name" => $this->faker->name(),
            "description" => $this->faker->name(),
            "create" => "on",
        ]);

        $this->assertTrue($createdPermission);
    }
}
