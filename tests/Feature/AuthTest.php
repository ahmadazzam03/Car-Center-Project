<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_returns_success_on_login_page(): void
    {
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->get(route('login'));
        $response->assertStatus(200)
        ->assertSee('Login')
        ->assertSee('Forgot Password?')
        ->assertSee('Click here to create one')
        ->assertSee('Google')
        ->assertSee('Facebook')
        ->assertSee('<a href="'.route('password.request').'"',false)
        ->assertSee('<a href="'.route('signup').'">',false)
        ->assertSee('<a href="'.route('login.oauth','google').'"',false)
        ->assertSee('<a href="'.route('login.oauth','facebook').'"',false);
    }
    public function test_should_not_be_possible_to_login_with_incorrect_credentials(): void
    {
        User::factory()->create([
            'email' =>'jamel@gmail.com',
            'password' =>bcrypt('password')
        ]);
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->post(route('login.store'),[
            'email' =>'jamel@gmail.com',
            'password' =>'13245'
        ]);

        $response->assertStatus(302)
        // ->assertSessionHasErrors(['email']);
        ->assertInvalid(['email']);
    }
    public function test_should_be_possible_to_login_with_correct_credentials(): void
    {
        User::factory()->create([
            'email' =>'jamel@gmail.com',
            'password' =>bcrypt('password')
        ]);
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->post(route('login.store'),[
            'email' =>'jamel@gmail.com',
            'password' =>'password'
        ]);

        $response->assertStatus(302)
        ->assertSessionHas(['success']);
    }
    public function test_returns_success_on_signup_page(): void
    {
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->get(route('signup'));

        $response->assertStatus(200);
    }
    public function test_returns_success_on_forgot_password_page(): void
    {
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
    }
    
}
