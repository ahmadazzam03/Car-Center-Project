<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SignUpController extends Controller
{
    public function create()
    {
        return view("auth.signupNew");
    }

    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'phone' => 'required|string|size:10|unique:users,phone',
            'password'=>['required','string','confirmed',
            Password::min(8)
            ->max(15)
            ->numbers()
            ->mixedCase()
            ->symbols()
            ->uncompromised()],
            /**
             *  -- To explain the above code:                 
                *Password must be minimum 8 chars
                *Maximum 15 chars
                *It must contain at least 1 number
                *It must contain at least 1 lowercase and at least 1 uppercase letters
                *It must container at least 1 symbol
                *It must not be compromised in latest data breaches
             */
            'role_id' =>'required|exists:roles,name'
        ]);

        $role = Cache::remember('role_' . $request->role_id, 3600, function () use ($request) {
            return Role::where('name', $request->role_id)->first();
        });
        // $role = Role::where('name',$request->role_id)->first();
        
       // Create user out of validated request data Hash password
        $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'role_id'=>$role->id
    ]);

        $user->sendEmailVerificationNotification();
        //Triggering the Registered event will try to send verification email
        // event(new Registered($user));

        // Auth::login($user);
		// Redirect to home page with flash message
        return back()
        ->with('success', 'Please verify your email address. We have sent a verification link to your email.');
    }
}
