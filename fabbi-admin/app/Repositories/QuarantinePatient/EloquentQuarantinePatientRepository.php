<?php

namespace App\Repositories\QuarantinePatient;


use App\Enums\Constant;
use App\Repositories\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentQuarantinePatientRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentQuarantinePatientRepository extends EloquentBaseRepository implements QuarantinePatientRepository
{
    public function getDataQuarantines($data)
    {
        $query = DB::table('quarantine_patients')
            ->join('patients', 'quarantine_patients.patient_id', '=', 'patients.id')
            ->select('patients.id', 'patients.full_name', 'quarantine_patients.*');

        if (isset($data['keyword']) && !empty($data['keyword'])) {
            $query = $query->where('patients.full_name', 'like', '%' . $data['keyword'] . '%');
        }
        $result = $query->orderByDesc('quarantine_patients.id')->get();

        return $result;
    }

    public function getPatientsQuarantine()
    {
        $result = $this->model->with('patients')
            ->where('status', '!=', Constant::STATUS_OUT_QUARANTINE)
            ->orderByDesc('id')
            ->distinct()
            ->get();

        return $result;
    }
}
