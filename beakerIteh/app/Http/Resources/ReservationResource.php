<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'reservation';
    public function toArray(Request $request)//: array
    {
       // return parent::toArray($request);
       return[
        'id'=>$this->resource->id,
        'pickup_date'=>$this->resource->pickup_date,
        'return_date'=>$this->resource->return_date,
        /*
        'user_id'=>$this->resource->user_id,
        'vehicle_id'=>$this->resource->vehicle_id
        */
        
        /*
        Ako hocemo da nam vraca objekte i sve njihove pdatke iz tabele
        */
        'user' => new UserResource($this->resource->user),
        'vehicle' => new VehicleResource($this->resource->vehicle)



        
        

    ];

    }
}
