<?php

namespace App\Repositories\TypePatient;


use App\Repositories\EloquentBaseRepository;


/**
 * Class EloquentHealthPatientRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentTypePatientRepository extends EloquentBaseRepository implements TypePatientRepository
{
    public function getDataTypePatient($keyWord)
    {

        $query = $this->model;
        if ($keyWord) {
            $query = $query->where('type_patients.name', 'like', '%' . $keyWord . '%');
        }
        $result = $query->orderByDesc('type_patients.created_at')->get();

        return $result;
    }
}
