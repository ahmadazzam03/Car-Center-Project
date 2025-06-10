<?php

namespace Database\Factories;

use App\Models\CarModel;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ownerRole = Role::where('name','owner');

        return [
            'maker_id'=> Maker::inRandomOrder()->value('id')??Maker::factory()->create()->id,
            // اختيار صانع عشوائي، وإذا لم يكن هناك سجلات، ستكون القيمة null
            'model_id'=>function(array $attributes)
            {
                return CarModel::where('maker_id',$attributes['maker_id'])
                ->inRandomOrder()->value('id')??CarModel::factory()->create(['maker_id' => $attributes['maker_id']])->id;;    
            },
            // اختيار موديل عشوائي مرتبط بالمصنّع المختار
            'car_type_id'=> CarType::inRandomOrder()->value('id')?? CarType::factory()->create()->id,
            'fuel_type_id'=> FuelType::inRandomOrder()->value('id')??FuelType::factory()->create()->id,
            'owner_id' => User::whereHas('role', function ($query) {
                $query->where('name', 'owner');
                })->inRandomOrder()->value('id') ?? User::factory()->create()->id,
            'city_id'=> City::inRandomOrder()->value('id')??City::factory()->create()->id,
            'year'=>fake()->year(), //to generate a random year 
            'price'=>((int)fake()->randomFloat(2,5,100)) * 1000 ,
            //this will genrate a random number from 5000 - 100000 but in integer form 
            'vin' => strtoupper(Str::random(17)),
            'mileage' =>((int)fake()->randomFloat(2,5,500))*1000,
            'address'=>fake()->address(),
            'phone'=>function(array $attributes)
            {
                return User::find($attributes['owner_id'])->phone ??null;
            },
            //يتم استخراج رقم هاتف المستخدم المرتبط بـ 
            //owner_id.
            'description'=>fake()->text(2000),
            'published_at'=>fake()->optional(0.9)
            //هناك احتمال 90% (0.9) أن يتم إنشاء قيمة عشوائية لحقل
            //هناك احتمال 10% (1 - 0.9) أن يكون الحقل فارغًا (null).
            ->dateTimeBetween('-1 month','+1 day'),
            /**
             * تولّد هذه الطريقة تاريخًا ووقتًا عشوائيًا بين نطاق oمعين. في هذه الحالة:
                *يبدأ النطاق قبل شهر واحد من تاريخ اليوم (-1 month).
                *ينتهي النطاق بعد يوم واحد من تاريخ اليوم      (+1 day).
                */
                'status' => 'pending'

        ];
    }
}
