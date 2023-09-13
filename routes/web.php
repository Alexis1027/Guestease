<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RoomRequestController;
use App\Http\Controllers\Admin\GuestHouseController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\ReservationRequestController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\GuestHouseRequestController;
use App\Http\Controllers\Owner\ListingController;
use App\Http\Controllers\Owner\OwnerDashboardController;

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


//OWNER
Route::get('/owner/dashboard', [OwnerDashboardController::class, 'dashboard']);
Route::get('/owner/create-listing', [ListingController::class, 'create']);

Route::post('/owner/createListing', [ListingController::class, 'store']);
Route::get('/owner/verify-listing/{guesthouse}', [ListingController::class, 'verify_listing']);
//GUEST
Route::post('/request', [RoomRequestController::class, 'store']);

Route::get('/about', [HomeController::class, 'about']);
Route::get('/map', [HomeController::class, 'map']);
Route::get('/reservations', [HomeController::class, 'reservations'])->middleware('auth')->name('reservations');
Route::get('/payment/{room}', [HomeController::class, 'confirmReservation'])->middleware('auth');
Route::get('/guidelines', [HomeController::class, 'guidelines']);
Route::get('/rules', [HomeController::class, 'rules']);
Route::get('/settings', [HomeController::class, 'settings'])->middleware('auth');
Route::get('/profile/{user}', [HomeController::class, 'profile']);
Route::get('/',[HomeController::class, 'index']);
Route::get('/room/{id}', [HomeController::class, 'show']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/createGuest', [AuthController::class, 'createGuest']);
Route::get('/createOwner', [AuthController::class, 'createOwner']);
Route::post('/create/user', [AuthController::class, 'storeUser']);
Route::post('/create/owner', [AuthController::class, 'storeOwner']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/reserve', [ReservationRequestController::class, 'store']);

Route::post('/wishlist/save', [WishlistController::class, 'store'])->middleware('auth');
Route::delete('/wishlist/unsave',[WishlistController::class, 'destroy'])->middleware('auth');
Route::get('/wishlist', [WishlistController::class, 'index'])->middleware('auth');

//ADMIN
Route::post('/create/guesthouse', [GuestHouseController::class, 'store']);
Route::delete('/delete/guesthouse/{guesthouse}', [GuestHouseController::class, 'destroy']);

Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->middleware('auth')->name('admin-dashboard');

Route::delete('/user/delete/{user}', [UserController::class, 'destroy']);
Route::put('/profile/update', [UserController::class, 'update']);

Route::get('/admin/create-admin', [AdminController::class, 'create']);
Route::get('/admin/edit-guesthouse', [AdminController::class, 'edit']);
Route::get('/admin/manage-users', [UserController::class, 'index'])->name('manage_users');
Route::get('/admin/manage-users/{entry}', [UserController::class, 'manage_users_entry'])->name('manage_users_entry');
Route::get('/admin/manage-guesthouses', [GuestHouseController::class, 'index'])->name('manage_guesthouse');
Route::get('/admin/manage-guesthouses/{entry}', [GuestHouseController::class, 'manage_guesthouses_entry']);
Route::get('/admin/manage-reservations', [ReservationController::class, 'index']);
Route::get('/admin/guesthouse-requests', [GuestHouseRequestController::class, 'requests']);

Route::post('/rooms/rate/{guesthouse_id}', [RatingController::class, 'store'])->middleware('auth');
