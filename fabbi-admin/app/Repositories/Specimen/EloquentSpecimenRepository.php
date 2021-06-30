<?php

namespace App\Repositories\Specimen;


use App\Repositories\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentSpecimenRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentSpecimenRepository extends EloquentBaseRepository implements SpecimenRepository
{
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
