<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        
        // create a car type
        CarType::factory()
            ->sequence(
            ['name' =>'Sedan'],          
            ['name' =>'Hatchback'], 
            ['name' =>'SUV'],  
            ['name' =>'Pickup Truck'],
            ['name' =>'Minivan'],
            ['name' =>'Jeep'],
            ['name' =>'Coupe'], 
            ['name' =>'Crossover'],
            ['name' =>'Sports Car'], 
        )
        ->count(9) //total number of records 
        ->create();
    
             // create a fuel type of cars
            FuelType::factory()
                ->sequence(
                ['name' =>'Gasoline'] ,           
                ['name' => 'Diesel']   ,
                ['name' =>'Electric'] ,    
                ['name' =>'Hybrid'] ,
        )->count(4)
        ->create();
    
            // states this is array that containe 
            //key to indcaite a city and value to represent a area of this city 
            $states = [
                'Amman' => [
                    'Abdoun', 'Jabal Al-Weibdeh', 'Jabal Amman', 'Shmeisani', 'Sweifieh', 
                    'Raghadan', 'Tla’a Al-Ali', 'Al-Madina Al-Monawara', 'Bayader Wadi Seer', 'Deir Ghbar'
                ],
                'Irbid' => [
                    'Al-Rasheed', 'Al-Saray', 'Al-Khwarizmi', 'Al-Hashemi', 'Karmeh', 
                    'Al-Mazar', 'Al-Quds', 'Al-Tilal', 'Al-Bashaer', 'Al-Rawda'
                ],
                'Zarqa' => [
                    'Al-Hashimi', 'Al-Musharraf', 'Al-Jandoubi', 'Al-Tawfiq', 'Al-Mahatta', 
                    'Hawzat Al-Zarqa', 'Al-Muqabla', 'Al-Faisal', 'Al-Kindah', 'Al-Madina'
                ],
                'Aqaba' => [
                    'Al-Muhtadi', 'Al-Bayader', 'Al-Kahtaniya', 'Al-Mansheya', 'Al-Shat', 
                    'Al-Ahly', 'Al-Reda', 'Al-Jandala', 'Al-Hamra', 'Al-Mansour'
                ],
                'Mafraq' => [
                    'Al-Dakhiliya', 'Al-Salam', 'Al-Sokhna', 'Al-Manshieh', 'Al-Taybah', 
                    'Al-Khobar', 'Al-Sabha', 'Al-Fayha', 'Al-Huda', 'Al-Jouf'
                ],
                'Balqa' => [
                    'Salt', 'Dibeen', 'Al-Fuhais', 'Al-Karak', 'Al-Shunneh', 
                    'Wadi Al-Seer', 'Ain Al-Basha', 'Al-Mujib', 'Al-Khibet', 'Al-Balqa'
                ],
                'Madaba' => [
                    'Madaba', 'Al-Karak', 'Al-Mahaier', 'Husseiniya', 'Al-Montazah', 
                    'Al-Fahd', 'Al-Samara', 'Al-Zai', 'Al-Khalidiyah', 'Al-Bayda'
                ],
                'Karak' => [
                    'Karak', 'Tafila', 'Al-Salt', 'Al-Qatar', 'Al-Muthanna', 
                    'Ma’an', 'Al-Buwayda', 'Al-Sayf', 'Al-Jabal', 'Al-Safa'
                ],
                'Jerash' => [
                    'Jerash', 'Al-Azraq', 'Al-Hayyaj', 'Al-Munif', 'Al-Qasr', 
                    'Al-Qitar', 'Al-Ramtha', 'Al-Jadida', 'Al-Mahdah', 'Al-Der'
                ],
                'Ma’an' => [
                    'Ma’an', 'Al-Jawf', 'Al-Kheir', 'Al-Ghabariyah', 'Al-Naqah', 
                    'Al-Madbah', 'Al-Haish', 'Al-Mujahideen', 'Al-Wadi', 'Al-Sahab'
                ]
            ];
            

            foreach ($states as $state => $cities)
            {
                State::factory()
                ->state(['name'=>$state])
                ->has(
                    City::factory()
                    ->count(count($cities))
                    ->sequence(...array_map(fn($city)=>['name' => $city] ,$cities)))
                    //تستخدم array_map لتطبيق دالة سهمية (arrow function) على كل عنصر في المصفوفة 
                    //$cities.
                    ->create();
                    /**
                     * لكل ولاية في المصفوفة 
                     * $states:

                     * يتم إنشاء سجل في جدول 
                     * states 
                     * باستخدام 
                     * Factory 
                     * لنموذج State.

                     * يتم إنشاء السجلات التابعة لها في جدول 
                     * cities 
                     * باستخدام 
                     * Factory 
                     * لنموذج City.

                     *أسماء المدن يتم تحديدها بناءً على المصفوفة 
                     *$cities 
                     *المرتبطة بالولاية.
                     */
                }

                $makers = [
                    'Toyota' => ['Camry', 'Corolla', 'RAV4'],
                    'Ford' => ['F-150', 'Mustang','Edge'],
                    'Honda' => ['Civic', 'Accord', 'HR-V'],
                    'Chevrolet' => ['Equinox', 'Silverado','Traverse'],
                    'Nissan' => ['Altima', 'Rogue', 'Sentra', 'Frontier'],
                    'Lexus' => ['Rx400', 'ES','LX'],
                    'Tesla' => ['Model S', 'Model 3', 'Model X', 'Model Y', 'Cybertruck'],
                    'Rivian' => ['R1T', 'R1S'],
                    'Lucid Motors' => ['Lucid Air'], 
                    'BMW' => ['i3', 'i4', 'iX', 'i8'], 
                    'Audi' => ['e-tron', 'Q4 e-tron', 'e-tron GT'], 
                    'Porsche' => ['Taycan', 'Taycan Cross Turismo'], 
                    'Volkswagen' => ['ID.3', 'ID.4', 'ID. Buzz'], 
                    'Mercedes-Benz' => ['EQC', 'EQB', 'EQS'], 
                ];
                    foreach ($makers as $maker => $models)
                    {
                        Maker::factory()
                        ->state(['name'=>$maker])
                        ->has(
                            CarModel::factory()
                            ->count(count($models))
                            ->sequence(...array_map(fn($models)=>['name' => $models] ,$models)))
                            ->create();
                    }

                    $userRole = Role::firstOrCreate(['name'=> 'user']);
                    $ownerRole = Role::firstOrCreate(['name'=> 'owner']);
                    //Create A 3 Users 
                    User::factory()
                    ->count(2)
                    ->state(['role_id' =>$userRole->id ])
                    ->create();
                    // Create two owner 
                    User::factory()
                    ->count(2)
                    ->state(['role_id' => $ownerRole->id])
                    ->has(Car::factory()
                        ->count(25) 
                        ->has(
                            CarImage::factory()
                            ->count(5)//We create a 5 image to every car throught carImage relation
                            ->sequence(fn(Sequence $sequence)=>
                            ['position'=>$sequence->index %5 +1]), //arrangment image position
                            'images')
                        ->hasFeatures()
                        )
                        ->create();
    }
}
