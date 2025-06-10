<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_should_not_be_possible_to_access_profile_as_guest_user(): void
    {
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->get(route('profile.index'));
        
        $response->assertRedirectToRoute('login');

        
    }
    public function test_should_be_possible_to_access_profile_as_auth_user(): void
    {
        $user = User::factory()->create(); 

        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->actingAs($user)
        ->get(route('profile.index'));
        
        $response->assertOk()->assertSee("My Profile");

        
    }
}
