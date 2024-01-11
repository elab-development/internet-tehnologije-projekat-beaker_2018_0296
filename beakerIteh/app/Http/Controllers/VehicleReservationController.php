<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Resources\ReservationCollection;

class VehicleReservationController extends Controller
{
    function index($vehicle_id)  {
        /*
        $reservations = Reservation::get()->where('vehicle_id', $vehicle_id);
        if (is_null($reservations)) {
            return response()->json('Data not found', 404);
            
            
        }
        return response()->json($reservations);
        */

        $reservations = Reservation::where('vehicle_id', $vehicle_id)->get();

        if ($reservations->isEmpty()) {
            return response()->json('Data not found', 404);
        }

        return new ReservationCollection($reservations);

    }
}
