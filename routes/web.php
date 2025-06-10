<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarRatingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishListController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    // Dashboard Page 
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // getStatistics
    Route::get('/statistics', [AdminController::class, 'getStatistics'])->name('admin.getStatistics');
    // User management
    Route::get('/admin/user-management', [AdminController::class, 'showUserManagement'])->name('admin.showUserManagement');
    Route::delete('/admin/delete-user/{user}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    // Owner Management
    Route::get('/admin/owner-management', [AdminController::class, 'showOwnerManagement'])->name('admin.showOwnerManagement');
    // Orders 
    Route::get('/admin/orders', [AdminController::class, 'showOrders'])->name('admin.showOrders');
    // car Management
    Route::get('/admin/car-management', [AdminController::class, 'showCarManagement'])->name('admin.showCarManagement');
    Route::delete('/admin/delete-car/{car}', [AdminController::class, 'deleteCar'])->name('admin.deleteCar');
    // car owner Request 
    Route::get('/admin/car-owner-request', [AdminController::class, 'showRequest'])->name('admin.showRequest');
     // Approve Request
    Route::put('/admin/request/{car}/approve', [AdminController::class, 'approveRequest'])->name('admin.approveRequest');
     // Decline Request
    Route::put('/admin/request/{car}/decline', [AdminController::class, 'declineRequest'])->name('admin.declineRequest');
     // Inbox
    Route::get('/admin/inbox', [AdminController::class, 'inbox'])->name('admin.inbox');
    // Admin Profile
    Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.adminProfile');
    Route::put('/admin/profile',[AdminController::class,'adminUpdate'])->name('admin.adminUpdate');
    Route::put('/admin/password',[AdminController::class,'updatePassword'])->name('admin.updatePassword');
});

// This Route For Home Page (Index page) 
Route::get("/",[HomeController::class,'index'])->name('home');
Route::post('/contact', [HomeController::class, 'ContactStore'])->name('contact.ContactStore');

Route::middleware(['auth'])->group(callback:function ()
{
    Route::middleware(['verified'])->group(function()
    {
        Route::view('/nearest-charging-stations', 'car.charging')->name('home.chargingStations');
        // This Route to Accsess to watchlist Method in the carController 
        Route::get('/wishList',[WishListController::class,'index'])->name('wishList.index');
        Route::post('/wishList/{car}',[WishListController::class,'storeDestroy'])->name('wishList.storeDestroy');
        
        Route::get('/car/search',[CarController::class,'search'])->name('car.search');
        // This Route to Accsess to all Method in this controller (CarController)
        Route::resource('car', CarController::class)->except(['show']);
        
        Route::get('/car/{car}', [CarController::class, 'show'])->name('car.show');
        // This Route to Accsess to carImages Method in the carController 
        Route::get('/car/{car}/images',[CarController::class,'carImages'])->name('car.images');
        Route::put('/car/{car}/images',[CarController::class,'updateImages'])->name('car.updateImages');
        Route::post('/car/{car}/images',[CarController::class,'addImages'])->name('car.addImages');
        // This route to enable user to rate the car
        Route::post('/cars/{car}/rating',[CarRatingController::class ,'store'])->name('rate.store');
        // These routes for profile 
        Route::get('/profile',[ProfileController::class,'index'])->name('profile.index');
        Route::put('/profile',[ProfileController::class,'update'])->name('profile.update');
        Route::put('/profile/password',[ProfileController::class,'updatePasssword'])->name('profile.updatePassword');
        //orders Route 
        Route::get('/owner/purchase-requests/pending', [HomeController::class, 'showPendingPurchaseRequests'])->name('owner.purchase-requests.pending');
        Route::post('/purchase-requests', [CarController::class, 'storePurchaseRequest'])->name('purchase-requests.store');

        Route::post('/purchase-requests/{request}/approve', [HomeController::class, 'approvePurchaseRequest'])->name('purchase-requests.approve');
        Route::post('/purchase-requests/{request}/reject', [HomeController::class, 'rejectPurchaseRequest'])->name('purchase-requests.reject');

        Route::get('/my-purchase-requests', [HomeController::class, 'myRequests'])->name('purchase_requests.myRequests');

        Route::get('/orders/create', [CarController::class, 'createOrder'])->name('orders.create');
        Route::post('/orders/store', [CarController::class, 'storeOrder'])->name('orders.store');

        Route::get('/my-orders',[HomeController::class,'showOrder'])->name('car.order');

        // to display all oreder for owner to approve or decline 
        Route::get('/owner/orders/completed', [HomeController::class, 'showCompletedOrders'])->name('car.sales');
    });
});
Route::post('/car/phone/{car}',[CarController::class,'showPhone'])->name('car.showPhone');
Route::get('/car/search', [CarController::class, 'search'])->name('car.search');


// Every route that is related to authentication and the user I am going to put in auth.php
require __DIR__ . '/auth.php';
