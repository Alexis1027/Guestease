<?php

use App\Models\User;
use App\Models\GuestHouse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\GuestHouseController;
use App\Http\Controllers\ReservationController;
use Inertia\Inertia;

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

Route::get('/',[GuestHouseController::class, 'index']);
Route::get('/room/{id}', [GuestHouseController::class, 'show']);
Route::post('/create/guesthouse', [GuestHouseController::class, 'store']);
Route::delete('/delete/guesthouse/{guesthouse}', [GuestHouseController::class, 'destroy']);

Route::get('/about', [HomeController::class, 'about']);
Route::get('/map', [HomeController::class, 'map']);
Route::get('/reservations', [HomeController::class, 'reservations'])->middleware('auth')->name('reservations');
Route::get('/payment/{room}', [HomeController::class, 'payment'])->middleware('auth');
Route::get('/guidelines', [HomeController::class, 'guidelines']);
Route::get('/rules', [HomeController::class, 'rules']);
Route::get('/settings', [HomeController::class, 'settings'])->middleware('auth');

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'authenticate']);
Route::get('/createUser', [UserController::class, 'createUser']);
Route::get('/createOwner', [UserController::class, 'createOwner']);
Route::post('/create/user', [UserController::class, 'storeUser']);
Route::post('/create/owner', [UserController::class, 'storeOwner']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/account', [UserController::class, 'account']);
Route::delete('/user/delete/{user}', [UserController::class, 'destroy']);
Route::get('/profile/{user}', [HomeController::class, 'profile']);

Route::post('/reserve', [ReservationController::class, 'store']);

//wishlist
Route::post('/wishlist/save', [WishlistController::class, 'store'])->middleware('auth');
Route::delete('/wishlist/unsave',[WishlistController::class, 'destroy'])->middleware('auth');
Route::get('/wishlist', [WishlistController::class, 'index'])->middleware('auth');

Route::get('/create/admin', [AdminController::class, 'createAdmin']);
Route::get('/dashboard', [AdminController::class, 'dashboard']);
Route::get('/edit/guesthouse', [AdminController::class, 'edit']);
Route::get('/manage/users', [AdminController::class, 'manage_users'])->name('manage_users');
Route::get('/manage/users/{entry}', [AdminController::class, 'manage_users_entry'])->name('manage_users_entry');
Route::get('/manage/guesthouses', [AdminController::class, 'manage_guesthouses'])->name('manage_guesthouse');
Route::get('/manage/guesthouses/{entry}', [AdminController::class, 'manage_guesthouses_entry']);
Route::get('/manage/reservations', [AdminController::class, 'manage_reservations']);
Route::get('/requests', [AdminController::class, 'requests']);

Route::post('/rooms/rate/{guesthouse_id}', [RatingController::class, 'store'])->middleware('auth');
