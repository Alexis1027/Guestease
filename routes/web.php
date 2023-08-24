<?php

use App\Models\GuestHouse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\GuestHouseController;

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

Route::get('/about', [HomeController::class, 'about']);
Route::get('/map', [HomeController::class, 'map']);
Route::get('/reservations', [HomeController::class, 'reservations'])->middleware('auth');
Route::get('/payment/{room}', [HomeController::class, 'payment'])->middleware('auth');
Route::get('/guidelines', [HomeController::class, 'guidelines']);
Route::get('/rules', [HomeController::class, 'rules']);

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'authenticate']);
Route::get('/register', [UserController::class, 'register']);
Route::post('/create/user', [UserController::class, 'store']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/account', [UserController::class, 'account']);

Route::post('/wishlist/save', [WishlistController::class, 'store'])->middleware('auth');
Route::delete('/wishlist/unsave',[WishlistController::class, 'destroy'])->middleware('auth');
Route::get('/wishlist', [WishlistController::class, 'index'])->middleware('auth');

Route::get('/create/admin', [AdminController::class, 'createAdmin']);
Route::get('/dashboard', [AdminController::class, 'dashboard']);
Route::get('/edit/guesthouse', [AdminController::class, 'edit']);
Route::get('/manage/guesthouses', [AdminController::class, 'manage_guesthouses']);
Route::get('/manage/guesthouses/{entry}', [AdminController::class, 'manage_guesthouses_entry']);

Route::delete('/delete/guesthouse/{id}', [GuestHouseController::class, 'destroy']);

Route::post('/rooms/rate/{guesthouse_id}', [RatingController::class, 'store'])->middleware('auth');

Route::get('/manage/users', [AdminController::class, 'manage_users']);