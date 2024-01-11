<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Resources\ReservationCollection;

class UserReservationController extends Controller
{
    function index($user_id)  {
        /*
        $reservations = Reservation::get()->where('user_id', $user_id);
        if (is_null($reservations)) {
            return response()->json('Data not found', 404);
            
            
        }
        return response()->json($reservations);
        */

        $reservations = Reservation::where('user_id', $user_id)->get();

        if ($reservations->isEmpty()) {
            return response()->json('Data not found', 404);
        }

        return new ReservationCollection($reservations);

    }
}
