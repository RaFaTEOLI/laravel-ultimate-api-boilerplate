<?php

namespace Tests\Integration;

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
        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/forgot-password", [
            "email" => $newUser->email
        ]);

        $response->assertStatus(HttpStatus::SUCCESS);
        $response->assertJson(['status' => 'We have emailed your password reset link!']);
    }
}
