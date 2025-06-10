<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\ContactUS;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // This method to redirects to home page in dashboard page    
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
        } 
        else {
            return redirect()->route('login');
        }
        // return count of owners
        $ownersCount = User::whereHas('role', fn($query) =>$query->where('name', 'owner'))->count();
        // return count of users
        $usersCount = User::whereHas('role', fn($query) =>$query->where('name', 'user'))->count();
        // return count of cars
        $carsCount = Car::count();
        // return count of orders
        $ordersCount = Order::count();
        return view('admin.dashboard', compact('user', 'ownersCount', 'carsCount', 'ordersCount', 'usersCount'));
    }

    // to get all Statistics we are neet for dashboard
    public function getStatistics()
    {
        $totalUsers = User::whereHas('role', fn($query) => $query->where('name', 'user'))->count();
        $totalOwner = User::whereHas('role', fn($query) => $query->where('name', 'owner'))->count();
        $totalCars = Car::count();
        $totalOrders = Order::count();
        $ordersStatus = Order::selectRaw('status, count(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();
        $approvedOrders = $ordersStatus['Paid'] ?? 0;
        $declinedOrders = $ordersStatus['Declined'] ?? 0;
        $pendingOrders = $ordersStatus['pending'] ?? 0;

        return response()->json([
            'barXValues' => ['Total user', 'Total owner', 'Total cars', 'Total order'],
            'barYValues' => [$totalUsers, $totalOwner, $totalCars, $totalOrders, $approvedOrders + $declinedOrders + $pendingOrders],
            'douXValues' => ['Paid', 'Declined', 'Pending'],
            'douYValues' => [$approvedOrders, $declinedOrders, $pendingOrders],
        ]);
        
    }

    public function showUserManagement(Request $request)
    {
        $sort = $request->query('sort');
    
        $query = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->with('role');
    
        if ($sort) {
            $direction = 'asc';
            if (strpos($sort, '-') === 0) {
                $direction = 'desc';
                $sort = substr($sort, 1);
            }
            $query->orderBy($sort, $direction);
        }
    
        $users = $query->paginate(5);
    
        return view('admin.userManagement', ['users' => $users]);
    }


    public function deleteUser(User $user)
    {
        if($user->role->name === 'owner')
        {
            $user->cars()->each(fn($car) => $car->delete());
        }
        else
        {
            $user->orders()->delete();
            $user->ratings()->delete();
            $user->comments()->delete();
            $user->favouriteCars()->detach();
        }
            $user->delete();
            return redirect()
            ->back()
            ->with('success',$user->role->name === 'owner' ? 'Owner was deleted' : 'User was deleted');
        
    }
    public function showOwnerManagement(Request $request)
    {

        $sort = $request->query('sort');
    
        $query = User::whereHas('role', function ($query) {
            $query->where('name', 'owner');
        })->with('role');
    
        if ($sort) {
            $direction = 'asc';
            if (strpos($sort, '-') === 0) {
                $direction = 'desc';
                $sort = substr($sort, 1);
            }
            $query->orderBy($sort, $direction);
        }
    
        $users = $query->paginate(5);
    
        return view('admin.ownerManagement', ['users' => $users]);
    }

    public function showCarManagement(Request $request)
    {
        $sort = $request->query('sort');
        $statusFilter = $request->query('status');
        $query = Car::with('primaryImage','maker','model','owner');
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }
        if ($sort) {
            $direction = 'asc';
            if (strpos($sort, '-') === 0) {
                $direction = 'desc';
                $sort = substr($sort, 1);
            }
            $query->orderBy($sort, $direction);
        }

        $cars = $query->paginate(5);
        return view('admin.carManagement', ['cars'=>$cars,'statusFilter' => $statusFilter]);
    }

    public function deleteCar(Car $car)
    {
        $car->delete();
        return redirect()->back()
            ->with('success', 'Car was deleted');
    }
    public function showOrders(Request $request)
    {

        $sort = $request->query('sort');
        $statusFilter = $request->query('status');

        $query = Order::with('car', 'user');
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }
        if ($sort) {
            $direction = 'asc';
            if (strpos($sort, '-') === 0) {
                $direction = 'desc';
                $sort = substr($sort, 1);
            }
            $query->orderBy($sort, $direction);
        }

        $orders = $query->paginate(5);
        return view('admin.orders', ['orders'=>$orders,'statusFilter' => $statusFilter]);
    }
    public function showRequest(Request $request)
    {
        $sort = $request->query('sort');
        $statusFilter = $request->query('status');
        $query = Car::with('primaryImage','maker','model','owner');
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }
        if ($sort) {
            $direction = 'asc';
            if (strpos($sort, '-') === 0) {
                $direction = 'desc';
                $sort = substr($sort, 1);
            }
            $query->orderBy($sort, $direction);
        }

        $cars = $query->paginate(5);
        return view('admin.carOwnerRequest', ['cars'=>$cars,'statusFilter' => $statusFilter]);
    }

    public function approveRequest(Car $car)
    {

        // Chang the status of order to approved 
        $car->update(['status' => 'Approved']);

        return redirect()->back()
            ->with('success', 'Request approved successfully!');
    }

    public function declineRequest(Car $car)
    {
        // Chang the status of order to approved 
        $car->update(['status' => 'Declined']);

        return redirect()->back()
            ->with('success', 'Request declined successfully!');
    }
    public function inbox(ContactUS $inboxes ,Request $request)
    {
        $sort = $request->query('sort');
        $query = ContactUS::query();
        if ($sort) {
            $direction = 'asc';
            if (strpos($sort, '-') === 0) {
                $direction = 'desc';
                $sort = substr($sort, 1);
            }
            $query->orderBy($sort, $direction);
        }

        $inboxes = $query->paginate(5);

        return view('admin.inbox', compact('inboxes'));

    }
    public function adminProfile()
    {
        return view('admin.adminProfile', ['admin' => Auth::user()]);
    }

    public function adminUpdate(Request $request)
    {
        // Define basic rules  
        $rules = [
            'name'=>['required','string','max:255'],
            'email'=>['required','string','email','max:255','unique:users,email,'.$request->user()->id],
            'phone'=>['required','string','size:10','unique:users,phone,'.$request->user()->id],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
            // Get the current user
            $user = $request->user();

            // Perform validation
            $data = $request->validate($rules);

            if($request->hasFile('image'))
            {
                if ($user->profile_image && Storage::exists($user->profile_image)) {
                    Storage::delete($user->profile_image);
                }
                $path = $request->file('image')->store('user-profile', 'public');
                $user->profile_image = $path;
            }
            // Fill the user data
            $user->fill($data);

            // Define success message
            $success = 'Your profile was updated';

            // Save the user
            $user->save();

            // Redirect user back to profile page with success message
            return redirect()->back()
            ->with('success', $success);
    }

    public function updatePassword(Request $request)
    {
        // Validate current password and new password
        $request->validate([
            'current_password' => ['required','current_password'],
            'password'=>['required','string','confirmed',
            Password::min(8)
            ->max(15)
            ->numbers()
            ->mixedCase()
            ->symbols()
            ->uncompromised()],
        ]);

        // Perform password update
        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        // Go back with success message
        return back()
        ->with('success', 'Password updated successfully');
    }



}
