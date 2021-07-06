<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent_patient' => $this->parent,
            'full_name' => $this->full_name,
            'citizen_identify' => $this->citizen_identify,
            'gender' => $this->gender,
            'nation' => $this->nation,
            'year_birth' => $this->year_birth,
            'address' => $this->address,
            'number' => $this->number,
            'email' => $this->email,
            'address_start' => $this->address_start,
            'address_end' => $this->address_end,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type_patient' => $this->type_patient,
            'cities' => [
                'id' => $this->cities->id,
                'name' => $this->cities->name,
            ],
        ];
    }
}
