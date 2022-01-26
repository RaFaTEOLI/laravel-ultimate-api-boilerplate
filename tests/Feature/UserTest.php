<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use App\Http\HttpStatus;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    /**
     * It should return the list of users
     *
     * @return void
     */
    public function testShouldFetchListOfUsers()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "sanctum")->json("GET", env("APP_API") . "/users");

        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should return the list of users with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfUsersWithLimitAndOffset()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "sanctum")->json("GET", env("APP_API") . "/users?offset=0&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }

    /**
     * It should return the user by id
     *
     * @return void
     */
    public function testShouldFetchUserById()
    {
        $user = User::find(1);
        User::create([
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => Hash::make("12345678"),
        ]);
        $response = $this->actingAs($user, "sanctum")->json("GET", env("APP_API") . "/users/1");

        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should update an user
     *
     * @return void
     */
    public function testShouldUpdateAnUser()
    {
        $user = User::find(1);
        $userToUpdate = User::create([
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => Hash::make("12345678"),
        ]);

        $response = $this->actingAs($user, "sanctum")->json("PUT", env("APP_API") . "/users/{$userToUpdate->id}", [
            "name" => "UpdatedName",
        ]);
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return 401 because the user is not authorized to access this endpoint
     *
     * @return void
     */
    public function testShouldNotReturnUsersBecauseUserIsNotAuthorized()
    {
        $response = $this->json("GET", env("APP_API") . "/users");

        $response->assertStatus(HttpStatus::UNAUTHORIZED);
    }

    /**
     * It should not create a new user because the email already exists
     *
     * @return void
     */
    public function testShouldNotCreateANewUserBecauseEmailAlreadyExists()
    {
        $user = [
            "name" => $this->faker->name,
            "email" => "admin@gmail.com",
            "password" => 'password',
            "password_confirmation" => 'password',
        ];

        $response = $this->json("POST", env("APP_API") . "/auth/register", $user);

        $response->assertStatus(HttpStatus::UNPROCESSABLE_ENTITY);
    }

    /**
     * It should not add a role to the user because the user is not admin
     *
     * @return void
     */
    public function testShouldNotAddARoleToUserBecauseUserIsNotAdmin()
    {
        $newUser = User::factory()->create();
        $user = User::find($newUser->id);
        $response = $this->actingAs($user, "sanctum")->json("PATCH", env("APP_API") . "/users/{$user->id}/role/1");

        $response->assertStatus(HttpStatus::FORBIDDEN);
    }

    /**
     * It should not delete user's role because the user is not admin
     *
     * @return void
     */
    public function testShouldNotDeleteUsersRoleBecauseUserIsNotAdmin()
    {
        $newUser = User::factory()->create();
        $user = User::find($newUser->id);
        $response = $this->actingAs($user, "sanctum")->json("DELETE", env("APP_API") . "/users/{$user->id}/role/1");

        $response->assertStatus(HttpStatus::FORBIDDEN);
    }

    /**
     * It should not delete admin role from user because user is admin
     *
     * @return void
     */
    public function testShouldNotDeleteAdminRoleFromUserBecauseUserIsAdmin()
    {
        $user = User::find(1);

        $response = $this->actingAs($user, "sanctum")->json("DELETE", env("APP_API") . "/users/{$user->id}/role/1");

        $response->assertStatus(HttpStatus::BAD_REQUEST);
    }

    /**
     * It should delete an user by id
     *
     * @return void
     */
    public function testShouldDeleteAnUserById()
    {
        $user = User::find(1);

        $userToDelete = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->json('DELETE', env('APP_API') . "/users/{$userToDelete->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should delete user's role
     *
     * @return void
     */
    public function testShouldDeleteRoleFromUser()
    {
        $user = User::find(1);
        $userToDeleteRole = User::factory()->create();

        $customerRole = Role::where("name", "customer")->first();
        $userToDeleteRole->attachRole($customerRole);

        $response = $this->actingAs($user, "sanctum")->json("DELETE", env("APP_API") . "/users/{$userToDeleteRole->id}/role/{$customerRole->id}");

        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should add role to user
     *
     * @return void
     */
    public function testShouldAddRoleToUser()
    {
        $user = User::find(1);

        $userToAddRole = User::factory()->create();
        $response = $this->actingAs($user, "sanctum")->json("PATCH", env("APP_API") . "/users/{$userToAddRole->id}/role/1");

        $response->assertStatus(HttpStatus::CREATED);
    }
}
