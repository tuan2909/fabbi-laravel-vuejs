<?php

namespace App\Repositories\HealthPatient;


use App\Repositories\EloquentBaseRepository;


/**
 * Class EloquentHealthPatientRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentHealthPatientRepository extends EloquentBaseRepository implements HealthPatientRepository
{
    /**
     * Delete health patient by custom column.
     *
     * @param $column
     * @param $idPatient
     * @return mixed
     */
    public function deleteHealthPatient($column, $idPatient)
    {
        $query = $this->model->where($column, $idPatient)->delete();

        return $query;
    }
}

