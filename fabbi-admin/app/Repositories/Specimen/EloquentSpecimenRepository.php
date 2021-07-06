<?php

namespace App\Repositories\Specimen;


use App\Enums\Constant;
use App\Repositories\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentSpecimenRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentSpecimenRepository extends EloquentBaseRepository implements SpecimenRepository
{
    public function checkSpecimenPatient($data)
    {

        if (isset($data['id']) && !empty($data['id'])) {
            $result = $this->model
                ->where('quarantine_id', '=', $data['id'])
                ->where('result_test', '=', Constant::STATUS_NEGATIVE)
                ->count();

            return $result;
        }
    }

    public function getPatientSpecimen($data)
    {
        $query = DB::table('specimens')
            ->join('quarantine_patients', 'specimens.quarantine_id', '=', 'quarantine_patients.id')
            ->leftJoin('patients', 'quarantine_patients.patient_id', '=', 'patients.id')
            ->select('specimens.*', 'patients.id as patient_id', 'patients.full_name as patient_name');
        if (isset($data['keyword']) && !empty($data['keyword'])) {
            $query = $query->where('patients.full_name', 'like', '%' . $data['keyword'] . '%');
        }
        $result = $query->orderByDesc('id')->get();

        return $result;
    }


}
