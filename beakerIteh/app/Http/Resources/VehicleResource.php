<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'vehicle';
     public function toArray(Request $request)//: array
    {
        //return parent::toArray($request);
        return[
            'id'=>$this->resource->id,
            'manufacturer'=>$this->resource->manufacturer,
            'model'=>$this->resource->model,
            'year'=>$this->resource->year,
            'capacity'=>$this->resource->capacity,
            'rental_price'=>$this->resource->rental_price,
            'available'=>$this->resource->available


        ];
    }
}
