<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = Role::where('name', 'user')->first(); // جلب الدور العادي من قاعدة البيانات

        return [
            'user_id' => User::factory()->create([
                'role_id' => $role->id,
            ])->id, 
            'car_id' => Car::factory(),   // إنشاء سيارة عشوائية لكل طلب
            'status' => $this->faker->randomElement(['pending', 'completed', 'canceled']), // حالة الطلب
            'price' => $this->faker->randomFloat(2, 10000, 50000), // سعر عشوائي بين 10,000 و 50,000
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
