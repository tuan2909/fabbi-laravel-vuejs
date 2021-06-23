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
            'user' => [
                'id' => $this->users->id,
                'name' => $this->users->name,
                'role' => $this->users->role,
                'status' => $this->users->status,
            ],
            'type_patient' => [
                'id' => $this->typePatients->id,
                'name' => $this->typePatients->name,
            ],
            'cities' => [
                'id' => $this->cities->id,
                'name' => $this->cities->name,
            ],
        ];
    }
}
