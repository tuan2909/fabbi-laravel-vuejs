<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecimenResource extends JsonResource
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
            'patients' => [
                'id' => $this->patients->id,
                'full_name' => $this->patients->full_name
            ],
            'date_infection' => $this->date_infection,
            'date_draw_blood' => $this->date_draw_blood,
            'date_test' => $this->date_test,
            'result_test' => $this->result_test,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
