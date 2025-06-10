<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_should_not_be_possible_to_access_car_create_page_as_guest_user(): void
    {
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->get(route('car.create'));
        $response->assertRedirectToRoute('login');
        $response->assertStatus(302);
    }
    public function test_should_be_possible_to_access_car_create_page_as_authenticated_user(): void
    {
        $user = User::factory()->create(); 
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->actingAs($user)
        ->get(route('car.create'));

        $response->assertOk()
        ->assertSee("Add new car");

    }
    public function test_should_not_be_possible_to_access_my_cars_page_as_guest_user(): void
    {
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->get(route('car.index'));
        
        $response->assertRedirectToRoute('login');

        
    }
    public function test_should_be_possible_to_access_my_cara_page_as_authenticated_user(): void
    {
        $user = User::factory()->create(); 
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->actingAs($user)
        ->get(route('car.index'));

        $response->assertOk()
        ->assertSee("My Cars");

    }
    public function test_should_not_be_possible_to_access_my_sales_page_as_guest_user(): void
    {
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->get(route('car.sales'));
        
        $response->assertRedirectToRoute('login');

        
    }
    public function test_should_be_possible_to_access_my_sales_page_as_authenticated_user(): void
    {
        $user = User::factory()->create(); 
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->actingAs($user)
        ->get(route('car.sales'));

        $response->assertOk()
        ->assertSee("Incoming Orders");

    }
    public function test_should_not_be_possible_to_access_my_orders_page_as_guest_user(): void
    {
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->get(route('car.order'));
        
        $response->assertRedirectToRoute('login');

        
    }
    public function test_should_be_possible_to_access_my_orders_page_as_authenticated_user(): void
    {
        $user = User::factory()->create(); 
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->actingAs($user)
        ->get(route('car.order'));

        $response->assertOk()
        ->assertSee("My Order");

    }
}
