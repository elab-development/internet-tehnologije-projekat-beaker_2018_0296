<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VehicleTestController;
use App\Http\Controllers\ReservationTestController;
use App\Http\Controllers\UserReservationController;
use App\Http\Controllers\VehicleReservationController;
use App\Http\Resources\UserResource;
use App\Models\Vehicle;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

/*
Prostije rute:
Route::get('vehicle/{id}', [VehicleController::class, 'show']);
Route::get('vehicle', [VehicleController::class, 'index']);

Route:: get('/user',[UserController ::class,'index']);
Route:: get('/user/{id}',[UserController ::class,'show']);

Route::get('reservation/{id}', [ReservationController::class, 'show']);
Route::get('reservation', [ReservationController::class, 'index']);
*/

Route::resource('vehicles', VehicleController::class);

Route::resource('users', UserController::class);

Route::resource('reservations', ReservationController::class);


Route::get('/users/{id}/reservations',[UserReservationController::class, 'index'])->name('user.reservation.index');
Route::get('/vehicles/{id}/reservations',[VehicleReservationController::class, 'index'])->name('vehicle.vehicle.index');

/*
Drugi nacin:
Route::resource('user.reservation', UserReservationController::class)->only(['index']);
Route::resource('vehicle.reservation', VehicleReservationController::class)->only(['index']);
*/