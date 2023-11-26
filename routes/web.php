<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Guest\RatingController;
use App\Http\Controllers\Owner\OwnerListingController;
use App\Http\Controllers\Guest\WishlistController;
use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ListingRequestController;
use App\Http\Controllers\Guest\GuestReservationController;
use App\Http\Controllers\Owner\OwnerViewController;
use App\Http\Controllers\Owner\OwnerReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {

    //owner
    Route::middleware(['owner'])->group(function () {
        Route::get('/owner/dashboard', [OwnerViewController::class, 'dashboard']);
        Route::get('/owner/listings/{entry?}', [OwnerListingController::class, 'index']);
        Route::get('/owner/reservations/{entry?}', [OwnerReservationController::class, 'index']);
        Route::put('/owner/update-reservation/{reservation}', [OwnerReservationController::class, 'update']);
        Route::get('/owner/create-listing', [OwnerListingController::class, 'create']);
        Route::get('/owner/edit-listing/{listing}', [OwnerListingController::class, 'edit']);
        Route::post('/owner/createListing', [OwnerListingController::class, 'store']);
        Route::put('/owner/update-listing/details/{listing}', [OwnerListingController::class, 'update_details']);
        Route::put('/owner/update-listing/photos/{listing}', [OwnerListingController::class, 'update_photos']);
        Route::put('/owner/update-listing/property/{listing}', [OwnerListingController::class, 'update_property']);
        Route::put('/owner/update-listing/pricing/{listing}', [OwnerListingController::class, 'update_pricing']);
        Route::put('/owner/update-listing/rules/{listing}', [OwnerListingController::class, 'update_rules']);
        Route::delete('/owner/delete-listing/{listing}', [OwnerListingController::class, 'destroy']);
    });

    //admin
    Route::middleware(['admin'])->group(function () {
        Route::delete('/admin/delete-listing/{listing}', [AdminListingController::class, 'destroy']);
        Route::put('/admin/update-listing/{listing}', [AdminListingController::class, 'update']);
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin-dashboard');
        Route::delete('/admin/delete-user/{user}', [UserController::class, 'destroy']);
        Route::get('/admin/create-admin', [AuthController::class, 'create_admin']);
        Route::post('/admin/create-admin', [AuthController::class, 'store_admin']);
        Route::get('/admin/manage-users/{entry?}', [UserController::class, 'index'])->name('manage_users');
        Route::get('/admin/manage-listings/{entry?}', [AdminListingController::class, 'index'])->name('manage_listing');
        Route::get('/admin/manage-reservations/{entry?}', [AdminReservationController::class, 'index']);
        Route::get('/admin/listing-requests/{entry?}', [ListingRequestController::class, 'index']);
        Route::put('/admin/approve-listing/{listing}', [ListingRequestController::class, 'approve']);
        Route::put('/admin/reject-listing/{listing}', [ListingRequestController::class, 'reject']);
    });

    //guest
    Route::middleware(['guest'])->group(function () {
        Route::post('/reserve/{listing}', [GuestReservationController::class, 'store']);
        Route::get('/confirm-reservation/{listing}', [GuestReservationController::class, 'confirm_reservation']);
        Route::post('/wishlist/save', [WishlistController::class, 'store']);
        Route::delete('/wishlist/unsave',[WishlistController::class, 'destroy']);
        Route::get('/wishlists', [WishlistController::class, 'index']);
        Route::post('/rate-listing/{listing_id}', [RatingController::class, 'store']);
        Route::put('/reservations/cancel/{reservation}', [GuestReservationController::class, 'cancel']);
        Route::get('/reservations', [GuestReservationController::class, 'index'])->name('reservations');
    });

    Route::get('/account', [AccountController::class, 'index'])->middleware('auth');
    Route::post('/account/update-profile_pic', [AccountController::class, 'update_profile_pic']);
    Route::put('/account/update', [AccountController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('PreventBackHistory');

});

//kung wala ni login ang user
Route::get('/room/{listing}', [HomeController::class, 'show']);
Route::get('/guidelines', [HomeController::class, 'guidelines']);
Route::get('/rules', [HomeController::class, 'rules']);
Route::get('/profile/{user}', [HomeController::class, 'profile']);
Route::get('/',[HomeController::class, 'index']);
Route::get('/contact-us', [HomeController::class, 'contact_us']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/map', [HomeController::class, 'map']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/verify', [AuthController::class, 'verify']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/forgot-password', [AuthController::class, 'forgot_password']);
Route::get('/createGuest', [AuthController::class, 'create_guest']);
Route::get('/createOwner', [AuthController::class, 'create_owner']);
Route::post('/validate/user', [AuthController::class, 'validate_credentials']); 
Route::post('/create/user', [AuthController::class, 'store_user']);
