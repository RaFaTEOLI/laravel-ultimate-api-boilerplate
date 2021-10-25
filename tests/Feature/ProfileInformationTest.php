<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_profile_information_can_be_updated()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->put('/user/profile-information', [
            'name' => 'Test Name',
            'email' => 'test@example.com',
        ]);

        $this->assertEquals('Test Name', $user->fresh()->name);
        $this->assertEquals('test@example.com', $user->fresh()->email);
    }
}
