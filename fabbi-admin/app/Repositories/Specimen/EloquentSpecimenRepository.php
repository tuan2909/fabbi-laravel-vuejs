<?php

namespace App\Repositories\Specimen;


use App\Repositories\EloquentBaseRepository;

/**
 * Class EloquentSpecimenRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentSpecimenRepository extends EloquentBaseRepository implements SpecimenRepository
{
    public function getPatientSpecimen()
    {
        $result = $this->model->with('patients')->get();

        return $result;
    }
}
