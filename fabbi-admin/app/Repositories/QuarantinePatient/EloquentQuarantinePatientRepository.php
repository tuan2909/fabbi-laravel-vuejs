<?php

namespace App\Repositories\QuarantinePatient;


use App\Repositories\EloquentBaseRepository;

/**
 * Class EloquentQuarantinePatientRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentQuarantinePatientRepository extends EloquentBaseRepository implements QuarantinePatientRepository
{
    public function getDataQuarantines($id)
    {
        $result = $this->model->with('patients')->orderByDesc('id')->get();

        return $result;
    }
}
