<?php

namespace App\Repositories\Patient;


use App\Enums\Constant;
use App\Repositories\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;


/**
 * Class EloquentHealthPatientRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentPatientRepository extends EloquentBaseRepository implements PatientRepository
{
    /**
     * Get list data Patient with paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getDataPatients()
    {
        $query = $this->model->with('cities', 'users', 'typePatients')->paginate(Constant::ITEM_PER_PAGE);

        return $query;
    }

    /**
     * Get patient by id.
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getPatientBy($id)
    {
        $query = $this->model->with('cities', 'users', 'typePatients')
            ->where('id', '=', $id)->firstOrFail();

        return $query;
    }

    public function updateTypePatient($patientId, $typeId)
    {
        $result = $this->model->where('id', '=', $patientId)->update([
            'type_id' => $typeId
        ]);

        return $result;
    }
}
