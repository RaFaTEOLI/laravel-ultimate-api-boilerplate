<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\HttpStatus;
use Illuminate\Foundation\Testing\WithFaker;

class ResetPasswordTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    /**
     * It should send reset password link
     *
     * @return void
     */
    public function testShouldSendResetPasswordLink()
    {
        $user = User::find(1);

        $newUser = User::factory()->create();
        $response = $this->actingAs($user, "sanctum")->json("POST", env("APP_API") . "/forgot-password", [
            "email" => $newUser->email
        ]);

        $response->assertStatus(HttpStatus::SUCCESS);
        $response->assertJson(['status' => 'We have emailed your password reset link!']);
    }

    /**
     * It should change the user's password
     *
     * @return void
     */
    public function testShouldChangeUserPassword()
    {
        $newUser = User::factory()->create();
        $user = User::find($newUser->id);
        $response = $this->actingAs($user, "sanctum")->json("PATCH", env("APP_API") . "/reset-password", [
            "password" => "password",
            "password_confirmation" => "password"
        ]);

        $response->assertStatus(HttpStatus::SUCCESS);
        $response->assertJson(['message' => 'Your password has been reset!']);
    }
}
