<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\HttpStatus;
use Illuminate\Foundation\Testing\WithFaker;

class VerifyEmailTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    /**
     * It should send verification email
     *
     * @return void
     */
    public function testShouldSendVerificationEmail()
    {
        $user = User::factory()->create();
        $user = User::find($user->id);
        $response = $this->actingAs($user, "sanctum")->json("POST", env("APP_API") . "/email/verify/resend");

        $response->assertStatus(HttpStatus::SUCCESS);
        $response->assertJson(['message' => 'Verification link sent!']);
    }
}
