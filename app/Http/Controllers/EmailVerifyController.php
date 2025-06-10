<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class EmailVerifyController extends Controller
{
        public function verify(EmailVerificationRequest $request)
    {
        $user = Auth::user();
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
        // Will be called when user clicks on the verification link in email
        $request->fulfill(); // enable account
        return redirect()->route('home')
        ->with('success','Your email has been verified successfully!');
    }

    public function notice(Request $request)
    {
        // Will be called if we setup verified middleware, so that only
        // verified users to be able to access certain routes
        return view('auth.verify-email');
    }

    public function send(Request $request)
    {
        // Will be called, if user loses his/her verification link and wants 
        // to resend the verification email
        /**@var User $user */
        $user = $request->user(); 
        $user->sendEmailVerificationNotification();
        return back()->with('success','A new verification link has been sent to your email address.');
    }
}
