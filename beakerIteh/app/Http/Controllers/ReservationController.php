<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationCollection;
use Illuminate\Http\Request;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::all();
       // return ReservationResource::collection($reservations);
        return new ReservationCollection($reservations);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'pickup_date' => 'required|date',
            'return_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',

        ]);


        if ($validator ->fails()) {
            return response()->json($validator->errors());
        }

        $reservation=Reservation::create([
            'pickup_date'=>$request->pickup_date,
            'return_date'=>$request->return_date,
            'user_id' => Auth::id(),
            'vehicle_id'=>$request->vehicle_id,
            
            
        ]);

        return response()->json(['Reservation is created successfully.', new ReservationResource($reservation)]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return new ReservationResource($reservation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validator = Validator::make($request->all(), [
            'pickup_date' => 'required|date',
            'return_date' => 'required|date',
            'vehicle_id' => 'required|exists:vehicles,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // 422 Unprocessable Entity
        }
    
        $reservation->pickup_date = $request->pickup_date;
        $reservation->return_date = $request->return_date;
        $reservation->vehicle_id = $request->vehicle_id;
    
        $reservation->save();
    
        return response()->json(['message' => 'Reservation updated successfully', 'data' => new ReservationResource($reservation)], 200);
    }
       /*
        $validator = Validator::make($request->all(),[
            'pickup_date'=>'required|date',
            'return_date'=>'required|date',
            'vehicle_id'=>'required',

        ]);

        if ($validator ->fails()) {
            return response()->json($validator->errors());
        }

        $reservation->pickup_date = $request->pickup_date;
        $reservation->return_date = $request->return_date;
        $reservation->vehicle_id = $request->vehicle_id;
        
        $reservation->save();

        return response()->json('Reservation updated successfully', new ReservationResource($reservation));
    }
        */
    
     // Remove the specified resource from storage.
     
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json('Reservation deleted successfully');
        
       


    }
    
}
