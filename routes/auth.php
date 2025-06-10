<?php

use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;

// This middleware which allows accessing to routes only if the user is not authenticated.
Route::middleware(['guest'])->group(function ()
{
    // This Route For Signup Page 
    Route::get('/signup',[SignUpController::class,'create'])->name('signup');
    Route::post('/signup',[SignUpController::class,'store'])->name('signup.store');
    // This Route For login Page 
    Route::get('/login',[LoginController::class,'create'])->name('login');
    Route::post('/login',[LoginController::class,'store'])->name('login.store');

    // To show forgot password form page
    Route::get('/forgot-password',[PasswordResetController::class,'showForgotPassword'])->name('password.request');
    // When you enter your email in forgot password form and hit the submit button, this is route where the data should be submitted
    Route::post('/forgot-password',[PasswordResetController::class,'forgotPassword'])->name('password.email');
    // When you receive an email and click on password reset link in your email the following route should be opened
    Route::get('/reset-password/{token}',[PasswordResetController::class,'showResetPassword'])->name('password.reset');
    // When you enter new password and hit the submit button to actually reset your password this route will be used
    Route::post('/reset-password',[PasswordResetController::class,'resetPassword'])->name('password.update');

    Route::get('/login/oauth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('login.oauth');
    Route::get('/callback/oauth/{provider}', [SocialiteController::class, 'handleCallback']); 
});

Route::middleware(['auth'])->group(function (){

      // This route for logout 
        Route::post('/logout',[LoginController::class,'logout'])->name('logout');
});
 //These route to verify from email of users and restrict it by sent email verify to he/she
    Route::get('/email/verify/{id}/{hash}',[EmailVerifyController::class,'verify'])->middleware(['auth','signed'])->name('verification.verify');
    Route::get('/email/verify',[EmailVerifyController::class,'notice'])->middleware('auth')->name('verification.notice');
    Route::post('/email/verify/verification-notification',[EmailVerifyController::class,'send'])->middleware(['auth','throttle:6,1'])->name('verification.send');
/**
     * (signed) =>  middleware checks that the URL has valid generated signature and the URL has not been altered since it was generated.
     * (throttle) => middleware restricts number of requests in per time unit. In this example it restricts more than 6 requests per minute.
     *To verify the email user needs to be authentication as well based on the auth middleware.
 */