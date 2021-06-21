<?php

namespace App\Repositories\HealthPatient;

use App\Repositories\BaseRepository;

/**
 * HealthPatientRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface HealthPatientRepository extends BaseRepository
{
    public function deleteHealthPatient($column, $idPatient);

}
