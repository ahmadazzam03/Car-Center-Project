<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarRating;
use App\Models\Role;
use Illuminate\Http\Request;

class CarRatingController extends Controller
{

    public function store(Request $request, Car $car)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5'
        ]);

            CarRating::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'car_id'  =>$car->id,
            ],
            ['rating'  => $request->rating]
        );

        return redirect()->back()->with('success' ,'The rating has been done');
    }
    
}
