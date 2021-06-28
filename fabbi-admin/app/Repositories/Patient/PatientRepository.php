<?php

namespace App\Repositories\Patient;

use App\Repositories\BaseRepository;

/**
 * HealthPatientRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface PatientRepository extends BaseRepository
{
    public function getDataPatients();

    public function getPatientBy($id);

    public function updateTypePatient($patientId, $typeId);
}
