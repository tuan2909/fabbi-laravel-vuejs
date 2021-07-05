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
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getDataPatients($keyword)
    {
        $query = $this->model->with('cities');
        if ($keyword) {
            $query = $query->where('patients.full_name', 'like', '%' . $keyword . '%');
        }
        $result = $query->orderByDesc('id')->get();

        return $result;
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
        $query = $this->model->with('cities')
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

    public function getParentPatients($number)
    {
        $result = $this->model->where('type_patient', '=', $number)->get();

        dd($result);
    }
}
