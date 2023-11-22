<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Guest\RatingController;
use App\Http\Controllers\Owner\ListingController;
use App\Http\Controllers\Guest\WishlistController;
use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ListingRequestController;
use App\Http\Controllers\Guest\GuestReservationController;
use App\Http\Controllers\Owner\OwnerViewController;
use App\Http\Controllers\Owner\OwnerReservationController;
use App\Http\Controllers\Guest\ReservationRequestController;
use App\Models\Listing;

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

//owner
// Route::middleware(['auth', 'owner'])->group(function () {
    Route::get('/owner/dashboard', [OwnerViewController::class, 'dashboard']);
    Route::get('/owner/calendar', [OwnerViewController::class, 'calendar']);
    Route::get('/owner/calendar/{listing}', [OwnerViewController::class, 'calendar']);
    Route::get('/owner/listings', [ListingController::class, 'index']);
    Route::get('/owner/reservations/{entry?}', [OwnerReservationController::class, 'index']);
    Route::put('/owner/update-reservation/{reservation}', [OwnerReservationController::class, 'update']);
    Route::get('/owner/create-listing', [ListingController::class, 'create']);
    Route::get('/owner/edit-listing/{listing}', [ListingController::class, 'edit']);
    Route::post('/owner/createListing', [ListingController::class, 'store']);
    Route::put('/owner/update-listing/details/{listing}', [ListingController::class, 'update_details']);
    Route::put('/owner/update-listing/photos/{listing}', [ListingController::class, 'update_photos']);
    Route::put('/owner/update-listing/property/{listing}', [ListingController::class, 'update_property']);
    Route::put('/owner/update-listing/pricing/{listing}', [ListingController::class, 'update_pricing']);
    Route::put('/owner/update-listing/rules/{listing}', [ListingController::class, 'update_rules']);
    Route::delete('/owner/delete-listing/{listing}', [ListingController::class, 'destroy']);
// });

//admin
// Route::middleware(['auth', 'admin'])->group(function () {
    Route::delete('/admin/delete-listing/{listing}', [AdminListingController::class, 'destroy']);
    Route::put('/admin/update-listing/{listing}', [AdminListingController::class, 'update']);
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin-dashboard');
    Route::delete('/admin/delete-user/{user}', [UserController::class, 'destroy']);
    Route::get('/admin/create-admin', [AuthController::class, 'create_admin']);
    Route::post('/admin/create-admin', [AuthController::class, 'store_admin']);
    Route::get('/admin/manage-users/{entry?}', [UserController::class, 'index'])->name('manage_users');
    // Route::get('/admin/manage-users/{entry}', [UserController::class, 'manage_users_entry'])->name('manage_users_entry');
    Route::get('/admin/manage-listings/{entry?}', [AdminListingController::class, 'index'])->name('manage_listing');
    // Route::get('/admin/manage-listings/{entry}', [AdminListingController::class, 'manage_listing_entry']);
    Route::get('/admin/manage-reservations/{entry?}', [AdminReservationController::class, 'index']);
    Route::get('/admin/listing-requests/{entry?}', [ListingRequestController::class, 'index']);
    Route::put('/admin/approve-listing/{listing}', [ListingRequestController::class, 'approve']);
    Route::put('/admin/decline-listing/{listing}', [ListingRequestController::class, 'decline']);
// });

// Route::get('/data-table/{entry?}', [AdminListingController::class, 'data_table']);

//guest
Route::middleware(['auth'])->group(function () {
    Route::post('/reserve/{listing}', [GuestReservationController::class, 'store']);
    Route::get('/confirm-reservation/{listing}', [HomeController::class, 'confirm_reservation']);
    Route::get('/reservation-history', [HomeController::class, 'reservation_history']);
    Route::post('/wishlist/save', [WishlistController::class, 'store']);
    Route::delete('/wishlist/unsave',[WishlistController::class, 'destroy']);
    Route::get('/wishlists', [WishlistController::class, 'index']);
    Route::post('/rate-listing/{listing_id}', [RatingController::class, 'store']);
    Route::put('/reservations/cancel/{reservation}', [GuestReservationController::class, 'cancel']);
    Route::get('/reservations', [HomeController::class, 'reservations'])->name('reservations');
    Route::get('/notifications', [HomeController::class, 'notifications']);
    Route::get('/account', [HomeController::class, 'account'])->middleware('auth');
    Route::put('/account/update-profile_pic', [UserController::class, 'update_profile_pic']);
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
Route::get('/sendVerificationCode', [AuthController::class,'sendVerificationCode']);
Route::get('/verifyVerificationCode', [AuthController::class, 'verifyVerificationCode']);

//authentication
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/verify', [AuthController::class, 'verify']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/forgot-password', [AuthController::class, 'forgot_password']);
Route::get('/createGuest', [AuthController::class, 'create_guest']);
Route::get('/createOwner', [AuthController::class, 'create_owner']);
Route::post('/validate/user', [AuthController::class, 'validate_credentials']); //storeUser
Route::post('/create/user', [AuthController::class, 'store_user']); //storeUser
Route::post('/logout', [AuthController::class, 'logout'])->middleware('PreventBackHistory');
Route::put('/profile/update', [UserController::class, 'update']);
// Route::post('/create/owner', [AuthController::class, 'validate_credentials']); //storeOwner
// Route::get('/about', function() {
//     return Inertia::render('About');
// });