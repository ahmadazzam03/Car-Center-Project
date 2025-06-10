<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function index()
    {
        // To render cars in wishList for authenticated users
        $cars =User::find(Auth::id())
        ->favouriteCars()
        ->with(['primaryImage','city','maker','model','carType','fuelType'])
        ->paginate(15);
        return view('wishlist.index',['cars' => $cars]);
    }

    public function storeDestroy(Car $car )
    {
        // Add and remove car from watchlist

        // get authenticated user 
        $user = Auth::user();

        // Check if the current car is already added into favourite cars
        $carExists = $user->favouriteCars()->where('car_id',$car->id)->exists(); 

         // Remove if it exists
        if ($carExists) {
            $user->favouriteCars()->detach($car);
            return response()->json(
                [
                'added' => false,
                'message' => 'Car was removed from WishList'
            ]);
        }

        // Add the car into favourite cars of the user
        $user->favouriteCars()->attach($car);
        return response()->json([
            'added' => true,
            'message' => 'Car was added to WishList'
        ]);
    }
}
