<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_should_display_there_are_no_published_cars_on_home(): void
    {
        $response = $this->get('/');
        
        $response->assertStatus(200)
        ->assertSee("There are no published cars.");
    }
    public function test_should_display_published_cars_no_the_home_page(): void
    {
        $this->seed();
        /**
         * @var \Illuminate\Testing\TestResponse $response */
        $response = $this->get('/');
        $response->assertStatus(200)
        ->assertDontSee("There are no published cars.")
        ->assertViewHas('cars',function($collection){
            return $collection->count() == 5;
        });

    }
}
